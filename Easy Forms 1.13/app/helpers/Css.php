<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.9
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\helpers;

use Yii;
use yii\helpers\Json;

/**
 * Class CssJson
 * @package app\helpers
 */
class Css
{
    /**
     * Get Google Fonts used in a stylesheet
     *
     * @param $stylesheet
     * @return array
     */
    public static function getUsedGoogleFonts($stylesheet)
    {
        $fonts = self::getFontFamilies($stylesheet);
        $googleFonts = self::getAllGoogleFonts();
        $usedGoogleFonts = [];
        foreach ($fonts as $font) {
            $font = str_replace('"', '', $font);
            if (in_array($font, $googleFonts)) {
                $usedGoogleFonts[] = $font;
            }
        }
        return $usedGoogleFonts;
    }

    /**
     * Get Font Families used in a stylesheet
     *
     * @param $stylesheet
     * @return array
     */
    public static function getFontFamilies($stylesheet)
    {
        $fonts = [];

        foreach ($stylesheet as $cssRule) {
            foreach ($cssRule as $property => $value) {
                if ($property === 'font-family') {
                    $fonts[] = $value;
                }
            }
        }

        return $fonts;
    }

    /**
     * Get All Google Font Families
     *
     * @return array
     */
    public static function getAllGoogleFonts()
    {
        $cache = Yii::$app->cache;
        $key = 'google-fonts';
        $fonts = $cache->get($key);
        if ($fonts === false) {
            // $data is not found in cache, calculate it from scratch
            $googleFontsFile = Yii::getAlias('@app/static_files/js/form.builder/data/google-fonts.json');
            if (is_readable($googleFontsFile)) {
                $googleFonts = json_decode(file_get_contents($googleFontsFile), true);
                if (isset($googleFonts['items'])) {
                    $fonts = $googleFonts['items'];
                }
            }
            $cache->set($key, $fonts);
        }
        return $fonts ? $fonts : [];
    }

    /**
     * Get All Google Font Families
     *
     * @param $googleFontsFileFromApi
     * @return array
     */
    public static function getAllGoogleFontsFromApi($googleFontsFileFromApi)
    {
        $fonts = [];
        if (is_readable($googleFontsFileFromApi)) {
            $googleFonts = json_decode(file_get_contents($googleFontsFileFromApi), true);
            if (isset($googleFonts['items'])) {
                foreach($googleFonts['items'] as $font) {
                    if (isset($font['family'])) {
                        $fonts[] = $font['family'];
                    }
                }
            }
        }
        return $fonts;
    }

    /**
     * Convert Form Builder Styles To CSS Code
     *
     * @param $stylesheet
     * @param string $canvas
     * @param string $form
     * @return string|string[]
     */
    public static function toCss($stylesheet, $canvas = "body", $form = "#form-app")
    {
        $css = self::arrayToCss($stylesheet);
        $css = str_replace(["#canvas form", "#canvas"], [$form, $canvas], $css);
        return $css;
    }

    /**
     * Convert Form Styles to a format similar to an stylesheet.
     *
     * @param $styles
     * @return array
     */
    public static function convertFormStyles($styles) {

        $stylesheet = [];

        if (!empty($styles)) {

            if (is_string($styles)) {
                $styles = Json::decode($styles, true);
            }

            foreach ($styles as $style) {
                if (isset($style['selector'], $style['properties'])) {
                    if (is_array($style['properties']) && !empty($style['properties'])) {
                        $properties = [];
                        foreach ($style['properties'] as $property => $value) {
                            if ($value !== '') {
                                $properties[$property] = $value;
                            }
                        }
                        $stylesheet[$style['selector']] = $properties;
                    }
                }
            }

        }

        return $stylesheet;
    }

    /**
     * Recursive function that generates from a a multidimensional array of CSS rules, a valid CSS string.
     *
     * @param array $rules
     *   An array of CSS rules in the form of:
     *   array('selector'=>array('property' => 'value')). Also supports selector
     *   nesting, e.g.,
     *   array('selector' => array('selector'=>array('property' => 'value'))).
     * @param int $indent
     *
     * @return string A CSS string of rules. This is not wrapped in <style> tags.
     * @source http://matthewgrasmick.com/article/convert-nested-php-array-css-string
     */
    public static function arrayToCss($rules, $indent = 0) {
        $css = '';
        $prefix = str_repeat('  ', $indent);

        foreach ($rules as $key => $value) {
            if (is_array($value)) {
                $selector = $key;
                $properties = $value;

                $css .= $prefix . "$selector {\n";
                $css .= $prefix . self::arrayToCss($properties, $indent + 1);
                $css .= $prefix . "}\n";
            } else {
                $property = $key;
                $css .= $prefix . "$property: $value;\n";
            }
        }

        return $css;
    }
}