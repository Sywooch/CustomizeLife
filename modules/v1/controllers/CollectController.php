<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\v1\models\CollectInteract;
use app\modules\v1\models\CollectPerson;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

class CollectController extends Controller {
	public function actionInteractcl() {
		$data = Yii::$app->request->post ();
		
		$model = new CollectInteract ();
		$model->userid = $data ['userid'];
		$model->msg = $data ['msg'];
		$model->created_at = time ();
		
		$model->save ();
		echo "collect success";
	}
	public function actionPersoncl() {
		$data = Yii::$app->request->post ();
		
		$model = new CollectPerson ();
		$model->userid = $data ['userid'];
		$model->app = $data ['app'];
		$model->created_at = time ();
		
		$model->save ();
		echo "collect success";
	}
	public function actionGetpersoncl() {
		$data = Yii::$app->request->post ();
		
		$query = CollectPerson::find ()->select ( '*' )->join ( 'INNER JOIN', 'app', 'app.id=collect_person.app' )->where ( [ 
				'collect_person.app' => $data ['userid'] 
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
	public function actionGetinteractcl() {
		
	}
}