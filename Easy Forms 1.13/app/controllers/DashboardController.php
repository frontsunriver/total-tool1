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

namespace app\controllers;

use app\components\User;
use app\helpers\ArrayHelper;
use app\models\FormSubmission;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\db\Query;

/**
 * Class DashboardController
 * @package app\controllers
 */
class DashboardController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        return true; // or false to not run the action
    }

    /**
     * Dashboard
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $limit = isset(Yii::$app->params['ListGroup.listSize']) ? Yii::$app->params['ListGroup.listSize'] : 5;

        /** @var User $currentUser */
        $currentUser = Yii::$app->user;

        // Current User's filter
        $forms = $currentUser->forms()->asArray()->all();
        $formIds = ArrayHelper::getColumn($forms, 'id');

        // Unique users today
        $usersQuery = new Query;
        $usersQuery->select(['domain_userid'])
            ->from('{{%event}}')
            ->where('DATE(FROM_UNIXTIME(collector_tstamp)) = CURRENT_DATE')
            ->distinct();

        // Unique users total
        $totalUsersQuery = new Query;
        $totalUsersQuery->select(['users'])
            ->from('{{%stats_performance}}')
            ->where('DATE(day) != CURRENT_DATE');

        // Submissions today
        $submissionsQuery = new Query;
        $submissionsQuery->select(['id'])
            ->from('{{%form_submission}}')
            ->andWhere('DATE(FROM_UNIXTIME(created_at)) = CURRENT_DATE');

        // Submissions total
        $totalSubmissionsQuery = new Query;
        $totalSubmissionsQuery->select(['id'])
            ->from('{{%form_submission}}');

        // Important restriction. If empty, don't show any form data
        $formIds = count($formIds) > 0 ? $formIds : 0;

        // Add user filter to queries
        $usersQuery->andFilterWhere(['app_id' => $formIds]);
        $totalUsersQuery->andFilterWhere(['app_id' => $formIds]);
        $submissionsQuery->andFilterWhere(['form_id' => $formIds]);
        $totalSubmissionsQuery->andFilterWhere(['form_id' => $formIds]);

        // Execute queries
        $users = $usersQuery->count();
        $totalUsers = $totalUsersQuery->sum('users');
        $submissions = $submissionsQuery->count();
        $totalSubmissions = $totalSubmissionsQuery->count();

        // Add today data to total
        $totalUsers = $totalUsers + $users;

        // Users / submissions = Conversion rate
        $submissionRate = 0;
        if ($users > 0 && $submissions > 0) {
            $submissionRate = round($submissions/$users*100);
        }

        $totalSubmissionRate = 0;
        if ($totalUsers > 0 && $totalSubmissions > 0) {
            $totalSubmissionRate = round($totalSubmissions/$totalUsers*100);
        }

        // Most viewed forms list by unique users
        $formsByUsersQuery = (new Query())
            ->select(['f.id', 'f.name', 'COUNT(DISTINCT(e.domain_userid)) AS users'])
            ->from('{{%event}} AS e')
            ->innerJoin('{{%form}} AS f', 'e.app_id = f.id')
            ->where(['event' => 'pv'])
            ->andWhere('DATE(FROM_UNIXTIME(collector_tstamp)) = CURRENT_DATE')
            ->groupBy(['f.id', 'f.name'])
            ->orderBy('users DESC')
            ->limit($limit);

        // Forms list by submissions
        $formsBySubmissionsQuery = (new Query())
            ->select(['f.id', 'f.name', 'COUNT(fs.id) AS submissions'])
            ->from('{{%form_submission}} AS fs')
            ->innerJoin('{{%form}} as f', 'fs.form_id = f.id')
            ->where('DATE(FROM_UNIXTIME(fs.created_at)) = CURRENT_DATE')
            ->groupBy(['f.id', 'f.name'])
            ->orderBy('submissions DESC')
            ->limit($limit);

        // Add user filter to queries
        $formsByUsersQuery->andFilterWhere(['f.id' => $formIds]);
        $formsBySubmissionsQuery->andFilterWhere(['fs.form_id' => $formIds]);

        // Execute queries
        $formsByUsers = $formsByUsersQuery->all();
        $formsBySubmissions = $formsBySubmissionsQuery->all();

        // Unread submissions
        $unreadSubmissions = FormSubmission::find()
            ->where(['new' => 1])
            ->andFilterWhere(['form_id' => $formIds])
            ->orderBy('id DESC')
            ->limit($limit)
            ->all();

        return $this->render('index', [
            'users' => $users,
            'submissions' => $submissions,
            'submissionRate' => $submissionRate,
            'totalUsers' => $totalUsers,
            'totalSubmissions' => $totalSubmissions,
            'totalSubmissionRate' => $totalSubmissionRate,
            'formsByUsers' => $formsByUsers,
            'formsBySubmissions' => $formsBySubmissions,
            'unreadSubmissions' => $unreadSubmissions,
        ]);
    }
}
