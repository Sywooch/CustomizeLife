<?php
namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Usertoapp;
use app\modules\v1\models\Appl;
use yii\rest\Controller;
use app;
use app\modules\v1\models;
use yii\filters\AccessControl;
class MyappController extends Controller
{
	public function actionDownload(){
		//\Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
		$usertoapp=new Usertoapp();
		//$user=new User();
		$appl=new Appl();
		$data=Yii::$app->request->post();
		if($usertoapp->find()->where(['userid' => $data['userid']])->one()){
			echo json_encode(array(
					'flag' => 1,
					'msg' => 'Already download!'
			));
			exit();
		}else{
			$connection=\Yii::$app->db;
			$command = $connection->createCommand('UPDATE app SET downloadcount=downloadcount+1 WHERE id=' . $data['appid']);
			$command->execute();
			$appinfo=$appl->find()->where(['id' => $data['appid']])->one();
			$usertoapp->appid=$data['appid'];
			$usertoapp->userid=$data['userid'];
			$usertoapp->created_at=time();
			$usertoapp->save();
			//$appinfo['downloadcount']=1;
			//$appinfo->save();
			return $appinfo;
		}
	}
}