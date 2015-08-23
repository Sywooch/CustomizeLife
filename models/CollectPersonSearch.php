<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\CollectPerson;
use app\modules\v1\models\User;
use app\models\app;


/**
 * CollectPersonSearch represents the model behind the search form about `app\modules\v1\models\CollectPerson`.
 */
class CollectPersonSearch extends CollectPerson
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid',], 'integer'],
            [['created_at', 'app'],'string']
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
        $query = CollectPerson::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

      $this->load($params);
        //$value = 0;
     if($params!=false &&!empty($params['CollectPersonSearch'])){
        	//$b=$a;
        	//=app::find()->where("name= :name",[':name'=>'QQ'])->one();
        	//if()
        	foreach ($params['CollectPersonSearch'] as $name => $value1) {
        		if ($name==='app' && $value1!=null){
        			$appinfo=app::findOne(['name' => $params['CollectPersonSearch']['app']]);
        			 
        			$this->value=$appinfo['id'];
        			if($appinfo ==null){
        				$this->value=0;
        			}
        
        		}
        		if ($name==='userid'&&$value1!=null){
        			$appinfo=User::findOne(['phone' => $params['CollectPersonSearch']['userid']]);
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
            //'id' => $this->id,
            'userid' => $this->userinc,
            'created_at' => $this->created_at,
            'app' => $this->value,
        ]);

        return $dataProvider;
    }
}
