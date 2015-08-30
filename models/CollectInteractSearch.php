<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\CollectInteract;
use app\modules\v1\models\User;

/**
 * CollectInteractSearch represents the model behind the search form about `app\modules\v1\models\CollectInteract`.
 */
class CollectInteractSearch extends CollectInteract
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'created_at', 'msg'], 'integer'],
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
        $query = CollectInteract::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        if($params!=false &&!empty($params['CollectInteractSearch'])){
        	//$b=$a;
        	//=app::find()->where("name= :name",[':name'=>'QQ'])->one();
        	//if()
        	foreach ($params['CollectInteractSearch'] as $name => $value1) {
        		if ($name==='userid'&&$value1!=null){
        			$appinfo=User::findOne(['phone' => $params['CollectInteractSearch']['userid']]);
        			$this->userinc=$appinfo['id'];
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
            'userid' => $this->userinc,
            'created_at' => $this->created_at,
            'msg' => $this->msg,
        ]);

        return $dataProvider;
    }
}
