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

/**
 * This is the model class for table "theme".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $color
 * @property string $css
 * @property integer $shared
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $author
 * @property User $lastEditor
 * @property ThemeUser[] $themeUsers
 * @property User[] $users
 */
class Theme extends ActiveRecord
{
    use DateTrait;

    const SHARED_NONE = 0;
    const SHARED_EVERYONE = 1;
    const SHARED_WITH_USERS = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%theme}}';
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
            [['name', 'css'], 'required'],
            [['css'], 'string'],
            [['shared', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'color'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 510]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'color' => Yii::t('app', 'Main color'),
            'css' => Yii::t('app', 'Css'),
            'shared' => Yii::t('app', 'Shared With'),
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
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            // Delete relation with Forms
            FormUI::updateAll(['theme_id' => null], ['theme_id' => $this->id]);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThemeUsers()
    {
        return $this->hasMany(ThemeUser::className(), ['theme_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->via('themeUsers');
    }

    /**
     * Get all possible values of 'shared' attribute
     *
     * @return array
     */
    public static function sharedOptions()
    {
        if (Yii::$app->user->can('manageThemes')) {
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
