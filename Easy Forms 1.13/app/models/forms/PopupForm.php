<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.5
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\models\forms;

use Yii;

class PopupForm extends \yii\base\Model
{
    public $button_text;
    public $button_placement;
    public $button_color;
    public $popup_width;
    public $popup_padding;
    public $popup_margin;
    public $popup_radius;
    public $animation_effect;
    public $animation_duration;
    public $popup_color;
    public $overlay_color;

    public function rules()
    {
        return [
            [
                [
                    'button_text',
                    'button_placement',
                    'button_color',
                    'popup_width',
                    'popup_margin',
                    'popup_padding',
                    'popup_radius',
                    'animation_effect',
                    'animation_duration',
                    'popup_color',
                    'overlay_color'
                ],
                'required'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'button_text' => Yii::t('app', 'Button Text'),
            'button_placement' => Yii::t('app', 'Button Placement'),
            'button_color' => Yii::t('app', 'Button Color'),
            'popup_width' => Yii::t('app', 'Popup Width'),
            'popup_margin' => Yii::t('app', 'Popup Margin'),
            'popup_padding' => Yii::t('app', 'Popup Padding'),
            'popup_radius' => Yii::t('app', 'Popup Radius'),
            'animation_effect' => Yii::t('app', 'Animation Effect'),
            'animation_duration' => Yii::t('app', 'Animation Duration'),
            'popup_color' => Yii::t('app', 'Popup Color'),
            'overlay_color' => Yii::t('app', 'Overlay Color'),
        ];
    }
}