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

namespace app\modules\addons\models;

use app\components\behaviors\DateTrait;
use app\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "addon".
 *
 * @property integer $id
 * @property string $class
 * @property string $name
 * @property string $description
 * @property string $version
 * @property integer $status
 * @property integer $installed
 * @property integer $shared
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $owner
 * @property User $lastEditor
 * @property AddonUser[] $addonUsers
 * @property User[] $users
 * @property AddonUserRole[] $addonRoles
 *
 */
class Addon extends ActiveRecord
{
    use DateTrait;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const INSTALLED_OFF = 0;
    const INSTALLED_ON = 1;

    const SHARED_NONE = 0;
    const SHARED_EVERYONE = 1;
    const SHARED_WITH_USERS = 2;

    const CACHE_KEY = 'addon';

    public $roles;

    public static function tableName()
    {
        return '{{%addon}}';
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

    public function rules()
    {
        return [
            [['id', 'class', 'name'], 'required'],
            [['id', 'class', 'name'], 'trim'],
//            ['id',  'match', 'pattern' => '/^[a-z]+$/'],
            ['id',  'match', 'pattern' => '/^[a-zA-Z0-9-_\-]+$/'],
            ['id', 'unique'],
            ['class',  'match', 'pattern' => '/^[\w\\\]+$/'],
            ['class',  'classExists'],
            [['status','installed'], 'in', 'range' => [0,1]],
            [['status','installed'], 'default', 'value' => 0],
            [['shared', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['id', 'class', 'name', 'description', 'version'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('addon', 'ID'),
            'class' => Yii::t('addon', 'Class'),
            'name' => Yii::t('addon', 'Name'),
            'description' => Yii::t('addon', 'Description'),
            'version' => Yii::t('addon', 'Version'),
            'status' => Yii::t('addon', 'Status'),
            'installed' => Yii::t('addon', 'Installed'),
            'shared' => Yii::t('addon', 'Shared With'),
            'created_by' => Yii::t('addon', 'Created By'),
            'updated_by' => Yii::t('addon', 'Updated By'),
            'created_at' => Yii::t('addon', 'Created At'),
            'updated_at' => Yii::t('addon', 'Updated At'),
        ];
    }

    public static function find()
    {
        return new AddonQuery(get_called_class());
    }

    public function classExists($attribute)
    {
        if (!class_exists($this->$attribute)) {
            $this->addError($attribute, Yii::t('addon', 'Class does not exist'));
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (empty($this->created_at)) {
            $this->created_at = time();
        }
        if (empty($this->created_by)) {
            $this->created_by = Yii::$app->user->id;
        }
        $this->updated_by = Yii::$app->user->id;

        if (parent::beforeSave($insert)) {
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

            // Delete data related to this addon
            AddonUser::deleteAll(["addon_id" => $this->id]);
            AddonUserRole::deleteAll(["addon_id" => $this->id]);
            return true;

        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
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
    public function getAddonUsers()
    {
        return $this->hasMany(AddonUser::className(), ['addon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->via('addonUsers');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddonRoles()
    {
        return $this->hasMany(AddonUserRole::className(), ['addon_id' => 'id']);
    }

    /**
     * Get all possible values of 'shared' attribute
     *
     * @return array
     */
    public static function sharedOptions()
    {
        if (Yii::$app->user->can('manageAddons')) {
            return [
                self::SHARED_NONE => Yii::t("app", "None"),
                self::SHARED_EVERYONE => Yii::t("app", "Everyone"),
                self::SHARED_WITH_USERS => Yii::t("app", "Specific Users & Roles")
            ];
        }

        return [
            self::SHARED_NONE => Yii::t("app", "None"),
            self::SHARED_WITH_USERS => Yii::t("app", "Specific Users & Roles")
        ];
    }

}
