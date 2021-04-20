<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.8
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class GridView
 * @package app\components\widgets
 */
class GridView extends \kartik\grid\GridView
{
    /**
     * @inheritdoc
     */
    public function renderSummary()
    {
        $count = $this->dataProvider->getCount();
        if ($count <= 0) {
            return '';
        }
        $summaryOptions = $this->summaryOptions;
        $tag = ArrayHelper::remove($summaryOptions, 'tag', 'div');
        $configItems = [
            'item' => $this->itemLabelSingle,
            'items' => $this->itemLabelPlural,
            'items-few' => $this->itemLabelFew,
            'items-many' => $this->itemLabelMany,
            'items-acc' => $this->itemLabelAccusative,
        ];
        $pagination = $this->dataProvider->getPagination();

        if ($pagination !== false) {
            $totalCount = $this->dataProvider->getTotalCount();
            $begin = $pagination->getPage() * $pagination->pageSize + 1;
            $end = $begin + $count - 1;
            if ($begin > $end) {
                $begin = $end;
            }
            $page = $pagination->getPage() + 1;
            $pageCount = $pagination->pageCount;
            $configSummary = [
                'begin' => $begin,
                'end' => $end,
                'count' => $count,
                'totalCount' => $totalCount,
                'page' => $page,
                'pageCount' => $pageCount,
            ];
            if (($summaryContent = $this->summary) === null) {
                if (!defined('INTL_ICU_VERSION') || INTL_ICU_VERSION < 49) {
                    return Html::tag($tag, Yii::t('app',
                        'Showing <b>{begin}-{end}</b> of <b>{totalCount}</b> items.',
                        $configSummary + $configItems
                    ), $summaryOptions);
                }
                return Html::tag($tag, Yii::t('app',
                    'Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one{{item}} other{{items}}}.',
                    $configSummary + $configItems
                ), $summaryOptions);
            }
        } else {
            $begin = $page = $pageCount = 1;
            $end = $totalCount = $count;
            $configSummary = [
                'begin' => $begin,
                'end' => $end,
                'count' => $count,
                'totalCount' => $totalCount,
                'page' => $page,
                'pageCount' => $pageCount,
            ];
            if (($summaryContent = $this->summary) === null) {
                if (!defined('INTL_ICU_VERSION') || INTL_ICU_VERSION < 49) {
                    return Html::tag($tag, Yii::t('app',
                        'Total <b>{count}</b> items.',
                        $configSummary + $configItems
                    ), $summaryOptions);
                }
                return Html::tag($tag,
                    Yii::t('app', 'Total <b>{count, number}</b> {count, plural, one{{item}} other{{items}}}.',
                        $configSummary + $configItems
                    ), $summaryOptions);
            }
        }

        return Yii::$app->getI18n()->format($summaryContent, $configSummary, Yii::$app->language);
    }

}