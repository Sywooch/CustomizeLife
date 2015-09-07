<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Usertoapp;
use app\modules\v1\models\Appl;
use app\modules\v1\models\User;
use app\modules\v1\models\Tag;
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
		->select('app.*')
		->from('app')
		->innerJoin('appofkind','app.id=appofkind.appid')
		->where(['appofkind.kind'=>$data['tag']])
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
		->where ('a.version >\'\' and u.userid=:id',['id'=>$phone['id']])
		->all ();
		return $aa;
	}
	public function actionTag8(){
		$model=new Tag();
		$tag=$model->find()->select('second')->from('tag')->where('second > \'\' and commend=1')->all();
		$ans=array();
		for($i=0;$i<count($tag);$i++){
			$ans[$i]=$tag[$i]['second'];
			
// 			$aa = (new \yii\db\Query ())->select ( 'a.*' )->from ( 'app a' )
// 			->join ( 'INNER JOIN', 'appofkind ak', 'a.id=ak.appid and ak.kind=:id',['id'=>$tag[$i]['second']] )
// 			->orderBy('a.downloadcount desc')
// 			->limit(3)
// 			->all ();
// 			$ans[$tag[$i]['second']]=$aa;
		}
		return $ans;
	}
	public function actionTagToApps(){
		$model=new Tag();
		$data=Yii::$app->request->post();
		//$tag=$model->find()->select('second')->from('tag')->where('second > \'\' and commend=1')->all();
		//return var_dump($data['tag'][0]);
		$ans=array();
		for($i=0;$i<count($data['tag']);$i++){
			//$ans[$i]=$tag[$i]['second'];
			$ans[$data['tag'][$i]]=array();
			$aa = (new \yii\db\Query ())->select ( 'a.*' )->from ( 'app a' )
			->where(['like','kind',$data['tag'][$i]])
			->limit(10)
			->all ();
			$ans[$data['tag'][$i]]=$aa;
		}
		return $ans;
	}
	public function actionUpload(){
		$data=Yii::$app->request->post();
		$phone=User::findOne(['phone'=>$data['phone']]);
		foreach ($data['apps'] as $app){
			$a=Appl::findOne(['package'=>$app[1]]);
			if($a){
				$model=new Usertoapp();
				$model->userid=$phone->id;
				$model->appid=$a->id;
				$model->created_at=time();
				if(!$model->save()){
					echo json_encode ( array (
							'flag' => 0,
							'msg' => 'Upload your app failed!'
					) );
					return;
				}
			}else{
				$model1=new Appl();
				$model1->name=$app[0];
				$model1->package=$app[1];
				$model1->updated_at=time();
				if(!$model1->save()){
					echo json_encode ( array (
							'flag' => 0,
							'msg' => 'Upload your app failed!'
					) );
					return;
				}
				$a1=Appl::findOne(['package'=>$app[1]]);
				$model2=new Usertoapp();
				$model2->userid=$phone->id;
				$model2->appid=$a1->id;
				$model2->created_at=time();
				if(!$model2->save()){
					echo json_encode ( array (
							'flag' => 0,
							'msg' => 'Upload your app failed!'
					) );
					return;
				}
			}
		}
		echo json_encode ( array (
							'flag' => 1,
							'msg' => 'Upload your app success!'
					) );
	}
}