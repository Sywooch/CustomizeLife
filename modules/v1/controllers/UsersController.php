<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\User;
use app\modules\v1\models\UserForm;
use yii\web\Controller;
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
		'actions' => ['login','signup'],
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
    
}
