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

namespace app\models;

use app\components\validators\MultipleEmailValidator;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "form_confirmation".
 *
 * @property integer $id
 * @property integer $form_id
 * @property integer $type
 * @property string $message
 * @property string $url
 * @property int $append
 * @property int $alias
 * @property int $seconds
 * @property integer $send_email
 * @property array|string $mail_to
 * @property string $mail_from
 * @property string $mail_cc
 * @property string $mail_bcc
 * @property string $mail_subject
 * @property string $mail_message
 * @property string $mail_from_name
 * @property integer $mail_receipt_copy
 * @property integer $mail_attach
 * @property string $mail_attachments
 * @property integer $opt_in
 * @property integer $opt_in_type
 * @property string $opt_in_message
 * @property string $opt_in_url
 * @property integer $opt_out
 * @property integer $opt_out_type
 * @property string $opt_out_message
 * @property string $opt_out_url
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Form $form
 */
class FormConfirmation extends ActiveRecord
{

    const CONFIRM_WITH_MESSAGE = 0;
    const CONFIRM_WITH_ONLY_MESSAGE = 1;
    const CONFIRM_WITH_REDIRECTION = 2;

    const CONFIRM_BY_EMAIL_DISABLE = 0;
    const CONFIRM_BY_EMAIL_ENABLE = 1;

    const OPT_IN_THANK_YOU_MESSAGE = 0;
    const OPT_IN_THANK_YOU_WITH_REDIRECTION = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form_confirmation}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_id'], 'required'],
            ['url', 'required', 'when' => function ($model) {
                return $model->type == $this::CONFIRM_WITH_REDIRECTION;
            }, 'whenClient' => "function (attribute, value) {
                return $(\"input:radio[name='FormConfirmation[type]']:checked\").val() == '".
                $this::CONFIRM_WITH_REDIRECTION."';
            }"],
            ['mail_to', 'required', 'when' => function ($model) {
                return $model->send_email == $this::CONFIRM_BY_EMAIL_ENABLE;
            }, 'whenClient' => "function (attribute, value) {
                return $(\"input:radio[name='FormConfirmation[send_email]']:checked\").val() == '".
                $this::CONFIRM_BY_EMAIL_ENABLE."';
            }"],
            [['form_id', 'type', 'append', 'alias', 'seconds', 'send_email', 'mail_receipt_copy', 'mail_attach', 'opt_in', 'opt_in_type', 'opt_out', 'opt_out_type', 'created_at', 'updated_at'], 'integer'],
            [['message', 'mail_message', 'mail_attachments', 'opt_in_message', 'opt_out_message'], 'string'],
            [['url', 'mail_from', 'mail_cc', 'mail_bcc', 'mail_from_name', 'mail_subject', 'opt_in_url', 'opt_out_url'], 'string', 'max' => 2555],
            [['url', 'opt_in_url', 'opt_out_url',], 'url', 'defaultScheme' => 'http'],
            [['mail_from', 'mail_cc', 'mail_bcc'], 'trim'],
            [['mail_from'], 'email'],
            [['mail_cc', 'mail_bcc'], MultipleEmailValidator::className()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'form_id' => Yii::t('app', 'Form ID'),
            'type' => Yii::t('app', 'Confirms that the submission was successful with:'),
            'message' => Yii::t('app', 'Your Message'),
            'url' => Yii::t('app', 'Page URL'),
            'append' => Yii::t('app', 'Append Submission Data to URL'),
            'alias' => Yii::t('app', 'Replace Field Name with Field Alias when it\'s available'),
            'seconds' => Yii::t('app', 'Show Message and Redirect After'),
            'send_email' => Yii::t('app', 'Send a Confirmation Email?'),
            'mail_to' => Yii::t('app', 'Send To'),
            'mail_from' => Yii::t('app', 'Reply To'),
            'mail_from_name' => Yii::t('app', 'Name or Company'),
            'mail_cc' => Yii::t('app', 'Carbon Copy (cc)'),
            'mail_bcc' => Yii::t('app', 'Blind Carbon Copy (bcc)'),
            'mail_subject' => Yii::t('app', 'Subject'),
            'mail_message' => Yii::t('app', 'E-Mail Message'),
            'mail_receipt_copy' => Yii::t('app', "Includes a Submission Copy"),
            'mail_attach' => Yii::t('app', "Attach Uploaded Files"),
            'mail_attachments' => Yii::t('app', "Attachments"),
            'opt_in' => Yii::t('app', "Double Opt-In"),
            'opt_in_type' => Yii::t('app', "Configure the Thank You Page with"),
            'opt_in_message' => Yii::t('app', "Thank You Message"),
            'opt_in_url' => Yii::t('app', "Page URL"),
            'opt_out' => Yii::t('app', "Opt-Out"),
            'opt_out_message' => Yii::t('app', "Opt-Out Message"),
            'opt_out_url' => Yii::t('app', "Opt-Out Url"),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form::className(), ['id' => 'form_id']);
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $this->mail_to = explode(',', $this->mail_to);

        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (is_array($this->mail_to)) {
            $this->mail_to = implode(',', $this->mail_to);
        }

        return parent::beforeValidate();
    }

    /**
     * Get all possible labels of the type attribute
     *
     * @return array
     */
    public function getTypes()
    {
        return [
            self::CONFIRM_WITH_MESSAGE => Yii::t("app", "Message above Form"),
            self::CONFIRM_WITH_ONLY_MESSAGE => Yii::t("app", "Only Message"),
            self::CONFIRM_WITH_REDIRECTION => Yii::t("app", "Redirection to Another Page")
        ];
    }

    /**
     * Get all possible labels for the opt-in type attribute
     *
     * @return array
     */
    public function getOptInTypes()
    {
        return [
            self::OPT_IN_THANK_YOU_MESSAGE => Yii::t("app", "Custom Message"),
            self::OPT_IN_THANK_YOU_WITH_REDIRECTION => Yii::t("app", "Redirection to Another Page")
        ];
    }

    /**
     * Get label of type attribute
     *
     * @return string
     */
    public function getTypeLabel()
    {
        $types = $this->getTypes();
        return $types[$this->type];
    }
    /**
     * Return email views according to settings
     *
     * @return array
     */
    public function getEmailViews()
    {
        $content = [
            'html' => 'confirmation-html',
            'text' => 'confirmation-text',
        ];

        return $content;
    }
}
