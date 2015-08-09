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
					'msg' => 'Havenoreq' 
			) );
		}
	}
	public function actionGetall() 	// 得到所有好友
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$myid = Yii::$app->request->post ();
		
		$aa = (new \yii\db\Query ())->select ( 'friendid,phone, thumb, nickname' )->from ( 'friends f' )->join ( 'LEFT JOIN', 'user u', 'f.friendid=u.id' )->where ( [ 
				'myid' => $myid 
		] )->all ();
		
		$result = array ();
		$result ['items'] = $aa;
		return $result;
	}
	public function actionRequestadd() 	// 请求添加好友
	{
		$data = Yii::$app->request->post ();
		$model = new Reqfriend ();
		$model->myid = $data ['myid'];
		$model->friendid = $data ['friendid'];
		
		$row = Reqfriend::findOne ( [ 
				'myid' => $data ['myid'],
				'friendid' => $data ['friendid'] 
		] );
		if ($row != null) {
			$row->delete ();
		}
		
		$friend = new Friend ();
		$num = $friend->find ()->andWhere ( [ 
				'myid' => $data ['myid'],
				'friendid' => $data ['friendid'] 
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
		
		$friend = Friend::findOne ( [ 
				'myid' => $data ['myid'],
				'friendid' => $data ['friendid'] 
		] );
		
		if ($friend === null) {
			$model1 = new Friend ();
			$model1->myid = $data ['myid'];
			$model1->friendid = $data ['friendid'];
			
			if ($model1->save () === false) {
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Addfailure' 
				) );
				return;
			}
			
			$model2 = new Friend ();
			$model2->myid = $data ['friendid'];
			$model2->friendid = $data ['myid'];
			if ($model2->save () === false) {
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Addfailure' 
				) );
				return;
			}
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Addsuccessfully' 
			) );
			
			$row = Reqfriend::findOne ( [  // 删除req
					'myid' => $data ['friendid'],
					'friendid' => $data ['myid'] 
			] );
			if ($row === null) {
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Addfailure' 
				) );
				return;
			} else {
				if ($row->delete () === false) {
					echo json_encode ( array (
							'flag' => 0,
							'msg' => 'Addfailure' 
					) );
					return;
				}
			}
		} else {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Addfailure' 
			) );
		}
	}
	public function actionDelete() {
		$data = Yii::$app->request->post ();
		
		$row1 = Friend::findOne ( [ 
				'myid' => $data ['friendid'],
				'friendid' => $data ['myid'] 
		] );
		
		if ($row1 != null) {
			if ($row1->delete () === false) {
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Deletefailure' 
				) );
			}
			
			$row2 = Friend::findOne ( [ 
					'myid' => $data ['myid'],
					'friendid' => $data ['friendid'] 
			] );
			if ($row2->delete () === false) {
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Deletefailure' 
				) );
			}
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Deletesuccessfully' 
			) );
		} else {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Deletefailure' 
			) );
		}
	}
}
