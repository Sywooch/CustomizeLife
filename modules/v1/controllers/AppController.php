<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
use yii\rest\ActiveController;
//use yii\rest\ActiveController;
use app\modules\v1\models\Appl;
use app\modules\v1\models\Apptopicture;
use app\modules\v1\models\Appcomments;
use app\modules\v1\models\Message;
use yii\filters\AccessControl;
use app\modules\v1\models\app\modules\v1\models;

class AppController extends ActiveController {
	public $modelClass = 'app\modules\v1\models\Appl';
	public $serializer = [ 
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items' 
	];
	public function actionKind() {
		$data = Yii::$app->request->post ();
		
		$query = Appl::find ()->select ( '*' )->join ( 'INNER JOIN', 'appofkind', 'app.id=appofkind.appid' )->where ( [ 
				'appofkind.kind' => $data ['kind'] 
		] );
		
		$pages = new Pagination ( [ 
				'totalCount' => $query->count (),
				'pageSize' => '3' 
		] );
		$models = $query->offset ( $pages->offset )->limit ( $pages->limit )->all ();
		
		$result = array ();
		$result ['item'] = array ();
		foreach ( $models as $model ) {
			$result ['item'] [] = $model;
		}
		$result ['_meta'] = array (
				'pageCount' => $pages->pageCount,
				'currentPage' => $pages->page + 1 
		);
		
		return $result;
	}
	public function actionGetapp(){
		$data=Yii::$app->request->post();
		$appl=new Appl();
		$apptopic=new Apptopicture();
		$appcom=new Appcomments();
		$appinfo = $appl->find ()->where ( [ 
					'id' => $data ['appid'] 
			] )->one ();
		$result=array();
		$result['basic']=$appinfo;
		$apppics = $apptopic->find ()->where ( [
				'appid' => $data ['appid']
		] )->all ();
		$result['picture_urls']=array();
		foreach ($apppics as $apptopic){
			$result['picture_urls'][]=$apptopic;
		}
		$appcoms = $appcom->find ()->where ( [
				'appid' => $data ['appid']
		] )->all ();
		$result['comments']=array();
		foreach ($appcoms as $appcomment){
			$result['comments'][]=$appcomment;
		}
		return $result;
	}
}
