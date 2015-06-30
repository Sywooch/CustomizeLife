<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\web\Controller;
use app\models\UserForm;
use yii\web\session;
use app\models\YiiUser;
use yii\filters\AccessControl;
use app\models\User;

class IndexController extends Controller{
    public $enableCsrfValidation = false;//yii默认表单csrf验证，如果post不带改参数会报错！
    public $layout  = 'layout';

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
                        'actions' => ['login','captcha','signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','edit','add','del','index','users','thumb','upload','cutpic','follow','nofollow'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @验证码独立操作
     */

    public function actions(){
        return [

            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * @return string 后台默认页面
     */
    public function actionIndex()
    {
        //echo Yii::$app->user->getId().'<br/>';获取用户id
        //echo Yii::$app->user->identity->getUser();//获取用户名

       // echo Yii::$app->basePath;//获取应用根目录
       echo "hello index";
        //return $this->render('index');
    }
    

    /**
     * @return string|\yii\web\Response 用户登录
     */

    public function actionLogin(){
    	
        $model=new UserForm();
        
        if($model->load(Yii::$app->request->post(),'')){

            if($model->login()){
                //查询未读消息
               echo "login success";
            }else{
                return "login failure";
            }
        }

     
    }
    
    /**
     * @return string|\yii\web\Response 用户注册
     */
    
    public function actionSignup(){
    	
    	$model=new YiiUser();
    	$data=Yii::$app->request->post();
    	//$model->user=$data['user'];
    	$model->pwd=md5($data['pwd']);
    	//$model->authKey=$data['authKey'];
    	//$model->accessKey=$data['accessKey'];
    	$model->email=$data['email'];
    	
    	//$model->find()->where(['email'=>$data['email']])->one();
    	
    	if($model->find()->where(['email'=>$data['email']])->one()||$model->find()->where(['user'=>$data['user']])->one())
    	{
    		echo "already exists";
    	}else {
    		$model->save();
    		echo json_encode("sighup success");
    	}
    }



    /**
     * @后台退出页面
     */
    public function actionLogout(){
    	echo "log out";
       // Yii::$app->user->logout();
        //return $this->goHome();

    }


    /**
     * @用户头像上传
     */
    public function  actionThumb(){
    	echo "添加头像";
      // $user=YiiUser::findOne(Yii::$app->user->getId());
       // return $this->render('thumb',array('user'=>$user));
    }

    /**
     * @
     */
    public  function  actionUpload(){

        $path = Yii::$app->basePath."/web/avatar/";
        $tmpath="/avatar/";
        if(!empty($_FILES)){

            //得到上传的临时文件流
            $tempFile = $_FILES['myfile']['tmp_name'];

            //允许的文件后缀
            $fileTypes = array('jpg','jpeg','gif','png');

            //得到文件原名
            $fileName = iconv("UTF-8","GB2312",$_FILES["myfile"]["name"]);
            $fileParts = pathinfo($_FILES['myfile']['name']);



            //最后保存服务器地址
            if(!is_dir($path)){
                mkdir($path);
            }

            if (move_uploaded_file($tempFile, $path.$fileName)){
                $info= $tmpath.$fileName;
                $status=1;
                $data=array('path'=>Yii::$app->basePath,'file'=> $path.$fileName);
            }else{
                $info=$fileName."上传失败！";
                $status=0;
                $data='';
            }
            echo $info;
        }

    }

    /**
     * @裁剪头像
     */

    public function actionCutpic(){
        if(Yii::$app->request->isAjax){
            $path="/avatar/";
            $targ_w = $targ_h = 150;
            $jpeg_quality = 100;
            $src =Yii::$app->request->post('f');
            $src=Yii::$app->basePath.'/web'.$src;//真实的图片路径

            $img_r = imagecreatefromjpeg($src);
            $ext=$path.time().".jpg";//生成的引用路径
            $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

            imagecopyresampled($dst_r,$img_r,0,0,Yii::$app->request->post('x'),Yii::$app->request->post('y'),
                $targ_w,$targ_h,Yii::$app->request->post('w'),Yii::$app->request->post('h'));

            $img=Yii::$app->basePath.'/web/'.$ext;//真实的图片路径

            if(imagejpeg($dst_r,$img,$jpeg_quality)){
                //更新用户头像
                $user=YiiUser::findOne(Yii::$app->user->getId());
                $user->thumb=$ext;
                $user->save();
                $arr['status']=1;
                $arr['data']=$ext;
                $arr['info']='裁剪成功！';
                echo json_encode($arr);

            }else{
                $arr['status']=0;
                echo json_encode($arr);
            }
            exit;
        }
    }



}
