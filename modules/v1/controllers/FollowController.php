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
use app\modules\v1\models\Friend;

class FollowController extends \yii\rest\Controller
{
	public function actionSet(){
		$data=Yii::$app->request->post();
		$model=new Friend();
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
				'friendid'=>$Fphone['id']
		])->one()){
			echo json_encode(array(
					'flag' => 0,
					'msg' => 'Failed!You have already followed or you are friend.'
			));
		}else{
			$model->myid=$myphone['id'];
			$model->friendid=$Fphone['id'];
			$model->isfriend=0;
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
				'friendid'=>$Fphone['id'],
				'isfriend'=>0
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
		$model=new Friend();
		$user=new User();
		$myphone=$user->find()->select('id')->where(['phone'=>$data['myphone']])->one();
		$aa = (new \yii\db\Query ())->select ( 'phone,thumb,nickname,signature' )->from ( 'friends f' )
		->join('LEFT JOIN', 'user u','f.friendid=u.id')
		->where ( [
				'f.myid' => $myphone['id'],
				'f.isfriend'=>0
		] )
		->all ();
		return $aa;
	}
	public function actionZan(){
		$data=Yii::$app->request->post();
		$user=new User();
		$phone=$user->find()->select('id')->where(['phone'=>$data['phone']])->one();
		$info=User::findOne([
				'phone'=>$data['phone']
		]);
		if($info){
			$info->favour+=1;
			$info->save();
			echo json_encode(array(
					'flag' => 1,
					'msg' => 'favour success.'
			));
		}else{
			echo json_encode(array(
					'flag' => 0,
					'msg' => 'favour fail.'
			));
		}
	}
}
