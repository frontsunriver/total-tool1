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

namespace app\components;

use app\components\behaviors\UserPreferences;
use app\helpers\ArrayHelper;
use app\models\Form;
use app\models\Template;
use app\models\Theme;
use app\modules\addons\models\Addon;
use Da\User\Module;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\ActiveQuery;
use Da\User\Helper\AuthHelper;

/**
 * Class User
 * @package app\components
 *
 * User Component
 */
class User extends \yii\web\User
{
    /**
     * @var null|UserPreferences
     */
    public $preferences = null;

    /**
     * @inheritdoc
     */
    public $enableAutoLogin = true;

    /**
     * @inheritdoc
     */
    public $loginUrl = ["/user/security/login"];

    /**
     * @inheritdoc
     */
    public $identityClass = 'app\models\User';

    /**
     * Initializes the application component.
     */
    public function init()
    {
        parent::init();

        $this->preferences = new UserPreferences();
    }

    /**
     * @inheritDoc
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('user');

        // Grant access if the user (ID) is an application administrator
        if (!empty($module->administrators) && in_array($this->id, $module->administrators, false)) {
            return true;
        }

        return parent::can($permissionName, $params, $allowCaching);
    }

    /**
     * Model ids created by this user
     *
     * @param ActiveQuery $query
     * @param string $columnName
     * @return array
     */
    public function getOwnModelIds($query, $columnName = 'id')
    {
        if (!($query instanceof ActiveQuery)) {
            throw new InvalidArgumentException("Parameter must be an instance of yii\db\ActiveQuery");
        }
        $models = $query->where([
            'created_by' => Yii::$app->user->id
        ])->asArray()->all();
        return count($models) > 0 ? ArrayHelper::getColumn($models, $columnName) : [];
    }

    /**
     * Model ids shared to this user
     *
     * @param string $modelClass
     * @return array
     */
    public function getSharedModelIds($modelClass)
    {
        /** @var \app\models\User $user */
        $user = $this->identity;

        $models = [];
        if ($modelClass === Form::className()) {
            $models = $user->getSharedForms()->select(['id'])->asArray()->all();
        } elseif ($modelClass === Theme::className()) {
            $models = $user->getSharedThemes()->select(['id'])->asArray()->all();
        } elseif ($modelClass === Template::className()) {
            $models = $user->getSharedTemplates()->select(['id'])->asArray()->all();
        } elseif ($modelClass === Addon::className()) {
            $addons = $user->getSharedAddons()->union($user->getSharedAddonsByUserRoles());
            $models = $addons->asArray()->all();
        }
        return count($models) > 0 ? ArrayHelper::getColumn($models, 'id') : [];
    }

    /**
     * Return ActiveQuery of Form models accessible by this user
     *
     * Important! Don't select columns with the returned active query,
     * because we can't get unexpected behaviors
     *
     * @return ActiveQuery
     */
    public function forms()
    {
        // If user can viw all forms
        if ($this->can("viewForms")) {
            // Return all forms
            return Form::find();
        }

        /** @var \app\models\User $user */
        $user = $this->identity;

        // Shared forms with everyone
        $forms = Form::find()->where(['shared' => Form::SHARED_EVERYONE]);

        // My Own forms
        if ($this->can("viewOwnForms", ['listing' => true])) {
            $forms->union($user->getForms());
        }

        // Shared forms with me
        if ($this->can("viewSharedForms", ['listing' => true])) {
            $forms->union($user->getSharedForms());
        }

        // Other Forms
        if ($this->can("viewOtherForms", ['listing' => true])) {
            $otherForms = Form::find()->where(['!=', 'created_by', $this->id]);
            $forms->union($otherForms);
        }

        return $forms;
    }

    /**
     * Return ActiveQuery of Theme models accessible by this user
     *
     * Important! Don't select columns with the returned active query,
     * because we can't get unexpected behaviors
     *
     * @return ActiveQuery
     */
    public function themes()
    {
        // If user can viw all themes
        if ($this->can("viewThemes")) {
            // Return all themes
            return Theme::find();
        }

        /** @var \app\models\User $user */
        $user = $this->identity;

        // Shared themes with everyone
        $themes = Theme::find()->where(['shared' => Theme::SHARED_EVERYONE]);

        // My Own themes
        if ($this->can("viewOwnThemes", ['listing' => true])) {
            $themes->union($user->getThemes());
        }

        // Shared themes with me
        if ($this->can("viewSharedThemes", ['listing' => true])) {
            $themes->union($user->getSharedThemes());
        }

        // Other Themes
        if ($this->can("viewOtherThemes", ['listing' => true])) {
            $otherThemes = Theme::find()->where(['!=', 'created_by', $this->id]);
            $themes->union($otherThemes);
        }

        return $themes;
    }

    /**
     * Return ActiveQuery of Template models accessible by this user
     *
     * Important! Don't select columns with the returned active query,
     * because we can't get unexpected behaviors
     *
     * @return ActiveQuery
     */
    public function templates()
    {
        // If user can viw all templates
        if ($this->can("viewTemplates")) {
            // Return all templates
            return Template::find();
        }

        /** @var \app\models\User $user */
        $user = $this->identity;

        // Shared templates with everyone
        $templates = Template::find()->where(['shared' => Template::SHARED_EVERYONE]);

        // My Own templates
        if ($this->can("viewOwnTemplates", ['listing' => true])) {
            $templates->union($user->getTemplates());
        }

        // Shared templates with me
        if ($this->can("viewSharedTemplates", ['listing' => true])) {
            $templates->union($user->getSharedTemplates());
        }

        // Other Templates
        if ($this->can("viewOtherTemplates", ['listing' => true])) {
            $otherTemplates = Template::find()->where(['!=', 'created_by', $this->id]);
            $templates->union($otherTemplates);
        }

        return $templates;
    }

    /**
     * Return ActiveQuery of Addon models accessible by this user
     *
     * Important! Don't select columns with the returned active query,
     * because we can't get unexpected behaviors
     *
     * @return ActiveQuery
     */
    public function addons()
    {
        // If user can viw all addons
        if ($this->can("viewAddons")) {
            // Return all addons
            return Addon::find();
        }

        /** @var \app\models\User $user */
        $user = $this->identity;

        // Shared addons with everyone
        $addons = Addon::find()->where(['shared' => Addon::SHARED_EVERYONE]);

        // My Own addons
        if ($this->can("viewOwnAddons", ['listing' => true])) {
            $addons->union($user->getAddons());
        }

        // Shared addons with me
        if ($this->can("viewSharedAddons", ['listing' => true])) {
            $addons->union($user->getSharedAddons());
        }

        // Shared addons with my user roles
        if ($this->can("viewSharedAddons", ['listing' => true])) {
            $addons->union($user->getSharedAddonsByUserRoles());
        }

        // Other Addons
        if ($this->can("viewOtherAddons", ['listing' => true])) {
            $otherAddons = Addon::find()->where(['!=', 'created_by', $this->id]);
            $addons->union($otherAddons);
        }

        return $addons;
    }

}
