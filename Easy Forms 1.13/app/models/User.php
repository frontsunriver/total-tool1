<?php

namespace app\models;

use app\components\behaviors\DateTrait;
use app\helpers\ArrayHelper;
use app\modules\addons\models\Addon;
use app\modules\addons\models\AddonUser;
use app\modules\addons\models\AddonUserRole;
use Da\User\Model\SocialNetworkAccount;
use Da\User\Model\User as BaseUser;
use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property bool $isAdmin
 * @property bool $isBlocked
 * @property bool $isConfirmed      whether user account has been confirmed or not
 *
 * @property int $id
 * @property string $email
 * @property string $username
 * @property string $preferences
 * @property string $password_hash
 * @property string $access_token
 * @property string $unconfirmed_email
 * @property string $registration_ip
 * @property int $flags
 * @property int $confirmed_at
 * @property int $blocked_at
 * @property int $last_login_at
 * @property string $last_login_ip
 * @property string $auth_tf_key
 * @property int $auth_tf_enabled
 * @property int $password_changed_at
 * @property int $gdpr_consent
 * @property int $gdpr_consent_date
 * @property int $gdpr_deleted
 * @property string $auth_key
 * @property int $created_at
 * @property int $updated_at
 *
 * @property SocialNetworkAccount[] $socialNetworkAccounts
 * @property Profile $profile
 * @property Form[] $forms
 * @property Theme[] $themes
 * @property Template[] $templates
 * @property Addon[] $addons
 * @property Form[] $sharedForms
 * @property Theme[] $sharedThemes
 * @property Template[] $sharedTemplates
 * @property Addon[] $sharedAddons
 * @property Addon[] $sharedAddonsByUserRole
 *
 */
class User extends BaseUser
{
    use DateTrait;

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForms()
    {
        return $this->hasMany(Form::className(), ['created_by' => 'id'])->inverseOf('author');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThemes()
    {
        return $this->hasMany(Theme::className(), ['created_by' => 'id'])->inverseOf('author');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['created_by' => 'id'])->inverseOf('author');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddons()
    {
        return $this->hasMany(Addon::className(), ['created_by' => 'id'])->inverseOf('owner');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserForms()
    {
        return $this->hasMany(FormUser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserThemes()
    {
        return $this->hasMany(ThemeUser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTemplates()
    {
        return $this->hasMany(TemplateUser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddons()
    {
        return $this->hasMany(AddonUser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSharedForms()
    {
        return $this->hasMany(Form::className(), ['id' => 'form_id'])
            ->via('userForms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSharedThemes()
    {
        return $this->hasMany(Theme::className(), ['id' => 'theme_id'])
            ->via('userThemes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSharedTemplates()
    {
        return $this->hasMany(Template::className(), ['id' => 'template_id'])
            ->via('userTemplates');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSharedAddons()
    {
        return $this->hasMany(Addon::className(), ['id' => 'addon_id'])
            ->via('userAddons');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSharedAddonsByUserRoles()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        $roles = ArrayHelper::getColumn($roles, 'name', false);
        $addonRoles = AddonUserRole::find()
            ->select(['addon_id'])
            ->where(['in', 'role_id', $roles])
            ->asArray()->all();
        $addonRoles = ArrayHelper::getColumn($addonRoles, 'addon_id', false);
        return Addon::find()->where(['in', 'id', $addonRoles]);
    }
}
