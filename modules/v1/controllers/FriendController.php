<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\v1\models\Friend;
use app\modules\v1\models\User;
use yii\db\ActiveRecord;



class FriendController extends Controller
{
	public $enableCsrfValidation = false;
	
  public function actionListenadd()     //监听添加好友
   {

   	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
   		 $model=new Friend();
   		 $data=Yii::$app->request->post();
   	    
   	     $num=$model->find()->andWhere(['friendid'=>$data['myid'],'status'=>false])->count();

   	   if($num>0){
   	    	$aa=(new \yii\db\Query())
		   	->select('myid, nickname')
		   	->from('friends f')
		   	->join('LEFT JOIN','user u','f.myid=u.id')
		   	->where(['friendid'=>$data['myid']])
		   	->all();
   	   return $aa;
   	    }else{
   	    	return 0;
   	    }
   }
   
   public function actionGetall()   //得到所有好友
   {
   	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
   	$myid=Yii::$app->request->post();
   	
   	$aa=(new \yii\db\Query())
   	->select('friendid, nickname,status')
   	->from('friends f')
   	->join('LEFT JOIN','user u','f.friendid=u.id')
   	->where(['myid'=>$myid])
   	->all();
   	return $aa;
   }
   
   public function actionRequestadd()    //请求添加好友
   {
   	$data=Yii::$app->request->post();
   	$model=new Friend();
   	$model->myid=$data['myid'];
   	$model->friendid=$data['friendid'];
   	$model->status=false;
   	echo $data['myid'];
   	$num=$model->find()->andWhere(['myid'=>$data['myid'],'friendid'=>$data['friendid']])->count();
   	echo $num;
   	if($num==0){
   		$model->save();
   		echo "Request Success";
   	}else{
   		echo "Already Added";
   	}
   }
   
   public function actionRequestresult()    //返回请求添加的结果
   {
   	
   }
   
   public function actionAcceptadd()     //接受添加
   {
   	$data=Yii::$app->request->post();
   	
   	$row=Friend::findOne(['myid'=>$data['friendid'],'friendid'=>$data['myid']]);
   	$row->status=true;
   	$row->save();
   	
   	$model=new Friend();
   	$model->myid=$data['myid'];
   	$model->friendid=$data['friendid'];
   	$model->status=true;
   	$model->save();
   	echo "Add Success";
   }
   
}
