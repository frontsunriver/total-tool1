<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.3.8
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\rules;

/**
 * Class Finder
 * @package app\components\rules
 */
class Finder
{
    /**
     * @var object Actions
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Find Field
     *
     * @param $arguments
     * @return null
     */
    public function find($arguments)
    {
        $currentNode = $this->data;
        if (is_array($arguments)) {
            for($i = 0; $i < count($arguments); $i++) {
                $name = $arguments[$i];
                $currentNode = $this->findByName($name, $currentNode);
            }
        } elseif (is_string($arguments)) {
            $currentNode = $this->findByName($arguments, $currentNode);
        }

        return $currentNode ? $currentNode->value : null;
    }

    /**
     * Fiend Field by Name
     *
     * @param $name
     * @param $node
     * @return null
     */
    public function findByName($name, $node)
    {
        $fields = $node->fields;
        for($i = 0; $i < count($fields); $i++) {
            $field = $fields[$i];
            if ($field->name === $name) {
                return $field;
            }
        }
        return null;
    }
}