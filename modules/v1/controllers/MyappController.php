<?php
namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Usertoapp;
use app\modules\v1\models\App;
use yii\web\Controller;
use app\modules\v1\models;
use app;
use yii\filters\AccessControl;
class MyappController extends Controller
{
	public function actionDownload(){
		$usertoapp=new Usertoapp();
		$user=new User();
		$app=new App();
		$model=Yii::$app->request->post();
		if($usertoapp->find()->where([
				'userid' => $model['userid'],
				'appid' => $model['appid']
		])->one()){
			echo json_encode(array(
					'flag' => 1,
					'msg' => 'Already download!'
			));
			exit();
		}else{
			$usertoapp->appid=$model['appid'];
			$usertoapp->userid=$model['userid'];
			$usertoapp->created_at=time();
			$usertoapp->save();
			$appinfo=$app->find()->where(['id' => $model['appid']])->one();
			$appinfo['downloadcount']+=1;
			$appinfo->save();
			echo json_encode($appinfo);
		}
	}
}