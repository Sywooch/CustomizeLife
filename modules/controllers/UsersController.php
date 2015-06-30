<?php

namespace app\modules\controllers;

use Yii;
use app\modules\models\RegisterForm;
use yii\web\Controller;

class UsersController extends Controller
{
	public $enableCsrfValidation = false;
    public function actionSignup()
    {
        $model=new RegisterForm();
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
    	
    }

}
