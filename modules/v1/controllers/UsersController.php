<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\User;
use app\modules\v1\models\UserForm;
use app\modules\v1\models\Vercode;
// use yii\web\Controller;
use yii\rest\Controller;
use app\modules\v1\models;
use app;
use yii\filters\AccessControl;
use function Qiniu\json_decode;



class UsersController extends Controller {
	public $enableCsrfValidation = false;
	/**
	 * accesscontrol
	 */
	
	/**
	 * @用户授权规则
	 */
	public function behaviors() {
		return [ 
				'access' => [ 
						'class' => AccessControl::className (),
						'rules' => [ 
								[ 
										'actions' => [ 
												'login',
												'signup',
												'forgetpwd',
												'resetpwd'
										],
										'allow' => true,
										'roles' => [ 
												'?' 
										] 
								],
								[ 
										'actions' => [ 
												'logout',
												'test',
												'getinfo',
												'modify' ,
												'send',
												'verify'
										],
										'allow' => true,
										'roles' => [ 
												'?' 
										] 
								] 
						] 
				] 
		];
	}
	public function actionSignup() {
		$model = new User ();
		$data = Yii::$app->request->post ();
		$model->pwd = md5 ( $data ['pwd'] );
		$model->phone = $data ['phone'];
		if ($model->find ()->where ( [ 
				'phone' => $data ['phone'] 
		] )->one ()) {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Signup failed!' 
			) );
			// return 0;
		} else {
			$model->created_at = time ();
			$model->save ();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Signup success!' 
			) );
			// return 1;
			// return json_encode("sighup success");
		}
	}
	public function actionLogin() {
		$model = new UserForm ();
		if ($model->load ( Yii::$app->request->post (), '' )) {
			if ($model->login ()) {
				echo json_encode ( array (
						'flag' => 1,
						'msg' => 'Login success!' 
				) );
			} else {
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Login failed!' 
				) );
			}
		}
	}
	

	
	public function actionLogout() {
		Yii::$app->user->logout ();
		echo json_encode ( array (
				'flag' => 1,
				'msg' => 'Logout success!' 
		) );
	}
	public function actionView() {
		// $response=Yii::$app->response;
		// $response->format=\yii\web\Response::FORMAT_JSON;
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = new User ();
		$data = Yii::$app->request->post ();
		$PersonInfo = $model->find ()->where ( [ 
				'phone' => $data ['phone'] 
		] )->one ();
		unset($PersonInfo['updated_at']);
		unset($PersonInfo['pwd']);
		unset($PersonInfo['created_at']);
		unset($PersonInfo['authKey']);
		unset($PersonInfo['accessKey']);
		return $PersonInfo;
	}
	public function actionGetinfo() {
		$data = Yii::$app->request->post ();
		// \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$userinfo = User::find ()->where ( [ 
				'phone' => $data ['phone'] 
		] )->one ();
		// $userinfo['gender'] = 'man';
		// $userinfo->save();
		$response = Yii::$app->response;
		$response->format = \yii\web\Response::FORMAT_JSON;
		if (false == $userinfo) {
			// $response=Yii::$app->response;
			$user = new User ();
			$user->nickname = "";
			return $user;
			// $response->statusCode=404;
			// throw new \yii\web\HttpException(404,"user recode not found");
		} else {
			//
			unset ( $userinfo->pwd );
			unset ( $userinfo->accessKey );
			unset ( $userinfo->authKey );
			unset ( $userinfo->created_at );
			unset ( $userinfo->updated_at );
			return $userinfo;
		}
		// return yii\web\NotFoundHttpException;
		// throw yii\web\NotAcceptableHttpException;
		// $user = User::find()->all();
		
		// $users=(new \yii\db\Query())->select()->from('user')->join() ->orderBy('id') ->all();
		
		// return $userinfo;
	}
	public function actionModify() {
		$data = Yii::$app->request->post ();
		$count = User::updateAll ( array (
				'nickname' => $data ['nickname'],
				'thumb' => $data ['thumb'],
				'gender' => $data ['gender'],
				'area' => $data ['area'],
				'job' => $data ['job'],
				'hobby' => $data ['hobby'],
				'signature' => $data ['signature'],
				'updated_at' => time()
		), 'phone=:ph', array (
				':ph' => $data ['phone'] 
		) );
		if ($count === 0) {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Modify failed!' 
					
			) );
		} else {
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Modify success!' 
			) );
		}
	}
	/*
	 * public function actionForgetpwd(){ $model=new User(); $data=Yii::$app->request->post(); $userinfo=$model->find()->where(['email'=>$data['email']])->one(); if(!$userinfo) { return json_encode(array( "flag" => 0, "msg" => "The email has not been registered!" )); exit(); }else{ $getpasstime=time(); $id=$userinfo['id']; $token=md5($id . $userinfo['email'] . $userinfo['pwd']); $url="http://localhost/v1/users/resetpwd?email=" . $userinfo['email'] . "&token=" . $token; $time=date('Y-m-d H:i'); $mail=Yii::$app->mailer->compose() ->setFrom(["zhou544028616@163.com" => \Yii::$app->name . ' robot']) ->setTo($userinfo['email']) ->setSubject('密码修改通知') ->setTextBody("亲爱的" . $userinfo['email'] . ":您在" . $time . "提交了找回密码请求。 请点击下面的链接重置密码： $url"); if((!$mail->send())){ return json_encode(array( "flag"=>0, "msg"=>"Failed to send mail!" )); }else{ return json_encode(array( "flag"=>1, "msg"=>"Send success!" )); } } } public function actionResetpwd($email,$token){ $model=new User(); $data=Yii::$app->request->post(); $userinfo=$model->find()->where(['email'=>$email])->one(); if($userinfo){ $mt=md5($userinfo['id'] . $userinfo['email'] . $userinfo['pwd']); if($mt==$token){ if(isset($data['pwd'])){ $userinfo['pwd']=md5($data['pwd']); $userinfo->save(); return json_encode(array( "flag"=>1, "msg"=>"修改成功，请重新登录" )); exit(); }else{ return json_encode(array( "flag"=>0, "msg"=>"false change pwd！" )); exit(); } }else{ return json_encode(array( "flag"=>0, "msg"=>"false token" )); exit(); } }else{ return json_encode(array( "flag"=>0, "msg"=>"false url" )); exit(); } }
	 */
	

	public function actionSend() {
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
		$output="";
		for ($i=0; $i<4; $i++)
		{
		  $output .= mt_rand(0,9);
		}
		$rest=new REST();
		$apikey='7d4294b4e224bd57377c85873b3e8430';
		$mobile=$ph['phone'];
		$tpl_id = 2; //对应默认模板 【#company#】您的验证码是#code#
		$tpl_value = "#company#=云片网&#code#=".$output;
		//$rest->send_sms($apikey,$text, $mobile);
		$data=$rest->tpl_send_sms($apikey,$tpl_id, $tpl_value, $mobile);
		$obj=json_decode($data);
		if($obj->msg==='OK'){
			$model=new Vercode();
			$model->phone=$ph['phone'];
			$model->num=$output;
			$model->created_at=time();
			$model->save();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Send success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Send failed!'
			) );
		}
	}
	
	public function actionVerify() {
		$data = Yii::$app->request->post ();
		
		$info=Vercode::find()->select('*')->where(['phone' => $data ['phone'] ])->one();
		
		if ($info===false){
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Verify failed!'
			) );
		}else{
			if($info['num']==$data['num']&&time()-$info['created_at']<=300){
				Vercode::deleteAll(['phone' => $data ['phone'] ]);
				$model = new User ();
				$model->phone=$data['phone'];
					$model->created_at = time ();
					$model->save ();
				echo json_encode ( array (
						'flag' => 1,
						'msg' => 'Verify success!'
				) );
			}else if(time()-$info['created_at']>300){
				Vercode::deleteAll(['phone' => $data ['phone'] ]);
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Verify failed!'
				) );
		}else {
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Verify failed!'
				) );
			}
		}
		}
}
class REST {
//模板接口样例（不推荐。需要测试请将注释去掉。)
/* 以下代码块已被注释
  $apikey = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"; //请用自己的apikey代替
  $mobile = "xxxxxxxxxxx"; //请用自己的手机号代替
  $tpl_id = 1; //对应默认模板 【#company#】您的验证码是#code#
  $tpl_value = "#company#=云片网&#code#=1234";
  echo tpl_send_sms($apikey,$tpl_id, $tpl_value, $mobile);
*/


/**
* 通用接口发短信
* apikey 为云片分配的apikey
* text 为短信内容
* mobile 为接受短信的手机号
*/
function send_sms($apikey, $text, $mobile){
	$url="http://yunpian.com/v1/sms/send.json";
	$encoded_text = urlencode("$text");
	$post_string="apikey=$apikey&text=$encoded_text&mobile=$mobile";
	return $this->sock_post($url, $post_string);
}

/**
* 模板接口发短信
* apikey 为云片分配的apikey
* tpl_id 为模板id
* tpl_value 为模板值
* mobile 为接受短信的手机号
*/
function tpl_send_sms($apikey, $tpl_id, $tpl_value, $mobile){
	$url="http://yunpian.com/v1/sms/tpl_send.json";
	$encoded_tpl_value = urlencode("$tpl_value");  //tpl_value需整体转义
	$post_string="apikey=$apikey&tpl_id=$tpl_id&tpl_value=$encoded_tpl_value&mobile=$mobile";
	return $this->sock_post($url, $post_string);
}

/**
* url 为服务的url地址
* query 为请求串
*/
function sock_post($url,$query){
	$data = "";
	$info=parse_url($url);
	$fp=fsockopen($info["host"],80,$errno,$errstr,30);
	if(!$fp){
		return $data;
	}
	$head="POST ".$info['path']." HTTP/1.0\r\n";
	$head.="Host: ".$info['host']."\r\n";
	$head.="Referer: http://".$info['host'].$info['path']."\r\n";
	$head.="Content-type: application/x-www-form-urlencoded\r\n";
	$head.="Content-Length: ".strlen(trim($query))."\r\n";
	$head.="\r\n";
	$head.=trim($query);
	$write=fputs($fp,$head);
	$header = "";
	while ($str = trim(fgets($fp,4096))) {
		$header.=$str;
	}
	while (!feof($fp)) {
		$data .= fgets($fp,4096);
	}
	return $data;
}
}




