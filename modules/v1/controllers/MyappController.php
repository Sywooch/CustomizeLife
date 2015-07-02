<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Usertoapp;
use app\modules\v1\models\Appl;
use yii\rest\Controller;
use app;
use app\modules\v1\models;
use yii\filters\AccessControl;
class MyappController extends Controller {
	public function actionDownload() {
		// \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
		$usertoapp = new Usertoapp ();
		// $user=new User();
		$appl = new Appl ();
		$data = Yii::$app->request->post ();
		if ($usertoapp->find ()->where ( [ 
				'userid' => $data ['userid'],
				'appid' => $data ['appid'] 
		] )->one ()) {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Already download!' 
			) );
			exit ();
		} else {
			/*$connection = \Yii::$app->db;
			$command = $connection->createCommand ( 'UPDATE app SET downloadcount=downloadcount+1 WHERE id=' . $data ['appid'] );
			$command->execute ();*/
			$appinfo = $appl->find ()->where ( [ 
					'id' => $data ['appid'] 
			] )->one ();
			$usertoapp->appid = $data ['appid'];
			$usertoapp->userid = $data ['userid'];
			$usertoapp->created_at = time ();
			$usertoapp->save ();
			$appinfo['downloadcount']=$appinfo['downloadcount']+1;
			$appinfo->save();
			return $appinfo;
		}
	}
	public function actionDelete() {
		$usertoapp = new Usertoapp ();
		$data = Yii::$app->request->post ();
		$appl = new Appl ();
		$count = $usertoapp->find ()->where ( [ 
				'userid' => $data ['userid'],
				'appid' => $data ['appid'] 
		] )->one ();
		if ($count) {
			$count->delete ();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Success to delete your app!' 
			) );
		} else {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'You have not downloaded this app!' 
			) );
			exit ();
		}
	}
	public function actionKind() {
		$data=Yii::$app->request->post();
		$appl=new Appl();
		$ans=(new \yii\db\Query())
		->select('*')
		->from('app')
		->innerJoin('usertoapp','app.id=usertoapp.appid')
		->innerJoin('appofkind','app.id=appofkind.appid')
		->where(["usertoapp.userid"=>$data['userid'],'appofkind.kind'=>$data['kind']])
		->all();
		return $ans;
	}
}