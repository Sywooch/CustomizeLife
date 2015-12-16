<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\app;

/**
 * appSearch represents the model behind the search form about `app\models\app`.
 */
class appSearch extends app
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'downloadcount', 'commentscount', 'updated_at'], 'integer'],
        	[['stars'],'double'],
            [['name', 'version', 'profile', 'android_url', 'ios_url', 'introduction', 'size', 'icon', 'updated_log', 'kind','reltag'], 'safe'],
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
        //$query = app::find();
        $this->load($params);
        global $quary;
        if (isset($params['appSearch'])&&isset($params['appSearch']['reltag'])&&!empty($params['appSearch']['reltag'])){
        	$query= app::find()->from ( 'app a' )
        	->join('INNER JOIN', 'apptoreltag ar','a.id=ar.appid')
        	->join('INNER JOIN', 'reltag r','ar.tagid=r.id')
        	->where ( ['like','tag',$params['appSearch']['reltag']] );
        }else if(isset($params['appSearch'])&&isset($params['appSearch']['kind'])&&!empty($params['appSearch']['kind'])){
        		$query= app::find()->from ( 'app a' )
        		->join('INNER JOIN', 'appofkind ak','a.id=ak.appid')
        		->join('INNER JOIN', 'tag t','ak.kindid=t.id')
        		->where ( ['like','second',$params['appSearch']['kind']] );
        } else{
        	$query = app::find()->where('version IS NOT NULL')->orderBy('updated_at desc');
        }
        
    	
    	
        $dataProvider = new ActiveDataProvider([
        		'query' => $query,
        ]);
       
        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'stars' => $this->stars,
            'downloadcount' => $this->downloadcount,
            'commentscount' => $this->commentscount,
            'updated_at' => $this->updated_at,
        ]);
 
//         for ($j=0;$j<count($query->all());$j++){
//         	    $query->all()[$j]->reltag="";
// 	        $taginfo=(new \yii\db\Query ())->select ( 'r.tag' )->from ( 'apptoreltag a' )
// 	        ->join('INNER JOIN', 'reltag r','a.tagid=r.id')
// 	        ->where ( [
// 	        		'a.appid' => $query->all()[$j]['id']
// 	        ] )->all();
// 	        if(count($taginfo)>0){
// 		        	foreach($taginfo as $tag){
// 		        		$query->all()[$j]->reltag ="ssss";
// 		        		var_dump($tag['tag']);
// 		        		var_dump('\n');
// 		        	}
// 	        }
//         }
//         var_dump($query->all());
     
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'profile', $this->profile])
            ->andFilterWhere(['like', 'android_url', $this->android_url])
            ->andFilterWhere(['like', 'ios_url', $this->ios_url])
            ->andFilterWhere(['like', 'introduction', $this->introduction])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'updated_log', $this->updated_log])
            ->andFilterWhere(['like', 'kind', $this->kind]);
        
        

        return $dataProvider;
    }
}
