<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Apptopicture;

/**
 * ApptopictureSearch represents the model behind the search form about `app\modules\v1\models\Apptopicture`.
 */
class ApptopictureSearch extends Apptopicture
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'appid'], 'integer'],
            [['picture'], 'safe'],
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
        $query = Apptopicture::find();

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
            'appid' => $this->appid,
        ]);

        $query->andFilterWhere(['like', 'picture', $this->picture]);

        return $dataProvider;
    }
}
