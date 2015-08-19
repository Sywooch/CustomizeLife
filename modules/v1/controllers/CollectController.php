<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\v1\models\CollectInteract;
use app\modules\v1\models\CollectPerson;
use app\modules\v1\models\User;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

class CollectController extends Controller {
	public function actionInteractcl() {
		$data = Yii::$app->request->post ();
		$phone=User::findOne([
				'phone'=>$data['phone']
		]);
		$model = new CollectInteract ();
		$model->userid = $phone['id'];
		$model->msg = $data ['msg'];
		$model->created_at = time ();
		
		if($model->save ()){
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Collect success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Collect fail!'
			) );
		}
	}
	public function actionSetApp() {
		$data = Yii::$app->request->post ();
		$phone=User::findOne([
				'phone'=>$data['phone']
		]);
		$info=CollectPerson::findOne([
				'userid'=>$phone['id'],
				'app'=>$data['app']
		]);
		if($info){
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Already collect!'
			) );
			return;
		}
		$model = new CollectPerson ();
		$model->userid = $phone['id'];
		$model->app = $data ['app'];
		$model->created_at = time ();
		
		if($model->save ()){
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Collect success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Collect fail!'
			) );
		}
	}
	public function actionCancelApp() {
		$data = Yii::$app->request->post ();
		$phone=User::findOne([
				'phone'=>$data['phone']
		]);
		$info=CollectPerson::findOne([
				'userid'=>$phone['id'],
				'app'=>$data['app']
		]);
		if($info){
			$info->delete();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Cancel collect success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Cancel collect fail!'
			) );
		}
	}
	public function actionGetApp() {
		$data = Yii::$app->request->post ();
		$phone=User::findOne([
				'phone'=>$data['phone']
		]);
		$query = (new \yii\db\Query ())->select ( 'app.id,name,icon,size,downloadcount,introduction' )->from('collect_person c')
		->join ( 'LEFT JOIN', 'app', 'app.id=c.app' )->where ( [ 
				'c.userid' => $phone['id'] 
		] );
		
		$pages = new Pagination ( [ 
				'totalCount' => $query->count (),
				'pageSize' => '10' 
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
		$data = Yii::$app->request->post ();
		$phone=User::findOne([
				'phone'=>$data['phone']
		]);
		$query = (new \yii\db\Query ())->select ( '*' )->from('collect_interact c')
		->join ( 'LEFT JOIN', 'msg m', 'm.id=c.msg' )
		->join('LEFT JOIN','msgtoapp ma','m.id=ma.msgid')
		->join('LEFT JOIN','app a','a.id=ma.appid')
		->where ( [
				'c.userid' => $phone['id']
		] );
		
		$pages = new Pagination ( [
				'totalCount' => $query->count (),
				'pageSize' => '10'
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
}