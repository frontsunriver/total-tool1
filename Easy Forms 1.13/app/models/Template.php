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
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\components\behaviors\SluggableBehavior;
use app\components\JsonToArrayBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "template".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $description
 * @property string $builder
 * @property string $html
 * @property integer $promoted
 * @property integer $shared
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TemplateCategory $category
 * @property User $author
 * @property User $lastEditor
 * @property TemplateUser[] $templateUsers
 * @property User[] $users
 *
 */
class Template extends ActiveRecord
{
    use DateTrait;

    const PROMOTED_OFF = 0;
    const PROMOTED_ON = 1;

    const SHARED_NONE = 0;
    const SHARED_EVERYONE = 1;
    const SHARED_WITH_USERS = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%template}}';
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
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique'=>true,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'promoted', 'shared', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['builder', 'html'], 'string'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'builder' => Yii::t('app', 'Builder'),
            'html' => Yii::t('app', 'Html'),
            'promoted' => Yii::t('app', 'Promoted'),
            'shared' => Yii::t('app', 'Shared With'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
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
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(TemplateCategory::className(), ['id' => 'category_id']);
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
    public function getTemplateUsers()
    {
        return $this->hasMany(TemplateUser::className(), ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->via('templateUsers');
    }
    /**
     * Get Form Name
     *
     * @return mixed|string|null
     */
    public function getFormName()
    {
        $builder = Json::decode($this->builder, true);

        return isset($builder['settings']['name']) ? $builder['settings']['name'] : null;
    }

    /**
     * Set Form Name
     *
     * @param $name
     */
    public function setFormName($name)
    {
        $builder = Json::decode($this->builder, true);
        if (isset($builder['settings']['name'])) {
            $builder['settings']['name'] = $name;
            $this->builder = Json::htmlEncode($builder);
        }
    }

    /**
     * Get all possible values of 'shared' attribute
     *
     * @return array
     */
    public static function sharedOptions()
    {
        if (Yii::$app->user->can('manageTemplates')) {
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
}
