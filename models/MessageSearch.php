<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Message;
use app\modules\v1\models\User;

/**
 * MessageSearch represents the model behind the search form about `app\modules\v1\models\Message`.
 */
class MessageSearch extends Message
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'created_at'], 'integer'],
            [['content', 'kind', 'area'], 'safe'],
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
        $query = Message::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        if($params!=false &&!empty($params['MessageSearch'])){
        	//$b=$a;
        	//=app::find()->where("name= :name",[':name'=>'QQ'])->one();
        	//if()
        	foreach ($params['MessageSearch'] as $name => $value1) {
        		if ($name==='userid'&&$value1!=null){
        			$appinfo=User::findOne(['phone' => $params['MessageSearch']['userid']]);
        			$this->value=$appinfo['id'];
        			if($appinfo ==null){
        				$this->userinc=0;
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

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'kind', $this->kind])
            ->andFilterWhere(['like', 'area', $this->area]);

        return $dataProvider;
    }
}
