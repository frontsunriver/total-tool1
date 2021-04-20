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

use app\components\analytics\enricher\IpLookupsEnrichment;
use app\components\behaviors\DateTrait;
use app\components\validators\DataValidator;
use app\helpers\ArrayHelper;
use app\helpers\Hashids;
use app\helpers\Html;
use app\helpers\SubmissionHelper;
use Carbon\Carbon;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "form_submissions".
 *
 * @property integer $id
 * @property integer $form_id
 * @property integer $number
 * @property integer $status
 * @property integer $new
 * @property integer $important
 * @property string $sender
 * @property string|array $data
 * @property string $ip
 * @property string $browser_fingerprint
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property string $hashId
 * @property string $editLink
 *
 * @property Form $form
 * @property User $author
 * @property User $lastEditor
 * @property FormSubmissionFile[] $files
 */
class FormSubmission extends ActiveRecord
{
    use DateTrait;

    const STATUS_RECEIVED = 0;   // Received by the system
    const STATUS_ACCEPTED = 1;   // Accepted by the system
    const STATUS_REJECTED = 2;   // Rejected by the system (Validation errors)
    const STATUS_PENDING = 5;    // Double opt-in email was sent
    const STATUS_VERIFIED = 7;   // Double opt-in by the user was received
    const STATUS_BOUNCED = 8;    // Double opt-in Email bounced
    const STATUS_RESTRICTED = 9; // Restrict Processing - GDPR

    private $idCache;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form_submission}}';
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
    public function init()
    {
        Carbon::setLocale(substr(Yii::$app->language, 0, 2)); // eg. en-US to en
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ['id', 'hashId', 'form_id', 'number', 'status', 'new', 'important',
            'sender', 'data', 'files', 'comments', 'authorName', 'lastEditorName', 'ip', 'editLink',
            'created_at', 'updated_at', 'created', 'updated'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_id'], 'required'],
            [['form_id', 'status', 'new', 'important','created_by', 'updated_by',
                'created_at', 'updated_at'], 'integer'],
            [['number'], 'string', 'max' => 255],
            [['data'], 'requiredFieldsValidation', 'skipOnEmpty' => false, 'skipOnError' => false, 'on' => ['public']],
            [['data'], 'uniqueFieldsValidation', 'skipOnEmpty' => false, 'skipOnError' => false,
                'on' => ['public', 'administration']],
            [['data'], 'fieldTypeValidation', 'skipOnEmpty' => false, 'skipOnError' => false,
                'on' => ['public', 'administration']],
            [['sender', 'ip', 'browser_fingerprint'], 'safe']
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
            'number' => Yii::t('app', 'Number'),
            'status' => Yii::t('app', 'Status'),
            'new' => Yii::t('app', 'New'),
            'important' => Yii::t('app', 'Important'),
            'sender' => Yii::t('app', 'Sender'),
            'data' => Yii::t('app', 'Data'),
            'ip' => Yii::t('app', 'IP Address'),
            'browser_fingerprint' => Yii::t('app', 'Browser Fingerprint'),
            'created_by' => Yii::t('app', 'Created by'),
            'updated_by' => Yii::t('app', 'Updated by'),
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
     * @return null|string Name of the author
     */
    public function getAuthorName()
    {
        if (isset($this->author) && isset($this->author->username)) {
            return $this->author->username;
        }

        return null;
    }

    /**
     * @return null|string Name of the last editor
     */
    public function getLastEditorName()
    {
        if (isset($this->lastEditor) && isset($this->lastEditor->username)) {
            return $this->lastEditor->username;
        }

        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(FormSubmissionFile::className(), ['submission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(FormSubmissionComment::className(), ['submission_id' => 'id']);
    }

    /**
     * Required Validation
     *
     * @throws \Exception
     */
    public function requiredFieldsValidation()
    {
        $dataValidator = new DataValidator($this);
        $dataValidator->requiredFieldsValidation();
        if ($dataValidator->hasErrors()) {
            $this->addErrors($dataValidator->getErrors());
        }
    }

    /**
     * Field Type Validation
     *
     * @throws \Exception
     */
    public function fieldTypeValidation()
    {
        $dataValidator = new DataValidator($this);
        $dataValidator->fieldTypeValidation();
        if ($dataValidator->hasErrors()) {
            $this->addErrors($dataValidator->getErrors());
        }
    }

    /**
     * Unique Validation
     *
     * @throws \Exception
     */
    public function uniqueFieldsValidation()
    {
        $dataValidator = new DataValidator($this);
        $dataValidator->uniqueFieldsValidation();
        if ($dataValidator->hasErrors()) {
            $this->addErrors($dataValidator->getErrors());
        }
    }

    /**
     * Clean Submission of null fields
     *
     * Remove keys with NULL, but leave values of FALSE, Empty Strings ("") and 0 (zero)
     *
     * @param $fields
     * @param $post
     * @return array
     */
    public function cleanSubmission($fields, $post)
    {
        $submission = [];
        foreach ($fields as $field) {
            $submission[$field["name"]] = isset($post[$field["name"]]) ? $post[$field["name"]] : null;
        }

        // Remove keys with NULL, but leave values of FALSE, Empty Strings ("") and 0 (zero)
        $submission = array_filter($submission, function ($val) {
            return $val !== null;
        });

        // Strip whitespace from the beginning and end of each string element of the array
        $submission = array_map(function ($el) {
            if (is_string($el)) {
                return trim($el);
            } elseif (is_array($el)) {
                // For Select List & Checkbox elements
                array_map('trim', $el);
                return $el;
            }
            return $el;
        }, $submission);

        return $submission;
    }

    /**
     * Return array of UploadedFile
     *
     * @param $fileFields
     * @return array
     */
    public function getUploadedFiles($fileFields)
    {
        // Array of files
        $files = [];

        // Note: Load file here, to prevent save incomplete data
        // For example, by memory exhaust error

        // If form has file fields
        foreach ($fileFields as $name => $label) {
            // Get the file
            $uploadedFiles = UploadedFile::getInstancesByName($name);
            $file = [
                'name' => $name,
                'label' => $label,
                'files' => $uploadedFiles,
            ];
            // Add to array
            array_push($files, $file);
        }

        return $files;

    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        // Decode as json json assoc array
        $this->data = json_decode($this->data, true);

        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($insert) {
                // Number
                $this->number = $this->generateSubmissionNumber();

                // Browser Fingerprint
                if ($this->form->browser_fingerprint) {
                    if ($fp = Yii::$app->request->headers->get('fp')) {
                        $this->browser_fingerprint = $fp;
                    }
                }

                // Sender information
                $sender = [
                    'user_agent' => Yii::$app->request->getUserAgent(),
                ];

                $referrer =  $this->getReferrer();
                $sender = $sender + $referrer;

                // IP Geolocation
                if ($this->form->ip_tracking) {
                    $this->ip = $this->getUserIP();
                    $ipEnriched = new IpLookupsEnrichment($this->ip);
                    $location = $ipEnriched->getData();

                    if (!empty($location)) {
                        $sender = $sender + [
                            'country' => isset($location["geo_country_name"]) ? $location["geo_country_name"] : '',
                            'city' => isset($location["geo_city"]) ? $location["geo_city"] : '',
                            'latitude' => isset($location["geo_latitude"]) ? $location["geo_latitude"] : '',
                            'longitude' => isset($location["geo_longitude"]) ? $location["geo_longitude"] : '',
                        ];
                    }
                }

                // Browser GeoLocation
                if (Yii::$app->settings->get('browserGeolocation', 'app', 0)) {

                    $latitude = Yii::$app->request->headers->get('lat');
                    $longitude = Yii::$app->request->headers->get('lng');

                    if ($latitude && $longitude) {
                        // Updates Sender Information
                        $sender['latitude'] = (float) $latitude;
                        $sender['longitude'] = (float) $longitude;
                        $sender['consent'] = 1;

                        if (Yii::$app->settings->get('app.geocodingProvider') === "google_geocoding"
                            && trim(Yii::$app->settings->get('app.geocodingProvider')) !== "") {

                            $url = 'https://maps.googleapis.com/maps/api/geocode/json';
                            $data = [
                                'latlng' => $latitude . ',' . $longitude,
                                'sensor' => false,
                                'key' => Yii::$app->settings->get('app.googleGeocodingApiKey'),
                            ];
                            $response = null;

                            if (function_exists('curl_version')) {

                                $ch = curl_init($url . '?' . http_build_query($data));
                                defined('CURLOPT_SSL_VERIFYPEER') or define('CURLOPT_SSL_VERIFYPEER', 64);
                                curl_setopt_array($ch, array(
                                    CURLOPT_FRESH_CONNECT => true,
                                    CURLOPT_SSL_VERIFYPEER => false,
                                    CURLOPT_RETURNTRANSFER => true,
                                ));
                                if (!$response = curl_exec($ch)) {
                                    $error = curl_error($ch);
                                    $errno = curl_errno($ch);
                                    curl_close($ch);

                                    Yii::error($error);
                                }
                                curl_close($ch);

                            } else {

                                $request = $url . '?' . http_build_query($data);
                                $response = file_get_contents($request, false, stream_context_create([
                                    "ssl" => [
                                        "verify_peer"=>false,
                                        "verify_peer_name"=>false,
                                    ]
                                ]));

                            }

                            if (!empty($response)) {
                                $location = Json::decode($response, true);
                                if (isset($location['error_message'])) {
                                    Yii::error("Google Geocoding API response: " . json_encode($location));
                                } else {
                                    if (isset($location['results'], $location['results'][0], $location['results'][0]['address_components'])) {
                                        foreach ($location['results'][0]['address_components'] as $address) {
                                            if (isset($address['types'][0]) && $address['types'][0] == 'country') {
                                                $sender['country'] = $address['long_name'];
                                            } elseif (isset($address['types'][0]) && $address['types'][0] == 'administrative_area_level_1') {
                                                $sender['city'] = $address['long_name'];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // Encode sender data as json object
                $this->sender = json_encode($sender, JSON_FORCE_OBJECT);

            }

            // Encode submission data
            $this->data = Json::encode($this->data); // Encode as json assoc array and UTF-8

            return true;

        } else {

            return false;

        }
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->idCache = $this->id;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        parent::afterDelete();

        // Delete Files
        foreach (FormSubmissionFile::find()->where(['submission_id' => $this->idCache])->all() as $fileModel) {
            $fileModel->delete();
        }

        // Delete Comments
        foreach (FormSubmissionComment::find()->where(['submission_id' => $this->idCache])->all() as $commentModel) {
            $commentModel->delete();
        }
    }

    /**
     * Get Submission ID as Hash ID
     *
     * @return int|string
     */
    public function getHashId()
    {
        return Hashids::encode($this->id);
    }

    /**
     * Get User IP
     * @return string
     */
    private function getUserIP()
    {

        $ip = getenv('HTTP_CLIENT_IP')?:
            getenv('HTTP_X_FORWARDED_FOR')?:
                getenv('HTTP_X_FORWARDED')?:
                    getenv('HTTP_FORWARDED_FOR')?:
                        getenv('HTTP_FORWARDED')?:
                            getenv('REMOTE_ADDR');

        if ($ip === "::1") {
            // Useful when app is running on localhost
            $ip = "81.2.69.160";
        } elseif (strpos($ip, ',') !== false) {
            // Useful when REMOTE_ADDR returns 2 IPv4 instead of one
            $ip = Yii::$app->getRequest()->getUserIP();
        }

        return $ip;
    }

    /**
     * Get Referrer Information
     * To detect it, Analytics must be enabled in Form Settings.
     *
     * @return array
     */
    public function getReferrer()
    {
        $referrer = [];
        $referrerLink = Yii::$app->request->getReferrer();
        if (!empty($referrerLink)) {
            parse_str($referrerLink, $link);
            if (isset($link['url']) || isset($link['referrer'])) {
                if (isset($link['url']) && !empty($link['url'])) {
                    $referrer['url'] = $link['url'];
                }
                if (isset($link['referrer']) && !empty($link['referrer'])) {
                    $referrer['referrer'] = $link['referrer'];
                }
                return $referrer;
            }
        }
        return [];
    }

    /**
     * Generate Absolute URL to Edit Form Submission
     * Works only when a Form Submission is editable
     *
     * @return string
     */
    public function getEditLink()
    {
        $editLink = "";

        if (isset($this->form, $this->form->submission_editable)
            && $this->form->submission_editable) {
            $editLink = Url::to(['/app/forms',
                'slug' => $this->form->slug,
                'sid' => $this->hashId,
            ], true);
        }

        return $editLink;
    }

    /**
     * Generate Absolute URL to Confirm Form Submission
     *
     * @return string
     */
    public function getConfirmLink()
    {
        $link = "";

        if (isset($this->form, $this->form->formConfirmation, $this->form->formConfirmation->opt_in)
            && $this->form->formConfirmation->opt_in) {
            $link = Url::to(['/app/c',
                's' => $this->hashId,
            ], true);
        }

        return $link;
    }

    /**
     * Get Submission Files Links
     *
     * @return array
     */
    public function getFileLinks()
    {
        $files = [];

        if ($this->files && !empty($this->files)) {
            foreach ($this->files as $file) {
                $files[] = [
                    'field' => $file->field,
                    'file' => $file->getLink(),
                ];
            }
            $files = ArrayHelper::index($files, null, 'field');
            $tmpFiles = [];
            foreach ($files as $key => $values) {
                if (is_array($values)) {
                    $tmpFiles[$key] = [];
                    foreach ($values as $v) {
                        $tmpFiles[$key][] = !empty($v['file']) && is_string($v['file']) ? $v['file'] : 'INVALID FILE LINK';
                    }
                }
            }
            $files = $tmpFiles;
        }

        return $files;
    }

    /**
     * Parse Submission data
     *
     * @return array|mixed|string
     */
    public function getSubmissionData()
    {
        $data = [];
        $sender = [];

        if (!empty($this->data)) {
            if (is_string($this->data)) {
                $data = json_decode($this->data, true);
            } else {
                $data = $this->data;
            }
        }

        if (!empty($this->sender)) {
            if (is_string($this->sender)) {
                $sender = json_decode($this->sender, true);
            } else {
                $sender = $this->sender;
            }
        }

        $files = $this->getFileLinks();

        // Append edit link (Using friendly url)
        $data['edit_link'] = $this->getEditLink();

        // Append opt-in link
        $data['optin_link'] = $this->getConfirmLink();

        // Submission Table
        $fieldsForEmail = $this->form->formData->getFieldsForEmail();
        $fieldData = SubmissionHelper::prepareDataForSubmissionTable($data, $fieldsForEmail);
        $submissionTable = SubmissionHelper::getSubmissionTable($fieldData);
        $submissionText = SubmissionHelper::getSubmissionTable($fieldData, true);

        return $data + [
            'form_id' => $this->form->id,
            'submission_id' => $this->id,
            'submission_number' => $this->number,
            'submission_table' => $submissionTable,
            'submission_text' => $submissionText,
            'form_name' => isset($this->form->name) ? Html::encode($this->form->name) : '',
            'ip_address' => $this->ip,
            'created_at' => empty($this->created_at) ? time() : $this->created_at,
            'updated_at' => empty($this->updated_at) ? time() : $this->updated_at,
        ] + $files + $sender;
    }

    /**
     * Generate Submission Number
     * @return string
     */
    public function generateSubmissionNumber()
    {
        $number = 0;

        // Default Settings
        $default = $this->form->submission_number;
        $prefix = $this->form->submission_number_prefix;
        $suffix = $this->form->submission_number_suffix;
        $width = $this->form->submission_number_width;

        // Find last submission number
        /** @var FormSubmission $last */
        $last = FormSubmission::find()
            ->where(['form_id' => $this->form->id])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        // Last number
        if (!empty($last->number)) {
            $number = $last->number;
            // Removes prefix
            if (!empty($prefix)) {
                $number = str_replace($prefix,'', $number);
            }
            // Removes suffix
            if (!empty($suffix)) {
                $number = str_replace($suffix,'', $number);
            }
            // Removes leading zeros
            $number = (int) ltrim($number, '0');
        }

        // Increase number
        ++$number;

        if ($default > $number) {
            $number = (int) $default;
        }

        // Add width
        if (!empty($width)) {
            $number = str_pad($number, $width, "0", STR_PAD_LEFT);
        }
        // Add prefix
        if (!empty($prefix)) {
            $number = $prefix.$number;
        }
        // Add suffix
        if (!empty($suffix)) {
            $number = $number.$suffix;
        }

        return $number;
    }
}
