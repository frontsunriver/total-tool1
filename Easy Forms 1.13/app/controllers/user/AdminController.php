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

namespace app\controllers\user;

use Da\User\Event\UserEvent;
use Da\User\Filter\AccessRuleFilter;
use Da\User\Controller\AdminController as BaseController;
use Da\User\Service\UserBlockService;
use Da\User\Service\UserConfirmationService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class AdminController extends BaseController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'confirm' => ['post'],
                    'block' => ['post'],
                    'switch-identity' => ['post'],
                    'password-reset' => ['post'],
                    'force-password-change' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRuleFilter::className(),
                ],
                'rules' => [
                    ['actions' => ['index', 'info'], 'allow' => true, 'roles' => ['viewUsers']],
                    ['actions' => ['create'], 'allow' => true, 'roles' => ['createUsers']],
                    ['actions' => ['update', 'update-profile'], 'allow' => true, 'roles' => ['updateUsers']],
                    ['actions' => ['confirm', 'confirm-multiple'], 'allow' => true, 'roles' => ['confirmUsers']],
                    ['actions' => ['block', 'block-multiple'], 'allow' => true, 'roles' => ['blockUsers']],
                    ['actions' => ['password-reset'], 'allow' => true, 'roles' => ['resetUserPasswords']],
                    ['actions' => ['force-password-change'], 'allow' => true, 'roles' => ['forcePasswordChange']],
                    ['actions' => ['assignments'], 'allow' => true, 'roles' => ['assignUserPermissions']],
                    ['actions' => ['delete'], 'allow' => true, 'roles' => ['deleteUsers']],
                    ['allow' => true, 'actions' => ['switch-identity'], 'roles' => ['@']],
                ],
            ],
        ];
    }

    public function actionConfirmMultiple()
    {
        $ids = Yii::$app->getRequest()->post('ids');

        if (empty($ids)) {
            throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
        } else {
            $confirmed = false;
            foreach ($ids as $id) {
                /** @var \Da\User\Model\User $user */
                $user = $this->userQuery->where(['id' => $id])->one();
                /** @var UserEvent $event */
                $event = $this->make(UserEvent::className(), [$user]);

                $this->trigger(UserEvent::EVENT_BEFORE_CONFIRMATION, $event);

                if ($this->make(UserConfirmationService::class, [$user])->run()) {
                    $confirmed = true;
                    $this->trigger(UserEvent::EVENT_AFTER_CONFIRMATION, $event);
                } else {
                    $confirmed = false;
                    Yii::$app->getSession()->setFlash(
                        'warning',
                        Yii::t('app', 'Unable to confirm user. Please, try again.')
                    );
                    break;
                }
            }

            if ($confirmed) {
                Yii::$app->getSession()->setFlash(
                    'success',
                    Yii::t('app', 'Users have been confirmed')
                );
            }

            return $this->redirect(Url::previous('actions-redirect'));
        }
    }

    public function actionBlockMultiple()
    {
        $ids = Yii::$app->getRequest()->post('ids');

        if (empty($ids)) {
            throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
        } else {
            $blocked = false;
            foreach ($ids as $id) {
                if ((int)$id === Yii::$app->user->getId()) {
                    $blocked = false;
                    Yii::$app->getSession()->setFlash('danger', Yii::t('app', 'You cannot remove your own account'));
                    break;
                } else {
                    /** @var \Da\User\Model\User $user */
                    $user = $this->userQuery->where(['id' => $id])->one();
                    /** @var UserEvent $event */
                    $event = $this->make(UserEvent::class, [$user]);

                    if ($this->make(UserBlockService::class, [$user, $event, $this])->run()) {
                        $blocked = true;
                    } else {
                        $blocked = false;
                        Yii::$app->getSession()->setFlash('danger', Yii::t('app', 'Unable to update block status.'));
                        break;
                    }
                }
            }

            if ($blocked) {
                Yii::$app->getSession()->setFlash(
                    'success',
                    Yii::t('app', 'Users block status have been updated.')
                );
            }

            return $this->redirect(Url::previous('actions-redirect'));
        }
    }
}