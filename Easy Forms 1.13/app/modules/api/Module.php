<?php

namespace app\modules\api;

use yii\base\BootstrapInterface;

/**
 * REST API module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * @var bool Disabled by default
     */
    public $isEnabled = false;

    /**
     * @var bool Disabled by default
     */
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->modules = [
            'v1' => [
                'class' => 'app\modules\api\modules\v1\Module',
            ],
        ];
    }

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            'api/v1/forms/<id:\\d[\\d,]*>/submissions' => 'api/v1/form/submissions',
            ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user'],
            ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/form'],
            ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/webhook'],
        ], false);
    }
}
