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
use yii\helpers\Url;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Class Html
 * @package app\helpers
 * @extends \yii\helpers\Html
 */
class Html extends \yii\helpers\Html
{
    /**
     * Remove scripts tags from html code
     * @param $html
     * @return mixed
     */
    public static function removeScriptTags($html)
    {

        return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
    }

    /**
     * Return Allowed HTML5 Tags
     *
     * @return array
     */
    public static function allowedHtml5Tags()
    {
        return ["<img>", "<del>","<ins>","<br>","<span>",
            "<u>","<b>","<i>","<sup>","<sub>", "<code>","<time>","<abbr>","<q>","<small>",
            "<font>","<strong>","<em>","<a>","<div>","<figcaption>","<figure>","<dd>","<dt>",
            "<dl>","<li>","<ul>","<ol>","<blockquote>","<pre>","<hr>","<p>","<address>",
            "<table>", "<thead>", "<tbody>", "<tr>", "<th>", "<td>"];
    }


    /**
     * Parse HTML code and find form fields
     * Return an array of field names
     *
     * @param $html Html code.
     * @return array List of Field Names
     */
    public static function getFields($html)
    {
        if (!empty($html)) {
            $dom = new DomDocument;
            // Hide Warnings
            libxml_use_internal_errors(true);
            $dom->validateOnParse = false;
            //load the html into the object
            $dom->loadHTML($html);
            //discard white space
            $dom->preserveWhiteSpace = false;
            // Get All dom elements
            $elements = $dom->getElementsByTagName('*');
            $fields = [];
            /* @var $element \DOMElement */
            foreach ($elements as $element) {
                // Only add form elements
                if (in_array($element->tagName, array("input", "textarea", "select"))) {
                    if ($element->hasAttribute('name')) {
                        $name = $element->getAttribute('name');
                        // Checkbox or Select List
                        if ($element->getAttribute('type') == "checkbox"
                            || $element->getAttribute('type') == "file"
                            || $element->tagName == "select") {
                            // Remove square brackets from name
                            $name = str_replace("[]", "", $name);
                        }
                        $fields[$name] = $name;
                    }
                }
            }
            return $fields;
        }
        return [];
    }

    /**
     * Parse HTML code to replace base64 images and store them on a location
     *
     * Steps:
     * 1. Parse HTML code and find images
     * 2. Store each image on the disk
     * 3. Change the src of each image to the new image
     * 4. Return the HTML code linking to the new images
     *
     * @param string $html Html code
     * @param string $location Folder where the images will be stored
     * @return string Html code
     */
    public static function storeBase64ImagesOnLocation($html, $location)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->loadHTML(mb_convert_encoding('<?xml encoding="UTF-8">' . $html, 'HTML-ENTITIES', 'UTF-8'));
        //$dom->loadHtml($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        $search = []; // Base64 Image Urls
        $replace = []; // Image Urls

        /** @var \DOMElement $image */
        foreach($images as $image) {
            $src = $image->getAttribute('src');
            // 1. Parse html to find images
            if(preg_match('/data:image/', $src)){
                $search[] = $src;
                // Get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimeType = $groups['mime'];
                // Generating a random filename
                $fileName = uniqid();
                $fileType = $location . '/' . $fileName . '.' . $mimeType;
                // @see http://image.intervention.io/api/
                Image::make($src)
                    // Resize if required
                    /* ->resize(300, 200) */
                    ->encode($mimeType, 100)  // Encode file to the specified mimetype
                    ->save($fileType); // Save image on disk
                $new_src = Url::base(true) . '/' . $fileType;
                $replace[] = $new_src;
            }
        }

        // Replace images
        return str_replace($search, $replace, $html);
    }
}
