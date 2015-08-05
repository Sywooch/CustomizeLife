<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\v1\models\Friend;
use app\modules\v1\models\Reqfriend;
use app\modules\v1\models\User;
use yii\db\ActiveRecord;



class FriendController extends Controller {
	public $enableCsrfValidation = false;
	public function actionListenadd() // 监听添加好友
{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = new Reqfriend();
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
			return 0;
		}
	}
	public function actionGetall() // 得到所有好友
{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$myid = Yii::$app->request->post ();
		
		$aa = (new \yii\db\Query ())->select ( 'friendid, thumb, nickname' )->from ( 'friends f' )->join ( 'LEFT JOIN', 'user u', 'f.friendid=u.id' )->where ( [ 
				'myid' => $myid 
		] )->all ();
		$result=array();
		$result['items']=$aa;
		return $result;
	}
	public function actionRequestadd() // 请求添加好友
{
		$data = Yii::$app->request->post ();
		$model = new Reqfriend();
		$model->myid = $data ['myid'];
		$model->friendid = $data ['friendid'];
		
		//echo $data ['myid'];
		$num = $model->find ()->andWhere ( [ 
				'myid' => $data ['myid'],
				'friendid' => $data ['friendid'] 
		] )->count ();
		//echo $num;
		if ($num == 0) {
			$model->save();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Request Success!'
			) );
		} else {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Already Added!'
			) );
		}
	}
	public function actionRequestresult() // 返回请求添加的结果
    {
	}
	public function actionAcceptadd() // 接受添加
	{
		$data = Yii::$app->request->post ();
		
		$row = Reqfriend::findOne ( [ 
				'myid' => $data ['friendid'],
				'friendid' => $data ['myid'] 
		] );
		$row->delete();
		if($data['agree']==1){
			$model1 = new Friend ();
			$model1->myid = $data ['myid'];
			$model1->friendid = $data ['friendid'];
			$model1->save ();
			
			$model2 = new Friend ();
			$model2->myid = $data ['friendid'];
			$model2->friendid = $data ['myid'];
			$model2->save ();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Add friend success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'refuse to add friend!'
			) );
		}
		
	}
	
	public function actionDelete()
	{
		$data = Yii::$app->request->post ();
		
		$row1 = Friend::findOne ( [
				'myid' => $data ['friendid'],
				'friendid' => $data ['myid']
		] );
		$row1->delete();
		
		$row2 = Friend::findOne ( [
				'myid' => $data ['myid'],
				'friendid' => $data ['friendid']
		] );
		$row2->delete();
		echo json_encode ( array (
				'flag' => 1,
				'msg' => 'Delete success!'
		) );
	}
}
