<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Appcomments;
use app\modules\v1\models\User;
use app\models\app;

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
        	[['userid','commentstars'],'integer'],
            [['id', 'appid'], 'string'],
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
    	
        $query = Appcomments::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        //$value = 0;
        if($params!=false &&!empty($params['AppcommentsSearch'])){
        	//$b=$a;
        	//=app::find()->where("name= :name",[':name'=>'QQ'])->one();
        //if()
         foreach ($params['AppcommentsSearch'] as $name => $value1) {
                if ($name==='appid' && $value1!=null){
                	$appinfo=app::findOne(['name' => $params['AppcommentsSearch']['appid']]);
                	
        			$this->value=$appinfo['id'];
        			if($appinfo ==null){
        				$this->value=0;
        			}

                }
                if ($name==='userid'&&$value1!=null){
                	$appinfo=User::findOne(['phone' => $params['AppcommentsSearch']['userid']]);
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
            'appid' => $this->value,
            'userid' => $this->userinc,
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
