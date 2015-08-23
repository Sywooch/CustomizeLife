<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Usertoapp;
use app\modules\v1\models\User;
use app\models\app;

/**
 * UsertoappSearch represents the model behind the search form about `app\modules\v1\models\Usertoapp`.
 */
class UsertoappSearch extends Usertoapp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'appid', 'created_at'], 'string'],
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
        $query = Usertoapp::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if($params!=false &&!empty($params['UsertoappSearch'])){
        	//$b=$a;
        	//=app::find()->where("name= :name",[':name'=>'QQ'])->one();
        	//if()
        	foreach ($params['UsertoappSearch'] as $name => $value1) {
        		if ($name==='appid' && $value1!=null){
        			$appinfo=app::findOne(['name' => $params['UsertoappSearch']['appid']]);
        			 
        			$this->value=$appinfo['id'];
        			if($appinfo ==null){
        				$this->value=0;
        			}
        
        		}
        		if ($name==='userid'&&$value1!=null){
        			$appinfo=User::findOne(['phone' => $params['UsertoappSearch']['userid']]);
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
            'userid' => $this->userinc,
            'appid' => $this->value,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
