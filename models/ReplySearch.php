<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Reply;
use app\modules\v1\models\User;

/**
 * ReplySearch represents the model behind the search form about `app\modules\v1\models\Reply`.
 */
class ReplySearch extends Reply
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'msgid', 'fromid', 'toid', 'isread', 'created_at'], 'string'],
            [['content'], 'safe'],
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
    public $userinc;
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Reply::find()->orderBy('created_at desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if($params!=false &&!empty($params['ReplySearch'])){
        foreach ($params['ReplySearch'] as $name => $value1) {
        	if ($name==='fromid' && $value1!=null){
        		$appinfo=User::findOne(['fromid' => $params['ReplySearch']['fromid']]);
        		 
        		$this->value=$appinfo['id'];
        		if($appinfo ==null){
        			$this->value=0;
        		}
        
        	}
        	if ($name==='toid'&&$value1!=null){
        		if($params['ReplySearch']['toid']=='直接回复消息'){
        			$this->userinc=0;
        		}else{
        			$appinfo=User::findOne(['phone' => $params['ReplySearch']['toid']]);
        			$this->userinc=$appinfo['id'];
        			if($appinfo ==null){
        				$this->userinc=10000000001;
        			}
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
            'msgid' => $this->msgid,
            'fromid' => $this->value,
            'toid' => $this->userinc,
            'isread' => $this->isread,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
