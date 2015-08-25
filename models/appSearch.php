<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\app;

/**
 * appSearch represents the model behind the search form about `app\models\app`.
 */
class appSearch extends app
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stars', 'downloadcount', 'commentscount', 'updated_at'], 'integer'],
            [['name', 'version', 'profile', 'android_url', 'ios_url', 'introduction', 'size', 'icon', 'updated_log', 'kind'], 'safe'],
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
        $query = app::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'stars' => $this->stars,
            'downloadcount' => $this->downloadcount,
            'commentscount' => $this->commentscount,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'profile', $this->profile])
            ->andFilterWhere(['like', 'android_url', $this->android_url])
            ->andFilterWhere(['like', 'ios_url', $this->ios_url])
            ->andFilterWhere(['like', 'introduction', $this->introduction])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'updated_log', $this->updated_log])
            ->andFilterWhere(['like', 'kind', $this->kind]);

        return $dataProvider;
    }
}
