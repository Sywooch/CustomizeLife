<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\User;
use app\modules\v1\models\UserForm;
// use yii\web\Controller;
use yii\rest\Controller;
use app\modules\v1\models;
use app;
use yii\filters\AccessControl;

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
												'test',
												'view',
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
												'modify' 
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
	public function actionGetinfo() {
		// $response=Yii::$app->response;
		// $response->format=\yii\web\Response::FORMAT_JSON;
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = new User ();
		$data = Yii::$app->request->post ();
		$PersonInfo = $model->find ()->where ( [ 
				'phone' => $data ['phone'] 
		] )->one ();
		return $PersonInfo;
	}
	public function actionView() {
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
				'signature' => $data ['signature']
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
}
