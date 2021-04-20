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

namespace app\models\search;

use app\components\User;
use app\helpers\ArrayHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Form;

/**
 * FormSearch represents the model behind the search form about `app\models\Form`.
 */
class FormSearch extends Form
{

    public $lastEditor;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'is_private', 'save', 'schedule', 'total_limit', 'user_limit',
                'resume', 'autocomplete', 'novalidate', 'analytics', 'honeypot', 'recaptcha',
                'shared'], 'integer'],
            [['password', 'language', 'lastEditor'], 'string'],
            [['name', 'message', 'language', 'lastEditor', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Form::find();

        // Important: join the query with our lastEditor relation (Ref: User model)
        $query->joinWith(['lastEditor']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->user->preferences->get('GridView.pagination.pageSize'),
            ],
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC,
                ]
            ],
        ]);

        // Search forms by User username
        $dataProvider->sort->attributes['lastEditor'] = [
            'asc' => ['{{%user}}.username' => SORT_ASC],
            'desc' => ['{{%user}}.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            '{{%form}}.status' => $this->status,
            'is_private' => $this->is_private,
            'schedule' => $this->schedule,
            'total_limit' => $this->total_limit,
            'user_limit' => $this->user_limit,
            'save' => $this->save,
            'resume' => $this->resume,
            'autocomplete' => $this->autocomplete,
            'novalidate' => $this->novalidate,
            'analytics' => $this->analytics,
            'honeypot' => $this->honeypot,
            'recaptcha' => $this->recaptcha,
            'shared' => $this->shared,
            'message' => $this->message,
        ]);

        if (!empty($this->updated_at)) {
            list($start, $end) = explode(" - ", $this->updated_at);
            $startAt = strtotime(trim($start));
            // Add +1 day to the endAt
            $endAt = strtotime(trim($end)) + (24 * 60 * 60);
            $query->andFilterWhere(['between', '{{%form}}.updated_at', $startAt, $endAt]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', '{{%user}}.username', $this->lastEditor]);

        /** @var User $currentUser */
        $currentUser = Yii::$app->user;

        // If user has global access
        if ($currentUser->can("viewForms")) {
            return $dataProvider;
        }

        $forms = $currentUser->forms()->asArray()->all();
        $formIds = ArrayHelper::getColumn($forms, 'id');

        // Important restriction. If empty, don't show any form
        $formIds = count($formIds) > 0 ? $formIds : 0;
        $query->andFilterWhere(['{{%form}}.id' => $formIds]);

        return $dataProvider;
    }
}
