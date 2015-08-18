<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\AccessControl;
use app\modules\v1\models\Follow;
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
		$model=new Follow();
		$user=new User();
		$myphone=$user->find()->select('id')->where(['phone'=>$data['myphone']])->one();
		$Fphone=$user->find()->select('id')->where([
				'phone'=>$data['fphone'],
				'famous'=>1
		])->one();
		if(!$Fphone){
			echo json_encode(array(
					'flag' => 0,
					'msg' => 'Failed!He/She is not famous.'
			));
			return;
		}
		if($model->find()->where([
				'myid'=>$myphone['id'],
				'followid'=>$Fphone['id']
		])->one()){
			echo json_encode(array(
					'flag' => 0,
					'msg' => 'Failed!You have already followed.'
			));
		}else{
			$model->myid=$myphone['id'];
			$model->followid=$Fphone['id'];
			$model->save();
			echo json_encode(array(
					'flag'=>1,
					'msg'=>'Follow success!'
			));
		}
	}
	public function actionCancel(){
		$data=Yii::$app->request->post();
		$model=new Follow();
		$user=new User();
		$myphone=$user->find()->select('id')->where(['phone'=>$data['myphone']])->one();
		$Fphone=$user->find()->select('id')->where(['phone'=>$data['fphone']])->one();
		$ans=Follow::findOne([
				'myid'=>$myphone['id'],
				'followid'=>$Fphone['id']
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
	public function actionGet(){
		$data=Yii::$app->request->post();
		$model=new Follow();
		$user=new User();
		$myphone=$user->find()->select('id')->where(['phone'=>$data['myphone']])->one();
		$aa = (new \yii\db\Query ())->select ( 'phone,thumb,nickname' )->from ( 'follow f' )
		->join('LEFT JOIN', 'user u','f.followid=u.id')
		->where ( [
				'f.myid' => $myphone['id']
		] )
		->all ();
		return $aa;
	}
}
