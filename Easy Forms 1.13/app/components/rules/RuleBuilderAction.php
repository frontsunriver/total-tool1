<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.9.1
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\rules;

use Yii;
use Closure;
use yii\base\Action;
use yii\web\Response;

class RuleBuilderAction extends Action
{
    /**
     * @var Closure the output callback function
     */
    public $output;

    /**
     * @inheritdoc
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $func = $this->output;
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            if (empty($id)) {
                $id = Yii::$app->request->get('id');
            }
        }
        if (is_callable($func)) {
            return $func($id);
        }
        return '';
    }


}
