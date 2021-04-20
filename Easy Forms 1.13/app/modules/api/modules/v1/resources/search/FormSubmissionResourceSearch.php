<?php

namespace app\modules\api\modules\v1\resources\search;

use app\components\User;
use app\helpers\ArrayHelper;
use app\modules\api\modules\v1\resources\SubmissionResource;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class FormSubmissionResourceSearch extends SubmissionResource
{

    public $lastEditor;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
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
     * @param integer $scope Form ID
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($scope, $params)
    {
        $query = SubmissionResource::find()
            ->andWhere(['form_id' => $scope]);

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
            'form_id' => $this->form_id,
        ]);

        if (isset($this->updated_at) && !empty($this->updated_at)) {
            list($start, $end) = explode(" - ", $this->updated_at);
            $startAt = strtotime(trim($start));
            // Add +1 day to the endAt
            $endAt = strtotime(trim($end)) + (24 * 60 * 60);
            $query->andFilterWhere(['between', '{{%form}}.updated_at', $startAt, $endAt]);
        }

        $query
            ->andFilterWhere(['like', '{{%user}}.username', $this->lastEditor]);

        /** @var User $currentUser */
        $currentUser = Yii::$app->user;

        // If user has global access
        if ($currentUser->can("viewForms")) {
            return $dataProvider;
        }

        $forms = $currentUser->forms()->asArray()->all();
        $formIds = ArrayHelper::getColumn($forms, 'id');

        // Important restriction. If empty, don't show any record
        $formIds = count($formIds) > 0 ? $formIds : 0;
        $query->andFilterWhere(['{{%form_submission}}.form_id' => $formIds]);

        return $dataProvider;
    }
}