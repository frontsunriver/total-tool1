<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.10
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\rbac\rules;

use app\components\User;
use app\helpers\ArrayHelper;
use yii;
use yii\rbac\Rule;

/**
 * Class SharedRule
 * Verifies if resource is shared with current user
 * @package app\components\rbac\rules
 */
class SharedRule extends Rule
{

    public $name = 'isShared';

    /**
     * @param string|integer $user the user ID.
     * @param yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['listing']) && $params['listing']) {
            // Used by Controllers and Data Providers to list a collection
            return true;
        } elseif (isset($params['model'])) {
            $model = $params['model'];
            $modelClass = get_class($model);
            if (isset($model->shared)) {
                if (!$model->shared) { // Not-Shared. By default.
                    return false;
                } else if ($model->shared == 1) { // Shared to everyone
                    return true;
                } else if ($model->shared >= 2) { // Shared with specific user or role
                    /** @var User $user */
                    $user = Yii::$app->user;
                    $sharedIds = $user->getSharedModelIds($modelClass);
                    return in_array($model->id, $sharedIds);
                }
            }
        } elseif (isset($params['ids'], $params['modelClass'])) {
            $ids = $params['ids'];
            $modelClass = $params['modelClass'];
            /** @var User $user */
            $user = Yii::$app->user;
            $sharedIds = $user->getSharedModelIds($modelClass);
            foreach ($ids as $id) {
                // Not shared with current user
                if (!in_array($id, $sharedIds)) {
                    // If it is shared to everyone
                    $model = $modelClass::findOne(['id' => $id]);
                    if (isset($model, $model->shared) && $model->shared == 1) {
                        continue;
                    }
                    return false;
                }
            }
            return true;
        }
        // Denied access by default
        return false;
    }
}
