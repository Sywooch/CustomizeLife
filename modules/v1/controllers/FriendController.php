<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\v1\models\Friend;
use app\modules\v1\models\Reqfriend;
use app\modules\v1\models\User;
use yii\db\ActiveRecord;
use app\modules\v1\models\app\modules\v1\models;
use app\models\app;

class FriendController extends Controller {
	public $enableCsrfValidation = false;
	public function actionListenadd() 	// 监听添加好友
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = new Reqfriend ();
		$data = Yii::$app->request->post ();
		
		$num = $model->find ()->andWhere ( [ 
				'friendid' => $data ['myid'] 
		] )->count ();
		
		if ($num > 0) {
			$aa = (new \yii\db\Query ())->select ( 'myid, thumb, nickname' )->from ( 'reqfriend f' )->join ( 'LEFT JOIN', 'user u', 'f.myid=u.id' )->where ( [ 
					'friendid' => $data ['myid'] 
			] )->all ();
			
			return $aa;
		} else {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Have no req' 
			) );
		}
	}
	public function actionGetall() 	// 得到所有好友
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$myid = Yii::$app->request->post ();
		$model=new User();
		$lin = $model->find()->select('id')->where(['phone'=>$myid['phone']])->one();
		$aa = (new \yii\db\Query ())->select ( 'friendid,phone, thumb, nickname' )->from ( 'friends f' )->join ( 'LEFT JOIN', 'user u', 'f.friendid=u.id' )->where ( [ 
				'myid' => $lin['id'],
				'isfriend'=>1
		] )->all ();
		
		$result = array ();
		$result ['items'] = $aa;
		return $result;
	}
	public function actionRequestadd() 	// 请求添加好友
	{
		$data = Yii::$app->request->post ();
		$model1=new User();
		$myid = $model1->find()->select('id')->where(['phone'=>$data['myphone']])->one();
		$fid = $model1->find()->select('id')->where(['phone'=>$data['fphone']])->one();
		$model = new Reqfriend ();
		$model->myid = $myid ['id'];
		$model->friendid = $fid ['id'];
		
		$row = Reqfriend::findOne ( [ 
				'myid' => $myid ['id'],
				'friendid' => $fid ['id'] 
		] );
		if ($row != null) {
			$row->delete ();
		}
		
		$friend = new Friend ();
		$num = $friend->find ()->andWhere ( [ 
				'myid' => $myid ['id'],
				'friendid' => $fid ['id'] 
		] )->count ();
		
		if ($num == 0) {
			$model->save ();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'ReqSuccessfully' 
			) );
		} else {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Alreadyexists' 
			) );
		}
	}
	public function actionRequestresult() 	// 返回请求添加的结果
	{
		$app=new app();
		$data=$app->findBySql("select * from app order by id desc limit 1")->all();
		echo $data[0]['id'];
	}
	public function actionAcceptadd() 	// 接受添加
	{
		$data = Yii::$app->request->post ();
		$model=new User();
		$myid = $model->find()->select('id')->where(['phone'=>$data['myphone']])->one();
		$fid = $model->find()->select('id')->where(['phone'=>$data['fphone']])->one();
		$friend = Friend::findOne ( [ 
				'myid' => $myid ['id'],
				'friendid' => $fid ['id'] 
		] );
		
		if ($friend === null) {
			if($data['agree']==1){
				$model1 = new Friend ();
				$model1->myid = $myid ['id'];
				$model1->friendid = $fid ['id'];
				$model1->isfriend=1;
				$model1->save ();
			
				$model2 = new Friend ();
				$model2->myid = $fid ['id'];
				$model2->friendid = $myid ['id'];
				$model2->isfriend=1;
				$model2->save ();
				echo json_encode ( array (
						'flag' => 1,
						'msg' => 'Add friend successfully' 
				) );
			}else{
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Refuse to add friend successfully'
				) );
			}
			$row = Reqfriend::findOne ( [  // 删除req
					'myid' => $fid ['id'],
					'friendid' => $myid ['id'] 
			] );
			if ($row != null) {
				$row->delete ();
			}
		} else {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'You are already friend.' 
			) );
		}
	}
	public function actionDelete() {
		$data = Yii::$app->request->post ();
		$model=new User();
		$myid = $model->find()->select('id')->where(['phone'=>$data['myphone']])->one();
		$fid = $model->find()->select('id')->where(['phone'=>$data['fphone']])->one();
		$row1 = Friend::findOne ( [ 
				'myid' => $fid ['id'],
				'friendid' => $myid ['id'],
				'isfriend'=>1
		] );
		
		if ($row1 != null) {
			$row1->delete ();
			$row2 = Friend::findOne ( [ 
					'myid' => $myid ['id'],
					'friendid' => $fid ['id'],
					'isfriend'=>1
			] );
			$row2->delete ();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Delete friend successfully' 
			) );
		} else {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'You are not friend.' 
			) );
		}
	}
}
