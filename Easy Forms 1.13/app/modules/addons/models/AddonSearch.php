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

use app\components\User;
use app\helpers\ArrayHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AddonSearch represents the model behind the search form about `app\modules\addons\models\Addon`.
 */
class AddonSearch extends Addon
{

    public $lastEditor;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['lastEditor'], 'string'],
            [['id', 'class', 'name', 'version', 'description', 'status', 'installed', 'lastEditor', 'updated_at'], 'safe'],
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
        $query = Addon::find();

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (isset($this->updated_at) && !empty($this->updated_at)) {
            list($start, $end) = explode(" - ", $this->updated_at);
            $startAt = strtotime(trim($start));
            // Add +1 day to the endAt
            $endAt = strtotime(trim($end)) + (24 * 60 * 60);
            $query->andFilterWhere(['between', '{{%addon}}.updated_at', $startAt, $endAt]);
        }

        $query->andFilterWhere([
            '{{%addon}}.status' => $this->status,
            'installed' => $this->installed,
            'shared' => $this->shared,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', '{{%user}}.username', $this->lastEditor]);

        /** @var User $currentUser */
        $currentUser = Yii::$app->user;

        // If user has global access
        if ($currentUser->can("viewAddons")) {
            return $dataProvider;
        }

        $addons = $currentUser->addons()->asArray()->all();
        $addonIds = ArrayHelper::getColumn($addons, 'id');

        // Important restriction. If empty, don't show any addon
        if (count($addonIds) === 0) {
            $query->andFilterWhere(['like', '{{%addon}}.id', 0]);
        } else {
            $query->andFilterWhere(['{{%addon}}.id' => $addonIds]);
        }

        return $dataProvider;
    }
}
