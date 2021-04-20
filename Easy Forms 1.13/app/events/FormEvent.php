<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.3.4
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\events;

use yii\base\Event;

/**
 * Class FormEvent
 * @package app\events
 */
class FormEvent extends Event
{
    /** @var \app\models\Form */
    public $form;
    /** @var \app\models\FormData */
    public $formData;
    /** @var \app\models\FormData */
    public $oldFormData;
    /** @var  \app\helpers\FormDOM */
    public $formDOM;
    /** @var  \app\models\forms\FormBuilder */
    public $formBuilder;
}
