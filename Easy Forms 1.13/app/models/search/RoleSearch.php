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

use Yii;
use Da\User\Search\RoleSearch as BaseRoleSearch;
use yii\data\ArrayDataProvider;
use yii\db\Query;


class RoleSearch extends BaseRoleSearch
{
    /**
     * @inheritDoc
     */
    public function search($params = [])
    {
        /** @var ArrayDataProvider $dataProvider */
        $dataProvider = $this->make(ArrayDataProvider::className());

        $dataProvider->setPagination([
            'pageSize' => Yii::$app->user->preferences->get('GridView.pagination.pageSize'),
        ]);

        $query = (new Query())
            ->select(['name', 'description', 'rule_name'])
            ->andWhere(['type' => $this->getType()])
            ->from($this->getAuthManager()->itemTable);

        if ($this->load($params) && $this->validate()) {
            $query
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'rule_name', $this->rule_name]);
        }

        $dataProvider->allModels = $query->all($this->getAuthManager()->db);

        return $dataProvider;
    }
}
