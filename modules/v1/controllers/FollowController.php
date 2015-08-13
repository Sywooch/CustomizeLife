<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\AccessControl;
use app\modules\v1\models\Friend;
//use app\modules\v1\models\Reqfriend;
use app\modules\v1\models\User;
use yii\db\ActiveRecord;
//use app\modules\v1\models\app\modules\v1\models;
use app\models\app;
use app\modules\v1\models\app\modules\v1\models;

class FollowController extends \yii\rest\Controller
{
	public function actionSet(){
		$data=Yii::$app->request->post();
		$model=new Friend();
		$user=new User();
		$myphone=$user->find()->select('id')->where(['phone'=>$data['myphone']])->one();
		$Fphone=$user->find()->select('id')->where(['phone'=>$data['fphone']])->one();
		if($model->find()->where([
				'myid'=>$myphone['id'],
				'friendid'=>$Fphone['id']
		])->one()){
			echo json_encode(array(
					'flag' => 0,
					'msg' => 'Failed!You are friends or followed already.'
			));
		}else{
			$model->myid=$myphone['id'];
			$model->friendid=$Fphone['id'];
			$model->save();
			echo json_encode(array(
					'flag'=>1,
					'msg'=>'Follow success!'
			));
		}
	}
	public function actionCancel(){
		$data=Yii::$app->request->post();
		$model=new Friend();
		$user=new User();
		$myphone=$user->find()->select('id')->where(['phone'=>$data['myphone']])->one();
		$Fphone=$user->find()->select('id')->where(['phone'=>$data['fphone']])->one();
		$ans=Friend::findOne([
				'myid'=>$myphone['id'],
				'friendid'=>$Fphone['id']
		]);
		if($ans){
			$ans->delete();
			echo json_encode(array(
					'flag' => 1,
					'msg' => 'Cancel follow.'
			));
		}else{
			echo json_encode(array(
					'flag' => 0,
					'msg' => 'Do not exist.'
			));
		}
	}
}
