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
 * Class RuleEngine
 * @package app\components\rules
 */
class RuleEngine
{

    /**
     * @var array Operators
     */
    public $operators;

    /**
     * @var array Conditions
     */
    public $conditions;

    /**
     * @var array Options
     */
    public $actions;

    /**
     * RuleEngine constructor.
     * @param $rule
     */
    public function __construct($rule)
    {
        $this->conditions = is_string($rule['conditions']) ? json_decode($rule['conditions']) : $rule['conditions'];
        $this->actions = is_string($rule['actions']) ? json_decode($rule['actions']) : $rule['actions'];
        $this->loadOperators();
    }

    /**
     * Load Operators
     */
    public function loadOperators()
    {
        $this->operators = [
            'isPresent' => function ($actual, $target) {
                return !!$actual;
            },
            'isBlank' => function ($actual, $target) {
                return !$actual;
            },
            'equalTo' => function ($actual, $target) {
                return "" . $actual === "" . $target;
            },
            'notEqualTo' => function ($actual, $target) {
                return "" . $actual !== "" . $target;
            },
            'greaterThan' => function ($actual, $target) {
                return floatval($actual) > floatval($target);
            },
            'greaterThanEqual' => function ($actual, $target) {
                return floatval($actual) >= floatval($target);
            },
            'lessThan' => function ($actual, $target) {
                return floatval($actual) < floatval($target);
            },
            'lessThanEqual' => function ($actual, $target) {
                return floatval($actual) <= floatval($target);
            },
            'isIn' => function ($actual, $target) {
                $t = explode('|', $target);
                if (count($t) > 0) {
                    for ($i = 0; $i < count($t); $i++) {
                        if ($actual && false !== strpos($actual, $t[$i])) {
                            return true;
                        }
                    }
                }
                return $actual && false !== strpos($actual, $target);
            },
            'isNotIn' => function ($actual, $target) {
                $t = explode('|', $target);
                if (count($t) > 0) {
                    for ($i = 0; $i < count($t); $i++) {
                        if ($actual && false === strpos($actual, $t[$i])) {
                            return true;
                        }
                    }
                }
                return $actual && false === strpos($actual, $target);
            },
            'startsWith' => function ($actual, $target) {
                return $actual && strpos($actual, $target) === 0;
            },
            'endsWith' => function ($actual, $target) {
                $actualLen = strlen($actual);
                $targetLen = strlen($target);
                if ($targetLen > $actualLen) {
                    return false;
                }    
                return $actual && strpos($actual, $target, $actualLen - $targetLen) !== false;
            },
            'isBefore' => function ($actual, $target) {
                return strtotime($actual) < strtotime($target);
            },
            'isAfter' => function ($actual, $target) {
                return strtotime($actual) > strtotime($target);
            },
            'isChecked' => function ($actual, $target) {
                return !!$actual;
            },
            'isNotChecked' => function ($actual, $target) {
                return !$actual;
            },
            'hasFileSelected' => function ($actual, $target) {
                return !!$actual;
            },
            'hasNoFileSelected' => function ($actual, $target) {
                return !$actual;
            },
            'hasBeenClicked' => function ($actual, $target) {
                return !!$actual;
            },
            'hasBeenSubmitted' => function ($actual, $target) {
                return true;
            }
        ];
    }

    /**
     * Run Rule Builder
     *
     * @param $conditionsAdapter
     * @param $actionsAdapter
     * @param $oppositeAdapter
     */
    public function run($conditionsAdapter, $actionsAdapter, $oppositeAdapter)
    {
        if ($this->matches($conditionsAdapter)) {
            $this->runActions($actionsAdapter);
        } else {
            $this->runOppositeActions($oppositeAdapter, $actionsAdapter);
        }
    }

    /**
     * Run Actions
     *
     * @param $actionsAdapter
     */
    public function runActions ($actionsAdapter) {
        for($i = 0; $i < count($this->actions); $i++) {
            $actionData = $this->actions[$i];
            $actionName = $actionData->value;
            $actionFunction = isset($actionsAdapter[$actionName]) ? $actionsAdapter[$actionName] : null;
            if($actionFunction && is_callable($actionFunction)) {
                $actionFunction(new Finder($actionData));
            }
        }
    }

    /**
     * Run OppositeActions
     *
     * @param $oppositeAdapter
     * @param $actionsAdapter
     */
    public function runOppositeActions ($oppositeAdapter, $actionsAdapter) {
        for($i = 0; $i < count($this->actions); $i++) {
            $actionData = $this->actions[$i];
            if (isset($oppositeAdapter[$actionData->value])) {
                $actionName = $oppositeAdapter[$actionData->value];
                $actionFunction = $actionsAdapter[$actionName];
                if($actionFunction && is_callable($actionFunction)) {
                    $actionFunction(new Finder($actionData));
                }
            }
        }
    }

    /**
     * Matches the Conditions
     *
     * @param $conditionsAdapter
     * @return bool
     */
    public function matches($conditionsAdapter)
    {
        return $this->handleNode($this->conditions, $conditionsAdapter);
    }

    /**
     * Handle a Node
     *
     * @param $node
     * @param $adapter
     * @return bool
     */
    public function handleNode($node, $adapter)
    {
        if (isset($node->all) || isset($node->any) || isset($node->none)) {
            return $this->handleConditionalNode($node, $adapter);
        } else {
            return $this->handleRuleNode($node, $adapter);
        }
    }

    /**
     * Handle a Conditional Node
     *
     * @param $node
     * @param $adapter
     * @return bool
     */
    public function handleConditionalNode($node, $adapter)
    {
        // Type of Condition
        $isAll = isset($node->all) && !!$node->all ? true : false;
        $isAny = isset($node->any) && !!$node->any ? true : false;
        $isNone = isset($node->none) && !!$node->none ? true : false;

        $nodes = [];

        if ($isAll) {
            $nodes = $node->all;
        } else if ($isAny) {
            $nodes = $node->any;
        } else if ($isNone) {
            $nodes = $node->none;
        }

        // If no conditions
        if (count($nodes) === 0) {
            return true;
        }

        $result = false;

        foreach ($nodes as $node) {
            if ($node) {
                $result = $this->handleNode($node, $adapter);
                if ($isAll) {
                    if ($result) {
                        continue;
                    } else {
                        break;
                    }
                } elseif ($isAny) {
                    if ($result) {
                        break;
                    } else {
                        continue;
                    }
                } elseif ($isNone) {
                    if ($result) {
                        return false;
                    } else {
                        $result = true; // Invert result
                        continue;
                    }
                }
            } else {
                return $isNone ? true : $isAll;
            }
        }

        return $result;
    }

    /**
     * Handle a Rule Node
     *
     * @param $node
     * @param $adapter
     * @return bool
     */
    public function handleRuleNode($node, $adapter)
    {
        $value = isset($adapter[$node->name]) ? $adapter[$node->name] : null;
        if (isset($value) && is_callable($value)) {
            $value = $value();
        }
        return $this->compareValues($value, $node->operator, $node->value);
    }

    /**
     * Compare values
     *
     * @param $actual
     * @param $operator
     * @param $value
     * @return bool
     */
    public function compareValues($actual, $operator, $value)
    {
        $operatorFunction = isset($this->operators[$operator]) ? $this->operators[$operator] : null;
        if ($operatorFunction) {
            $actual = is_array($actual) ? implode('|', $actual) : $actual;
            return $operatorFunction($actual, $value);
        }
        return false;
    }
}