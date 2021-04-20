<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.12
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\helpers;

use app\components\liquid\filters\DateFilters;
use app\components\liquid\Template;

/**
 * Class Liquid
 * @package app\helpers
 */
class Liquid
{
    /**
     * Render a liquid template
     *
     * @param $source
     * @param array $assigns
     * @param null $filters
     * @param array $registers
     * @return string
     */
    public static function render($source, $assigns = [], $filters = null, $registers = [])
    {
        try {
            $template = new Template();
            $template->registerFilter(new DateFilters());
            $template->parse($source);
            return $template->render($assigns, $filters, $registers);
        } catch (\Exception $e) {
            \Yii::error($e);
        }
    }

    public static function format($data)
    {

        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $value = is_array($value) ? implode(', ', $value) : $value;
                $text = str_replace("{{".$key."}}", $value, $text);
            } else {
                $text = str_replace("{{".$key."}}", '', $text);
            }
        }
    }
}
