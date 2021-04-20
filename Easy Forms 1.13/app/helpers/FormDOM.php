<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\helpers;

use DOMDocument;
use DOMXPath;
use Exception;
use Yii;
use yii\helpers\Json;

/**
 * Class FormDOM
 * @package app\helpers
 */
class FormDOM
{
    /*
     * Public properties
     */

    // Arrays
    public $form; // Form with all fields

    /*
     * Protected properties
     */
    /** @var \DOMDocument */
    protected $dom;
    /** @var \DOMXPath  */
    protected $xpath;

    public function __construct()
    {

        $this->dom = new DOMDocument;
        libxml_use_internal_errors(true); // Because it doesn't support html5 tags like canvas
        $this->dom->preserveWhiteSpace = false;
        $this->form = ['fields' => array()];
    }

    /**
     * @param string $html
     * @return $this
     * @throws \Exception
     */
    public function loadHTML($html = "")
    {
        try {
            // The HTML is UTF-8 encoded
            $this->dom->loadHTML(mb_convert_encoding('<?xml encoding="UTF-8">' . $html, 'HTML-ENTITIES', 'UTF-8'));
            $this->dom->encoding = 'UTF-8';
            libxml_clear_errors(); // Because it doesn't support html5 tags like canvas
        } catch (Exception $e) {
            $search = array(
                'DOMDocument::loadHTML():',
                'Entity',
            );
            $replace = array(
                Yii::t('app', 'Check your code:'),
                Yii::t('app', 'Form'),
            );
            $message = str_replace($search, $replace, $e->getMessage());
            throw new Exception($message, 5);
        }
        return $this;
    }

    /**
     * Load the DOMXPath Object
     */
    public function loadXpath()
    {
        $this->xpath = new DOMXPath($this->dom);
        return $this;
    }

    /**
     * Load All Form Fields array
     *
     * @param string $tagNames
     * @return $this
     * @throws Exception
     */
    public function loadFields($tagNames = '*')
    {
        // Validate Html
        // Script Tags are not allowed
        foreach(iterator_to_array($this->dom->getElementsByTagName("script")) as $node) {
            throw new \Exception(Yii::t('app', 'Your form should not contain "script" tags.'));
        };

        // Html Event Attributes (whose name starts by "on") are not allowed
        $onAttributes = $this->xpath->query("//*/@*[starts-with(name(), 'on')]");
        foreach ($onAttributes as $onAttribute) {
            throw new \Exception(Yii::t('app', 'Your form should not contain HTML Event Attributes.'));
        }

        if ($tagNames === '*') {
            $this->loadAllFields();
        } elseif (is_array($tagNames)) {
            foreach ($tagNames as $tagName) {
                $this->loadFieldsByTagName($tagName);
            }
        }
        return $this;
    }

    /**
     * Load Form Fields array with DOM elements of same html tag
     *
     * @param $tagName
     * @return $this
     */
    public function loadFieldsByTagName($tagName)
    {
        $elements = $this->dom->getElementsByTagName($tagName); // The form

        if ($elements->length > 0) {

            foreach ($elements as $element) { // For each input

                $this->addElementToFields($element);

            }
        }

        return $this;
    }

    /**
     * Load Form Fields array with DOM elements
     *
     * @return $this
     */
    public function loadAllFields()
    {
        $elements = $this->dom->getElementsByTagName('*'); // All dom elements

        if ($elements->length > 0) {

            foreach ($elements as $element) {

                // Only add form fields
                if (in_array($element->tagName, array("input", "textarea", "select", "button"))) {
                    // Exclude external elements
                    if (!$element->hasAttribute('data-exclude')) {
                        $this->addElementToFields($element);
                    }
                }

            }
        }

        return $this;
    }

    /**
     * Add DOM element to the form fields
     *
     * @param $element \DOMElement
     */
    public function addElementToFields($element)
    {
        $field = array();

        /**
         * Field tagName
         */
        if ($element->tagName) {
            $field['tagName'] = $element->tagName;
        }

        /**
         * Field attributes
         */
        if ($element->hasAttribute('type')) {
            $field['type'] = $element->getAttribute('type');
            // Checkbox or Radio
            if ($field['type'] == "checkbox" || $field['type'] == "radio") {
                // Find Group label
                // Remove square brackets from name, if exist
                $name = str_replace("[]", "", $element->getAttribute('name'));
                foreach ($this->xpath->query('//label[@for="'.$name.'"]') as $label) {
                    $field['groupLabel'] = trim(strlen($label->nodeValue) > 0 ?  $label->nodeValue : "");
                }
            }
        }
        if ($element->hasAttribute('name')) {
            $field['name'] = $element->getAttribute('name');
            // Checkbox or Select List or File
            if ($element->getAttribute('type') == "checkbox"
                || $element->getAttribute('type') == "file"
                || $element->tagName == "select") {
                // Remove square brackets from name
                $field['name'] = str_replace("[]", "", $field['name']);
            }
        }
        if ($element->hasAttribute('id')) {
            $field['id'] = $element->getAttribute('id');
            // Find label by id
            foreach ($this->xpath->query('//label[@for="'.$element->getAttribute('id').'"]') as $label) {
                $field['label'] = trim(strlen($label->nodeValue) > 0 ?  $label->nodeValue : "");
            }
        }
        if ($element->hasAttribute('value')) {
            $field['value'] = $element->getAttribute('value');
        }
        if ($element->hasAttribute('class')) {
            $field['class'] = $element->getAttribute('class');
        }
        if ($element->hasAttribute('maxlength')) {
            $field['maxlength'] = $element->getAttribute('maxlength');
        }
        if ($element->hasAttribute('readonly')) {
            $field['readonly'] = true;
        }
        if ($element->hasAttribute('disabled')) {
            $field['disabled'] = true;
        }
        if ($element->hasAttribute('checked')) {
            $field['checked'] = true;
        }
        if ($element->getLineNo()) {
            $field['lineNumber'] = $element->getLineNo();
        }
        if ($element->tagName == "button") {
            $field['value'] = empty($element->nodeValue) ? $field['label'] : $element->nodeValue;
        }
        // Image
        if ($element->tagName == "input" && $field['type'] == "image") {
            if (!empty($field['label'])) {
                $field['value'] = $field['label'];
            }
        }
        if ($element->tagName == "select") {
            // Find label by name (not match by id)
            if ($element->getAttribute('name')) {
                foreach ($this->xpath->query('//label[@for="'.$element->getAttribute('name').'"]') as $label) {
                    $field['label'] = trim(strlen($label->nodeValue) > 0 ?  $label->nodeValue : "");
                }
            }
            // Options
            if ($element->hasChildNodes()) {
                $field['options'] = array();
                /** @var \DOMElement $childElement */
                foreach ($element->childNodes as $childElement) {
                    $child = array();
                    if (isset($childElement->tagName)) {
                        $child['tagName'] = $childElement->tagName;
                        if (isset($childElement->nodeType) && $childElement->nodeType == XML_ELEMENT_NODE) {
                            if ($childElement->hasAttribute('value')) {
                                $child['value'] = $childElement->getAttribute('value');
                            }
                            if ($childElement->hasAttribute('selected')) {
                                $child['selected'] = true;
                            }
                            if ($childElement->nodeValue) {
                                $child['label'] = $childElement->nodeValue;
                            }
                            if ($childElement->getLineNo()) {
                                $child['lineNumber'] = $childElement->getLineNo();
                            }
                        }
                    }
                    if (!empty($child)) {
                        array_push($field['options'], $child);
                    }
                }
            }
        }

        /**
         * HTML5 attributes
         */
        if ($element->hasAttribute('autocomplete')) {
            $field['autocomplete'] = $element->getAttribute('autocomplete');
        }
        if ($element->hasAttribute('novalidate')) {
            $field['novalidate'] = true;
        }
        if ($element->hasAttribute('autofocus')) {
            $field['autofocus'] = true;
        }
        if ($element->hasAttribute('formnovalidate')) {
            $field['formnovalidate'] = true;
        }
        if ($element->hasAttribute('min')) {
            $field['min'] = $element->getAttribute('min');
        }
        if ($element->hasAttribute('max')) {
            $field['max'] = $element->getAttribute('max');
        }
        if ($element->hasAttribute('multiple')) {
            $field['multiple'] = true;
        }
        if ($element->hasAttribute('pattern')) {
            $field['pattern'] = $element->getAttribute('pattern');
        }
        if ($element->hasAttribute('placeholder')) {
            $field['placeholder'] = $element->getAttribute('placeholder');
        }
        if ($element->hasAttribute('required')) {
            $field['required'] = true;
        }
        if ($element->hasAttribute('step')) {
            $field['step'] = $element->getAttribute('step');
        }
        if ($element->hasAttribute('minlength')) {
            $field['minlength'] = $element->getAttribute('minlength');
        }
        if ($element->hasAttribute('maxlength')) {
            $field['maxlength'] = $element->getAttribute('maxlength');
        }
        // For File Input
        if ($element->hasAttribute('accept')) {
            $field['accept'] = $element->getAttribute('accept');
        }

        /**
         * Data attributes
         */
        // For Number Input
        if ($element->hasAttribute('data-integer-only')) {
            $field['data-integer-only'] = $element->getAttribute('data-integer-only');
        }
        // For Number Input
        if ($element->hasAttribute('data-integer-pattern')) {
            $field['data-integer-pattern'] = $element->getAttribute('data-integer-pattern');
        }
        // For Number Input
        if ($element->hasAttribute('data-number-pattern')) {
            $field['data-number-pattern'] = $element->getAttribute('data-number-pattern');
        }
        // For Email Input
        if ($element->hasAttribute('data-check-dns')) {
            $field['data-check-dns'] = $element->getAttribute('data-check-dns');
        }
        // For File Input
        if ($element->hasAttribute('data-min-size')) {
            $field['data-min-size'] = $element->getAttribute('data-min-size');
        }
        // For File Input
        if ($element->hasAttribute('data-max-size')) {
            $field['data-max-size'] = $element->getAttribute('data-max-size');
        }
        // For File Input
        if ($element->hasAttribute('data-min-files')) {
            $field['data-min-files'] = $element->getAttribute('data-min-files');
        }
        // For File Input
        if ($element->hasAttribute('data-max-files')) {
            $field['data-max-files'] = $element->getAttribute('data-max-files');
        }
        // For Hidden Input
        if ($element->hasAttribute('data-label')) {
            $field['data-label'] = $element->getAttribute('data-label');
        }
        // For Text, TextArea, Number, Date, Email and Hidden Input
        if ($element->hasAttribute('data-unique')) {
            $field['data-unique'] = true;
        }
        // For Checkbox
        if ($element->hasAttribute('data-required')) {
            $field['required'] = true;
        }
        // For WebHooks Integration
        if ($element->hasAttribute('data-alias')) {
            $field['alias'] = $element->getAttribute('data-alias');
        }
        // For Matrix
        if ($element->hasAttribute('data-matrix-id')) {
            // Matrix Id
            $field['data-matrix-id'] = $element->getAttribute('data-matrix-id');
            // Matrix Label
            if ($element->hasAttribute('data-matrix-label')) {
                $field['data-matrix-label'] = $element->getAttribute('data-matrix-label');
            }
            // Matrix Statement
            if ($element->hasAttribute('data-matrix-question')) {
                $field['data-matrix-question'] = $element->getAttribute('data-matrix-question');
            }
            // Matrix Answer
            if ($element->hasAttribute('data-matrix-answer')) {
                $field['data-matrix-answer'] = $element->getAttribute('data-matrix-answer');
            }
        }

        array_push($this->form['fields'], $field);
    }

    /**
     * Filter the Form Fields array by column key value
     *
     * @param string $value Filtered value.
     * @param null $column_key Column of values used to filter.
     * @return array The filtered array
     */
    public function fieldFilter($value, $column_key = null)
    {
        $filteredArray = array_filter($this->form['fields'], function ($field) use ($column_key, $value) {
            return isset($field[$column_key]) && $field[$column_key] == $value;
        });
        return $filteredArray;
    }

    /**
     * Search in Form Fields array and return its key
     *
     * @param string $value The searched value.
     * @param string $column_key Column of values where to search.
     * @param string $index_key Column to use as index/keys for returned data.
     * @return string|false Returns key for $value if it is found in the array, FALSE otherwise
     */
    public function fieldSearch($value, $column_key, $index_key = null)
    {
        $key = array_search($value, $this->fieldColumn($column_key, $index_key));
        return $key;
    }

    /**
     * Return values from a single column of the Form Fields array
     *
     * @param string $column_key Column of values to return.
     * @param string $index_key Column to use as index/keys for returned array.
     * @return array Returns an array of values representing a single column from the input array
     */
    public function fieldColumn($column_key, $index_key)
    {
        return array_column($this->form['fields'], $column_key, $index_key);
    }

    /**
     * Get the Form array
     *
     * @return array
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Get the Form array as JSON
     *
     * @return string
     */
    public function getFormAsJSON()
    {
        return Json::encode($this->getForm(), false);
    }

    /**
     * Get Form Title
     *
     * @return string
     */
    public function getFormTitle()
    {
        $headings = $this->dom->getElementsByTagName('h3');
        $heading = $headings->item(0);
        return isset($heading->nodeValue) ? $heading->nodeValue : Yii::t('app', 'Untitled Form');
    }

    /**
     * Get the Form Fields array
     *
     * @return array
     */
    public function getFields()
    {
        return $this->form['fields'];
    }

    /**
     * Get the Form Fields array as JSON string
     *
     * @return string
     */
    public function getFieldsAsJSON()
    {
        return Json::encode($this->getFields());
    }

    /**
     * Get the Form Fields array sorted by lineNumber column
     *
     * @return array
     */
    public function getSortedFields()
    {
        $tmp_fields = $this->form['fields'];
        usort($tmp_fields, function ($fieldA, $fieldB) {
            return $fieldA['lineNumber'] - $fieldB['lineNumber'];
        });
        return $tmp_fields;
    }

    /**
     * Get the Form Fields sorted by lineNumber column array in JSON
     *
     * @return string
     */
    public function getSortedFieldsAsJSON()
    {
        return Json::encode($this->getSortedFields());
    }
}
