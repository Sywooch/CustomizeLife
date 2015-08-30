<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Zan;
use app\modules\v1\models\User;
/**
 * ZanSearch represents the model behind the search form about `app\modules\v1\models\Zan`.
 */
class ZanSearch extends Zan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'myid', 'msgid'], 'integer'],
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
        $query = Zan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        //$value = 0;
        if($params!=false &&!empty($params['ZanSearch'])){
        	//$b=$a;
        	//=app::find()->where("name= :name",[':name'=>'QQ'])->one();
        	//if()
        	foreach ($params['ZanSearch'] as $name => $value1) {
        		if ($name==='myid' && $value1!=null){
        			$appinfo=User::findOne(['phone' => $params['ZanSearch']['myid']]);
        			 
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
           // 'id' => $this->id,
            'myid' => $this->value,
            'msgid' => $this->msgid,
        ]);

        return $dataProvider;
    }
}
