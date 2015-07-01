<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\User;
use app\modules\v1\models\UserForm;
use yii\web\Controller;
use app\modules\v1\models;
use app;
use yii\filters\AccessControl;
class UsersController extends Controller
{
	public $enableCsrfValidation = false;
	/**
	 * accesscontrol
	 */
	
	/**
	 * @用户授权规则
	 */
	public function behaviors()
	{
		return [
		'access' => [
		'class' => AccessControl::className(),
		'rules' => [
		[
		'actions' => ['login','signup','test','forgetpwd'],
		'allow' => true,
		'roles' => ['?'],
		],
		[
		'actions' => ['Logout'],
		'allow' => true,
		'roles' => ['@'],
		],
		],
		],
		];
	}
	
    public function actionSignup()
    {
        $model=new User();
        $data=Yii::$app->request->post();
        $model->pwd=md5($data['pwd']);
        $model->email=$data['email'];  
        if($model->find()->where(['email'=>$data['email']])->one())
        {
        	return 0;
        }else {
        	$model->created_at=time();
        	$model->save();
        	return 1;
        	//echo json_encode("sighup success");
        }
    }
    public function actionLogin()
    {
    	$model=new UserForm();
    	if($model->load(Yii::$app->request->post(),'')){
    		if($model->login()){
    			echo "login success";
    		}else{
    			return "login failure";
    		}
    	}
    }
    	
    public function actionLogout()
    {
    	Yii::$app->user->logout();
    }
    public function actionForgetpwd(){
    	$model=new User();
    	$data=Yii::$app->request->post();
    	$userinfo=$model->find()->where(['email'=>$data['email']])->one();
    	if(!$userinfo)
    	{
    		echo json_encode(array(
    				"flag" => 0,
    				"msg" => "The email has not been registered!"
    		));
    		exit();
    	}else{
    		$getpasstime=time();
    		$id=$userinfo['id'];
    		$token=md5($id . $userinfo['email'] . $userinfo['pwd']);
			$url="http://localhost/v1/users/resetpwd?email=" . $userinfo['email'] . "&token=" . $token;
			$time=date('Y-m-d H:i');
			$mail=Yii::$app->mailer->compose()
				->setFrom('shepherdbird@163.com')
				->setTo($userinfo['email'])
				->setSubject('密码修改通知')
				->setTextBody("亲爱的" . $userinfo['email'] . ":您在" . $time . "提交了找回密码请求。
				请点击下面的链接重置密码： $url")
				->setHtmlBody('<b>HTML content</b>');
			if((!$mail->send())){
				echo json_encode(array(
						"flag"=>0,
						"msg"=>"Failed to send mail!"
				));
			}else{
				echo json_encode(array(
						"flag"=>1,
						"msg"=>"Send success!"
				));
			}
				
    	}
    }
    public function actionResetpwd(){
    	$model=new User();
    	$data=Yii::$app->request->post();
    	$userinfo=$model->find()->where(['email'=>$data['email']])->one();
    	if($userinfo){
    		$mt=md5($userinfo['id'] . $userinfo['email'] . $userinfo['pwd']);
    		if($mt==$token){
    			if(isset($data['pwd'])){
    				$userinfo['pwd']=md5($data['pwd']);
    				$userinfo->save();
    				echo json_encode(array(
    						"flag"=>1,
    						"msg"=>"修改成功，请重新登录"
    				));
    				exit();
    			}else{
    				echo json_encode(array(
    						"flag"=>0,
    						"msg"=>"修改失败！"
    				));
    				exit();
    			}
    		}else{
    			echo json_encode(array(
    					"flag"=>0,
    					"msg"=>"无效的链接！"
    			));
    			exit();
    		}
    	}else{
    		echo json_encode(array(
    				"flag"=>0,
    				"msg"=>"错误的链接！"
    		));
    		exit();
    	}
    }
    public function actionTest(){
    	$mail= Yii::$app->mailer->compose();
    	$mail->setTo('1205582578@qq.com');
    	$mail->setSubject("邮件测试");
    	//$mail->setTextBody('zheshisha ');   //发布纯文字文本
    	$mail->setHtmlBody("<br>问我我我我我");    //发布可以带html标签的文本
    	if($mail->send())
    		echo "success";
    	else
    		echo "failse";
    }
    
}
