<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Appcomments;

/**
 * AppcommentsSearch represents the model behind the search form about `app\modules\v1\models\Appcomments`.
 */
class AppcommentsSearch extends Appcomments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'appid', 'userid', 'commentstars', 'created_at'], 'integer'],
            [['userthumb', 'usernickname', 'comments', 'title'], 'safe'],
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
        $query = Appcomments::find();

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
            'userid' => $this->userid,
            'commentstars' => $this->commentstars,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'userthumb', $this->userthumb])
            ->andFilterWhere(['like', 'usernickname', $this->usernickname])
            ->andFilterWhere(['like', 'comments', $this->comments])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
