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
use app\modules\v1\models\Channel;
use app\modules\v1\controllers\REST;
require dirname ( __FILE__ ) . '/../../../vendor/pushserver/sdk.php';
use PushSDK;

class FriendController extends Controller {
	public $enableCsrfValidation = false;
	public function actionListenadd() 	// 监听添加好友
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model1 = new Reqfriend ();
		$model=new User();
		$data = Yii::$app->request->post ();
		$myid = $model->find()->select('id')->where(['phone'=>$data['phone']])->one();
		//$fid = $model->find()->select('id')->where(['phone'=>$data['fphone']])->one();
		$num = $model1->find ()->andWhere ( [ 
				'friendid' => $myid['id'] 
		] )->count ();
		
		if ($num > 0) {
			$aa = (new \yii\db\Query ())->select ( 'phone,thumb,nickname' )->from ( 'reqfriend f' )->join ( 'LEFT JOIN', 'user u', 'f.myid=u.id' )->where ( [ 
					'f.friendid' => $myid['id'] 
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
		if(!$myid){
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'my phone do not exist!'
			) );
			return;
		}
		if(!$fid){
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'friend phone do not exist!'
			) );
			return;
		}
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
			$cha=new Channel();
			$fcha=$cha->find()->andWhere (['userid' => $fid ['id']])->one();
			
			if ($model->save ()){
				$aa = (new \yii\db\Query ())->select ( 'phone, thumb, nickname' )->from ( 'user' )->where ( ['id' => $myid['id']] ) ->one();
				if ($fcha && $fcha->channel){
					$this->push($fcha->channel, "Reqadd",$aa );
				}
				echo json_encode ( array (
						'flag' => 1,
						'msg' => 'ReqSuccessfully'
				) );
			}
		} else {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Alreadyexists' 
			) );
		}
	}
	
	public function push($channel,$title,$message){
		$sdk = new PushSDK ();
		//$channelId = '4483825412066692748';
		$optmessage = array (
				// 消息的标题.
				'title' => $title,
				// 消息内容
				'description' => $message
		);
	
		// 设置消息类型为 通知类型.
		$opts = array (
				'msg_type' => 0
		);
	
		// 向目标设备发送一条消息
		$rs = $sdk->pushMsgToSingleDevice ( $channel, $optmessage, $opts );
		//pushMsgToSingleDevice ( $channelId, $message, $opts );
	
		// 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
		//     	if ($rs === false) {
		//     		echo "<script language='javascript'>;alert('推送失败');</script>";
		//     		return $this->render ( 'create', [
		//     				'model' => $model
		//     				] );
		//     	} else {
		//     		echo "<script language='javascript'>;alert('推送成功');</script>";
		//     		$model->title='';
		//     		$model->content='';
		//     		return $this->render ( 'create', [
		//     				'model' => $model
		//     				] );
		//     	}
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
	public function actionExist(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$data = Yii::$app->request->post ();
		
		$ans=array();
		for($i=0;$i<count($data['phone']);$i++){
			$model=new User();
			$id = $model->find()->select('phone')->where(['phone'=>$data['phone'][$i]])->one();
			if($id){
				$ans[$i]=1;
			}else 
				$ans[$i]=0;
		}
		return $ans;
	}
	public function actionInvite() {
		$ph = Yii::$app->request->post ();
		$model = new User ();
		if ($model->find ()->where ( [
				'phone' => $ph ['phone']
		] )->one ()) {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Phone has been registered!'
			) );
			return;
		}
		$output = "app url";
		$rest = new REST ();
		$apikey = '7d4294b4e224bd57377c85873b3e8430';
		$mobile = $ph ['phone'];
		$tpl_id = 2; // 对应默认模板 【#company#】您的验证码是#code#
		$tpl_value = "#company#=云片网&#code#=" . $output;
		// $rest->send_sms($apikey,$text, $mobile);
		$data = $rest->tpl_send_sms ( $apikey, $tpl_id, $tpl_value, $mobile );
		$obj = json_decode ( $data );
		if ($obj->msg === 'OK') {
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Invite success!'
			) );
		} else {
			var_dump ( $data );
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Send message failed!'
			) );
		}
	}
	public function actionLike(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$data=Yii::$app->request->post();
		$model=new User();
		$myid = $model->find()->select('id')->where(['phone'=>$data['phone']])->one();
		$aa = (new \yii\db\Query ())->select ( 'a.*' )->from ( 'friends f' )
		->join ( 'INNER JOIN', 'usertoapp ua', 'f.friendid=ua.userid and f.friendid <> f.myid and f.myid=:id',['id'=>$myid['id']] )
		->join('INNER JOIN','app a','ua.appid=a.id')
		->all ();
		return $aa;
	}
}
