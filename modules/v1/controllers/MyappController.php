<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Usertoapp;
use app\modules\v1\models\Appl;
use app\modules\v1\models\User;
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
// 			$appinfo = $appl->find ()->where ( [ 
// 					'id' => $data ['appid'] 
// 			] )->one ();
			$appinfo=Appl::findOne([
					'id' => $data ['appid']
			]);
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
	public function actionTag() {
		$data=Yii::$app->request->post();
		$appl=new Appl();
		$ans=(new \yii\db\Query())
		->select('*')
		->from('app')
		->innerJoin('tag','app.id=tag.appid')
		->where(['tag.tag'=>$data['tag']])
		->all();
		return $ans;
	}
	public function actionLike(){
		$data=Yii::$app->request->post();
		$connection = \Yii::$app->db;
		//$aa = (new \yii\db\Query ())->select ( 'appid,name,icon' )->from ( 'usertoapp u' )->join ( 'LEFT JOIN', 'app a', 'u.appid=a.id' )->where ( [
		//		'userid' => $data['userid']
		//] )->all ();
		$model=new Appl();
		//$lin = $model->find()->select('id')->where(['phone'=>$data['phone']])->one();
		//$command = $connection->createCommand('SELECT `appid`, `name`, `icon` FROM `usertoapp` `u` LEFT JOIN `app` `a` ON u.appid=a.id WHERE (`userid`=' . $data['userid'] . ') AND (`appid`!=' . $data['appid'] . ')');
		//$aa = $command->queryAll();
// 		$ans=(new \yii\db\Query())
// 		->select('id,name,icon')
// 		->from('app')
// 		->limit(4)->all();
		$aa = (new \yii\db\Query ())->select ( '*' )->from ( 'usertoapp ua1' )
		->join ( 'LEFT JOIN', 'usertoapp ua2', 'ua1.userid=ua2.userid' )
		->join('LEFT JOIN','app a','a.id=ua2.appid')
		->where ( [
			 'ua1.appid' => $data['appid']
				] )
		->orderBy('a.downloadcount desc')
		->limit(6)
	    ->all ();
		return $aa;
	}
	public function actionGet(){
		$data=Yii::$app->request->post();
		$user=new User();
		$phone=$user->find()->select('id')->where(['phone'=>$data['phone']])->one();
		$aa = (new \yii\db\Query ())->select ( 'a.*' )->from ( 'usertoapp u' )
		->join('LEFT JOIN','app a','a.id=u.appid')
		->where ( [
				'u.userid' => $phone['id']
		] )
		->all ();
		return $aa;
	}
}