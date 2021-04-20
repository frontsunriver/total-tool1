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

use app\components\behaviors\DateTrait;
use app\components\rules\RuleEngine;
use app\helpers\Hashids;
use app\helpers\SubmissionHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\helpers\FileHelper;
use app\helpers\Language;
use app\helpers\UrlHelper;
use app\helpers\TimeHelper;
use app\events\SubmissionEvent;
use app\components\behaviors\SluggableBehavior;
use app\components\validators\RecaptchaValidator;

/**
 * This is the model class for table "form".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $status
 * @property integer $is_private
 * @property integer $use_password
 * @property string $password
 * @property integer $authorized_urls
 * @property string $urls
 * @property integer $schedule
 * @property integer $schedule_start_date
 * @property integer $schedule_end_date
 * @property integer $total_limit
 * @property integer $total_limit_number
 * @property string $total_limit_time_unit
 * @property integer $user_limit
 * @property integer $user_limit_number
 * @property string $user_limit_time_unit
 * @property integer $user_limit_type
 * @property integer $submission_scope
 * @property integer $submission_number
 * @property string $submission_number_prefix
 * @property string $submission_number_suffix
 * @property integer $submission_number_width
 * @property integer $submission_editable
 * @property integer $submission_editable_time_length
 * @property integer $submission_editable_time_unit
 * @property integer $submission_editable_conditions
 * @property integer $save
 * @property integer $resume
 * @property integer $autocomplete
 * @property integer $novalidate
 * @property integer $analytics
 * @property integer $honeypot
 * @property integer $recaptcha
 * @property integer $protected_files
 * @property integer $ip_tracking
 * @property integer $browser_fingerprint
 * @property integer $shared
 * @property string $language
 * @property string $text_direction
 * @property string $message
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property string $languageLabel
 * @property string $hashId
 *
 * @property User $author
 * @property User $lastEditor
 * @property Theme $theme
 * @property FormData $formData
 * @property FormUI $ui
 * @property FormRule $formRules
 * @property FormConfirmation $formConfirmation
 * @property FormEmail $formEmail
 * @property FormSubmission[] $formSubmissions
 * @property FormSubmissionFile[] $formSubmissionFiles
 * @property FormChart[] $formCharts
 * @property FormUser[] $formUsers
 * @property User[] $users
 * @property FormConfirmationRule[] $formConfirmationRules
 */
class Form extends ActiveRecord
{
    use DateTrait;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const OFF = 0;
    const ON = 1;

    const SAVE_DISABLE = 0;
    const SAVE_ENABLE = 1;

    const RESUME_DISABLE = 0;
    const RESUME_ENABLE = 1;

    const AUTOCOMPLETE_DISABLE = 0;
    const AUTOCOMPLETE_ENABLE = 1;

    const ANALYTICS_DISABLE = 0;
    const ANALYTICS_ENABLE = 1;

    const HONEYPOT_INACTIVE = 0;
    const HONEYPOT_ACTIVE = 1;

    const RECAPTCHA_INACTIVE = 0;
    const RECAPTCHA_ACTIVE = 1;

    const USER_LIMIT_BY_IP = 1;
    const USER_LIMIT_BY_FP = 3;
    const USER_LIMIT_BY_IP_OR_FP = 5;
    const USER_LIMIT_BY_IP_AND_FP = 7;

    const EVENT_CHECKING_HONEYPOT = "app.form.submission.checkingHoneypot";
    const EVENT_CHECKING_SAVE = "app.form.submission.checkingSave";
    const EVENT_SPAM_DETECTED = "app.form.submission.spamDetected";

    const SHARED_NONE = 0;
    const SHARED_EVERYONE = 1;
    const SHARED_WITH_USERS = 2;

    const SUBMISSION_SCOPE_GLOBAL = 0;
    const SUBMISSION_SCOPE_OWNER = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form}}';
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
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'defaultValue' => function () {
                    return $this->updated_by;
                }
            ],
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['schedule_start_date', 'schedule_end_date'], 'required', 'when' => function ($model) {
                return $model->schedule == $this::ON;
            }, 'whenClient' => "function (attribute, value) {
                return $(\"input[name='Form[schedule]']:checked\").val() == '".$this::ON."';
            }"],
            [['password'], 'required', 'when' => function ($model) {
                return $model->use_password == $this::ON;
            }, 'whenClient' => "function (attribute, value) {
                return $(\"input[name='Form[use_password]']:checked\").val() == '".$this::ON."';
            }"],
            [['urls'], 'required', 'when' => function ($model) {
                return $model->authorized_urls == $this::ON;
            }, 'whenClient' => "function (attribute, value) {
                return $(\"input[name='Form[authorized_urls]']:checked\").val() == '".$this::ON."';
            }"],
            [['total_limit_number', 'total_limit_time_unit'], 'required', 'when' => function ($model) {
                return $model->total_limit == $this::ON;
            }, 'whenClient' => "function (attribute, value) {
                return $(\"input[name='Form[total_limit]']:checked\").val() == '".$this::ON."';
            }"],
            [['user_limit_number', 'user_limit_time_unit'], 'required', 'when' => function ($model) {
                return $model->user_limit == $this::ON;
            }, 'whenClient' => "function (attribute, value) {
                return $(\"input[name='Form[user_limit]']:checked\").val() == '".$this::ON."';
            }"],
            ['user_limit_type', 'compare',
                'compareValue' => Form::USER_LIMIT_BY_FP, 'operator' => '==', 'type' => 'number',
                'message' => Yii::t('app', 'Enable IP Tracking to use this option.'),
                'when' => function ($model) {
                    return $model->ip_tracking != Form::ON && $model->user_limit == Form::ON;
                }, 'whenClient' => "function (attribute, value) {
                return $(\"input[name='Form[ip_tracking]']:checked\").val() != '".Form::ON."' 
                    && $(\"input[name='Form[user_limit]']:checked\").val() == '".Form::ON."';
            }"],
            [['message', 'submission_editable_conditions'], 'string'],
            [['status', 'is_private', 'use_password', 'authorized_urls', 'schedule', 'schedule_start_date', 'schedule_end_date',
                'total_limit', 'total_limit_number', 'user_limit', 'user_limit_number',
                'submission_scope', 'submission_editable', 'submission_editable_time_length',
                'save', 'resume', 'autocomplete', 'novalidate', 'analytics', 'honeypot', 'recaptcha',
                'protected_files', 'ip_tracking', 'browser_fingerprint', 'shared',
                'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['total_limit_time_unit', 'user_limit_time_unit', 'submission_editable_time_unit'], 'string', 'max' => 1],
            [['submission_number'], 'integer', 'min' => 0],
            [['submission_number_width'], 'integer', 'min' => 0, 'max' => 45],
            [['submission_number_prefix', 'submission_number_suffix'], 'string', 'max' => 100],
            [['name', 'password'], 'string', 'max' => 255],
            [['urls'], 'string', 'max' => 2555],
            [['password'], 'string', 'min' => 3],
            [['password'], 'filter', 'filter' => 'trim'],
            // ensure empty values are stored as NULL in the database
            ['password', 'default', 'value' => null],
            ['schedule_start_date', 'default', 'value' => null],
            ['schedule_end_date', 'default', 'value' => null],
            [['language'], 'string', 'max' => 5],
            [['text_direction'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Form Name'),
            'status' => Yii::t('app', 'Status'),
            'is_private' => Yii::t('app', 'Private'),
            'use_password' => Yii::t('app', 'Use password'),
            'password' => Yii::t('app', 'Password'),
            'authorized_urls' => Yii::t('app', 'Authorized URLs'),
            'urls' => Yii::t('app', 'URLs'),
            'schedule' => Yii::t('app', 'Schedule Form Activity'),
            'schedule_start_date' => Yii::t('app', 'Start Date'),
            'schedule_end_date' => Yii::t('app', 'End Date'),
            'total_limit' => Yii::t('app', 'Limit Total Number of Submissions'),
            'total_limit_number' => Yii::t('app', 'Total Number'),
            'total_limit_time_unit' => Yii::t('app', 'Per Time Period'),
            'user_limit' => Yii::t('app', 'Limit Submissions per User'),
            'user_limit_number' => Yii::t('app', 'Max Number'),
            'user_limit_time_unit' => Yii::t('app', 'Per Time Period'),
            'user_limit_type' =>  Yii::t('app', 'Limit By'),
            'submission_scope' => Yii::t('app', 'Owner Scope'),
            'submission_number' => Yii::t('app', 'Generate Submission Number'),
            'submission_number_prefix' => Yii::t('app', 'Number Prefix'),
            'submission_number_suffix' => Yii::t('app', 'Number Suffix'),
            'submission_number_width' => Yii::t('app', 'Number Width'),
            'submission_editable' => Yii::t('app', 'Editable'),
            'submission_editable_time_length' => Yii::t('app', 'During'),
            'submission_editable_time_unit' => Yii::t('app', 'Unit of Time'),
            'submission_editable_conditions' => Yii::t('app', 'Conditions'),
            'save' => Yii::t('app', 'Save to DB'),
            'resume' => Yii::t('app', 'Save & Resume Later'),
            'autocomplete' => Yii::t('app', 'Auto complete'),
            'novalidate' => Yii::t('app', 'No validate'),
            'analytics' => Yii::t('app', 'Analytics'),
            'honeypot' => Yii::t('app', 'Spam filter'),
            'recaptcha' => Yii::t('app', 'reCaptcha'),
            'protected_files' => Yii::t('app', 'Protected Files'),
            'ip_tracking' => Yii::t('app', 'IP Tracking'),
            'browser_fingerprint' => Yii::t('app', 'Browser Fingerprint'),
            'shared' => Yii::t('app', 'Shared With'),
            'language' => Yii::t('app', 'Language'),
            'text_direction' => Yii::t('app', 'Text Direction'),
            'message' => Yii::t('app', 'Message'),
            'created_by' => Yii::t('app', 'Created by'),
            'updated_by' => Yii::t('app', 'Updated by'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditor()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormData()
    {
        return $this->hasOne(FormData::className(), ['form_id' => 'id'])->inverseOf('form');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUi()
    {
        return $this->hasOne(FormUI::className(), ['form_id' => 'id'])->inverseOf('form');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Theme::className(), ['id' => 'theme_id'])
            ->via('ui');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormRules()
    {
        return $this->hasMany(FormRule::className(), ['form_id' => 'id'])->inverseOf('form');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveRules()
    {
        return $this->hasMany(FormRule::className(), ['form_id' => 'id'])
            ->where('status = :status', [':status' => FormRule::STATUS_ACTIVE])
            ->orderBy(['ordinal' => 'ASC', 'id' => 'ASC']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormConfirmation()
    {
        return $this->hasOne(FormConfirmation::className(), ['form_id' => 'id'])->inverseOf('form');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormEmail()
    {
        return $this->hasOne(FormEmail::className(), ['form_id' => 'id'])->inverseOf('form');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormSubmissions()
    {
        return $this->hasMany(FormSubmission::className(), ['form_id' => 'id'])->inverseOf('form');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormSubmissionFiles()
    {
        return $this->hasMany(FormSubmissionFile::className(), ['form_id' => 'id'])->inverseOf('form');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormCharts()
    {
        return $this->hasMany(FormChart::className(), ['form_id' => 'id'])->inverseOf('form');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormUsers()
    {
        return $this->hasMany(FormUser::className(), ['form_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->via('formUsers');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormConfirmationRules()
    {
        return $this->hasMany(FormConfirmationRule::className(), ['form_id' => 'id'])->inverseOf('form');
    }

    /**
     * Show label instead of value for boolean Status property
     * @return string
     */
    public function getStatusLabel()
    {
        return $this->status ? Yii::t('app', 'Active') : Yii::t('app', 'Inactive');
    }

    /**
     * Return list of Time Periods
     * @param array $options
     * @return array
     */
    public function getTimePeriods($options = [])
    {
        return TimeHelper::timePeriods($options);
    }

    /**
     * Returns the language name by its code
     * @return mixed
     */
    public function getLanguageLabel()
    {
        return Language::getLangByCode($this->language);
    }

    /**
     * Get Text Direction label
     * @return mixed
     */
    public function getTextDirectionLabel()
    {
        return Language::getTextDirectionByCode($this->text_direction);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            // Create files directory, if it doesn't exists
            $filesDirectory = $this->getFilesDirectory();
            if (!is_dir($filesDirectory)) {
                Yii::$app->fs->createDir($filesDirectory);
            }
        }

    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            // Delete related Models
            $this->formData->delete();
            $this->ui->delete();
            $this->formConfirmation->delete();
            $this->formEmail->delete();

            // Delete all Charts, Submissions and Files related to this form
            // We use deleteAll for performance reason
            FormUser::deleteAll(["form_id" => $this->id]);
            FormRule::deleteAll(["form_id" => $this->id]);
            FormChart::deleteAll(["form_id" => $this->id]);
            FormSubmissionFile::deleteAll(["form_id" => $this->id]);
            FormSubmission::deleteAll(["form_id" => $this->id]);

            // Delete all Stats related to this form
            Event::deleteAll(["app_id" => $this->id]);
            StatsPerformance::deleteAll(["app_id" => $this->id]);
            StatsSubmissions::deleteAll(["app_id" => $this->id]);

            // Delete all Items related to this Form
            FormConfirmationRule::deleteAll(["form_id" => $this->id]);

            // Removes files directory (and all its content)
            // of this form (if exists)
            $filesFolder = $this->getFilesDirectory();
            if (is_dir(Url::to('@uploads' . '/' . $filesFolder))) {
                Yii::$app->fs->deleteDir($filesFolder);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete related stats
     *
     * @return integer The number of rows deleted
     */
    public function deleteStats()
    {
        // Delete all Stats related to this form
        $events = Event::deleteAll(["app_id" => $this->id]);
        $stats = StatsPerformance::deleteAll(["app_id" => $this->id]);
        $submissions = StatsSubmissions::deleteAll(["app_id" => $this->id]);

        return $events + $stats + $submissions;
    }

    /**
     * Detect if browser fingerprint feature should be used
     *
     * @return int
     */
    public function getUseFingerprint()
    {
        return $this->browser_fingerprint
        && $this->user_limit === Form::ON
        && (!$this->ip_tracking || $this->user_limit_type > Form::USER_LIMIT_BY_IP) ? 1 : 0;
    }

    /**
     * Get Form ID as Hash ID
     *
     * @return int|string
     */
    public function getHashId()
    {
        return Hashids::encode($this->id);
    }

    /**
     * Get all possible values of 'user_limit_type' attribute
     *
     * @return array
     */
    public static function userLimitOptions()
    {
        return [
            self::USER_LIMIT_BY_IP => Yii::t("app", "IP Address"),
            self::USER_LIMIT_BY_FP => Yii::t("app", "Browser Fingerprint"),
            self::USER_LIMIT_BY_IP_OR_FP => Yii::t("app", "IP Address or Browser Fingerprint"),
            self::USER_LIMIT_BY_IP_AND_FP => Yii::t("app", "IP Address and Browser Fingerprint"),
        ];
    }

    /**
     * Get all possible values of 'shared' attribute
     *
     * @return array
     */
    public static function sharedOptions()
    {
        if (Yii::$app->user->can('manageForms')) {
            return [
                self::SHARED_NONE => Yii::t("app", "None"),
                self::SHARED_EVERYONE => Yii::t("app", "Everyone"),
                self::SHARED_WITH_USERS => Yii::t("app", "Specific Users")
            ];
        }

        return [
            self::SHARED_NONE => Yii::t("app", "None"),
            self::SHARED_WITH_USERS => Yii::t("app", "Specific Users")
        ];
    }

    /**
     * Check if submission pass Honey Pot trap
     * If no pass throw NotFoundHttpException
     *
     * @param $post
     * @throws NotFoundHttpException
     */
    public function checkHoneypot($post)
    {

        Yii::$app->trigger($this::EVENT_CHECKING_HONEYPOT, new SubmissionEvent([
            'sender' => $this,
        ]));

        if ($this->honeypot === $this::HONEYPOT_ACTIVE) {
            if (isset($post['_email']) && !empty($post['_email'])) {

                Yii::$app->trigger($this::EVENT_SPAM_DETECTED, new SubmissionEvent([
                    'sender' => $this,
                ]));

                throw new NotFoundHttpException();
            }
        }

    }

    /**
     * Check if referrer page is in a authorized host
     *
     * @throws NotFoundHttpException
     */
    public function checkAuthorizedUrls()
    {
        if ($this->authorized_urls === $this::ON && !empty($this->urls)) {
            // Parse authorized hosts
            $urls = array_map('trim', explode(',', $this->urls));
            $hosts = [];
            foreach ($urls as $url) {
                $parsedUrl = parse_url(UrlHelper::addScheme($url, 'http'));
                $hosts[] = $parsedUrl['host'];
            }
            $hosts = array_unique($hosts);
            if(isset($_SERVER['HTTP_REFERER'])) {
                $referrer = parse_url($_SERVER['HTTP_REFERER']);
                // Add current host to authorized hosts
                if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
                    array_push($hosts, $_SERVER['HTTP_HOST']);
                }
                // If referrer is not in an authorized host
                if (!in_array($referrer['host'], $hosts)) {
                    throw new NotFoundHttpException();
                }
            }
        }
    }

    /**
     * reCaptcha Validation
     *
     * @param $post
     * @return array
     */
    public function validateRecaptcha($post)
    {

        $v = ['success' => true];

        // Only if Form has reCaptcha component and was not passed in this session
        if ($this->recaptcha === $this::RECAPTCHA_ACTIVE) {
            $recaptchaValidator = new RecaptchaValidator();
            $session = Yii::$app->session;
            $validate = true; // Flag
            // Detect if reCAPTCHA was loaded within the form
            $loaded = isset($post[$recaptchaValidator::CAPTCHA_RESPONSE_FIELD]);
            // Get the reCAPTCHA token
            $token = !empty($post[$recaptchaValidator::CAPTCHA_RESPONSE_FIELD]) ? $post[$recaptchaValidator::CAPTCHA_RESPONSE_FIELD] : '';
            // Check if user sent a valid reCAPTCHA token previously
            // reCaptcha can be true or false
            $captchaWasSolved = $session->has('reCaptcha') && $session->get('reCaptcha');
            // Logic
            if (!$loaded && $captchaWasSolved) {
                $validate = false;
            }

            // Smart captcha. Validate only if reCaptcha wasn't sent previously
            if ($validate && !$recaptchaValidator->validate($token, $message)) {
                $v = [
                    'success' => false,
                    'errorMessage' => Yii::t('app', 'There is {startTag}an error in your submission{endTag}.', [
                        'startTag' => '<strong>',
                        'endTag' => '</strong>',
                    ]),
                    'error' => [
                        'field' => $this->formData->getRecaptchaFieldID(),
                        'alias' => '',
                        'messages' => [$message],
                    ]
                ];
            }
        }

        return $v;
    }

    /**
     * Check if form submission is editable
     *
     * @param int $sid Submission ID
     * @return array|bool[]
     */
    public function checkSubmissionEditable($sid)
    {
        $v = [
            'success' => false,
            'errorMessage' => Yii::t("app", "Form submissions are not editable."),
        ];

        if ($this->submission_editable === $this::ON) {

            $v = ['success' => true];

            /** @var FormSubmission $submissionModel */
            $submissionModel = FormSubmission::find()
                ->select(['id', 'data', 'created_at'])
                ->where(['form_id' => $this->id])
                ->andWhere(['id' => $sid])
                ->one();

            // Validate time frame
            if (!empty($this->submission_editable_time_length) && !empty($this->submission_editable_time_unit)) {

                $startTime = TimeHelper::startTimeFromNow($this->submission_editable_time_length, $this->submission_editable_time_unit);

                // If Submission was created before the Time limit
                if ($submissionModel->created_at < $startTime) {
                    $v = [
                        'success' => false,
                        'errorMessage' => Yii::t("app", "This form submission is no longer editable."),
                    ];
                }
            }

            // Validate conditions
            if ($v['success'] && !empty($this->submission_editable_conditions)) {

                // Submission data for rule engine
                $data = SubmissionHelper::prepareDataForRuleEngine($submissionModel->data, $this->formData->getFields());

                // Conditional Logic
                $engine = new RuleEngine([
                    'conditions' => $this->submission_editable_conditions,
                    'actions' => [],
                ]);

                $isEditable = $engine->matches($data);

                // If Submission does not meet the conditions
                if (!$isEditable) {
                    $v = [
                        'success' => false,
                        'errorMessage' => Yii::t("app", "This form submission is not editable."),
                    ];
                }
            }
        }

        return $v;
    }

    /**
     * Check if form does no accept more submissions
     */
    public function checkTotalLimit()
    {
        $v = ['success' => true];

        if ($this->total_limit === $this::ON) {

            $startTime = TimeHelper::startTime($this->total_limit_time_unit);

            $submissions = FormSubmission::find()->select('id')->asArray()
                ->where(['form_id' => $this->id])
                ->andWhere(['between','created_at', $startTime, time()])->count();

            if ($this->total_limit_number <= $submissions) {
                $v = [
                    'success' => false,
                    'errorMessage' => Yii::t("app", "This form is no longer accepting new submissions per {period}.", [
                        'period' => TimeHelper::getPeriodByCode($this->total_limit_time_unit)]),
                ];
            }
        }

        return $v;
    }

    /**
     * Check if User has reached his submission limit
     *
     * @return array
     */
    public function checkUserLimit()
    {
        $v = ['success' => true];

        if ($this->user_limit === self::ON) {

            $startTime = TimeHelper::startTime($this->user_limit_time_unit);

            // User IP Address
            $ip = Yii::$app->request->getUserIP();
            if ($ip === "::1") {
                // Useful when it's running on localhost
                $ip = "81.2.69.160";
            }

            // Browser Fingerprint
            $fp = Yii::$app->request->headers->get('fp');

            // Default user limit type
            if (empty($this->user_limit_type)) {
                $this->user_limit_type = self::USER_LIMIT_BY_IP;
            }

            // If IP Tracking is OFF, default type should be by FP
            if (!$this->ip_tracking) {
                $this->user_limit_type = self::USER_LIMIT_BY_FP;
            }

            // Count submissions
            $submissions = 0;

            if ($this->user_limit_type === self::USER_LIMIT_BY_IP) {

                $submissions = FormSubmission::find()->select('id')
                    ->where(['form_id' => $this->id])
                    ->andWhere(['between','created_at', $startTime, time()])
                    ->andWhere(['ip' => $ip])
                    ->count();

            } elseif ($this->user_limit_type === self::USER_LIMIT_BY_FP) {

                $submissions = FormSubmission::find()->select('id')
                    ->where(['form_id' => $this->id])
                    ->andWhere(['between','created_at', $startTime, time()])
                    ->andWhere(['browser_fingerprint' => $fp])
                    ->count();

            } elseif ($this->user_limit_type === self::USER_LIMIT_BY_IP_OR_FP) {

                $submissions = FormSubmission::find()
                    ->select('id')
                    ->where(['form_id' => $this->id])
                    ->andWhere(['between','created_at', $startTime, time()])
                    ->andWhere([
                        'or',
                        ['ip' => $ip],
                        ['browser_fingerprint' => $fp],
                    ])
                    ->count();

            } elseif ($this->user_limit_type === self::USER_LIMIT_BY_IP_AND_FP) {

                $submissions = FormSubmission::find()->select('id')
                    ->where(['form_id' => $this->id])
                    ->andWhere(['between','created_at', $startTime, time()])
                    ->andWhere(['ip' => $ip])
                    ->andWhere(['browser_fingerprint' => $fp])
                    ->count();

            }

            if ($this->user_limit_number <= $submissions) {

                $v = [
                    'success' => false,
                    'errorMessage' => Yii::t("app", "You have reached your Submission Limit per {period}.", [
                        'period' => TimeHelper::getPeriodByCode($this->user_limit_time_unit)]),
                ];

            }
        }

        return $v;
    }

    /**
     * Enable / Disable Form Activity
     */
    public function checkFormActivity()
    {
        if ($this->schedule === $this::ON && $this->status === $this::STATUS_ACTIVE) {
            if ($this->schedule_start_date > time() || $this->schedule_end_date < time()) {
                $this->status = $this::STATUS_INACTIVE;
                $this->save();
            }
        } elseif ($this->schedule === $this::ON && $this->status === $this::STATUS_INACTIVE) {
            if ($this->schedule_start_date < time() && $this->schedule_end_date > time()) {
                $this->status = $this::STATUS_ACTIVE;
                $this->save();
            }
        }
    }

    public function saveToDB()
    {
        Yii::$app->trigger($this::EVENT_CHECKING_SAVE, new SubmissionEvent([
            'sender' => $this,
        ]));

        return ($this->save === $this::SAVE_ENABLE);
    }

    public function getFilesDirectory()
    {
        return FormSubmissionFile::FILES_FOLDER . '/' . $this->id;
    }
}
