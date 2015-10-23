<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Judge;
use app\modules\v1\models\User;

/**
 * JudgeSearch represents the model behind the search form about `app\modules\v1\models\Judge`.
 */
class JudgeSearch extends Judge
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['message'], 'safe'],
            [['usernickname','userid'], 'string'],
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
    public $value;

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Judge::find()->join('INNER JOIN','user','judge.userid=user.id')->orderBy('created_at desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        if($params!=false &&!empty($params['JudgeSearch'])){
        	//$b=$a;
        	//=app::find()->where("name= :name",[':name'=>'QQ'])->one();
        	//if()
        	foreach ($params['JudgeSearch'] as $name => $value1) {
        		if ($name==='userid' && $value1!=null){
        			$appinfo=User::findOne(['phone' => $params['JudgeSearch']['userid']]);
        
        			$this->value=$appinfo['id'];
        			if($appinfo ==null){
        				$this->value=0;
        			}
        
        		}
        	}
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->value,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);
        if (isset($params['JudgeSearch'])&&isset($params['JudgeSearch']['usernickname'])){
        	$query->andFilterWhere(['like', 'user.nickname', $params['JudgeSearch']['usernickname']]);
        
        }
        return $dataProvider;
    }
}
