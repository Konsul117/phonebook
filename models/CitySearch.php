<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\City;

/**
 * CitySearch represents the model behind the search form about `app\models\City`.
 */
class CitySearch extends City
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'region_id', 'region_global_id', 'gmt', 'sort_id', 'old_region_id', 'is_deleted', 'is_published', 'timezone'], 'integer'],
            [['id_1c', 'code', 'region_1c', 'title', 'title_1c', 'geoip_city', 'path', 'alternative_path', 'old_path', 'service_center', 'manufacturer_service_center', 'yandex_confirm_code', 'yandex_confirm_code_tp', 'yandex_confirm_code_bazar'], 'safe'],
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
        $query = City::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'region_id' => $this->region_id,
            'region_global_id' => $this->region_global_id,
            'gmt' => $this->gmt,
            'sort_id' => $this->sort_id,
            'old_region_id' => $this->old_region_id,
            'is_deleted' => $this->is_deleted,
            'is_published' => $this->is_published,
            'timezone' => $this->timezone,
        ]);

        $query->andFilterWhere(['like', 'id_1c', $this->id_1c])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'region_1c', $this->region_1c])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title_1c', $this->title_1c])
            ->andFilterWhere(['like', 'geoip_city', $this->geoip_city])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'alternative_path', $this->alternative_path])
            ->andFilterWhere(['like', 'old_path', $this->old_path])
            ->andFilterWhere(['like', 'service_center', $this->service_center])
            ->andFilterWhere(['like', 'manufacturer_service_center', $this->manufacturer_service_center])
            ->andFilterWhere(['like', 'yandex_confirm_code', $this->yandex_confirm_code])
            ->andFilterWhere(['like', 'yandex_confirm_code_tp', $this->yandex_confirm_code_tp])
            ->andFilterWhere(['like', 'yandex_confirm_code_bazar', $this->yandex_confirm_code_bazar]);

        return $dataProvider;
    }
}
