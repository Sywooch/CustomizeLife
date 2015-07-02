<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\v1\models\Friend;


class FriendController extends Controller
{
	public $enableCsrfValidation = false;
	
  public function actionAdd()
   {
   		$model=new Friend();
   		$data=Yii::$app->request->post();
   	    $model->myid=$data['myid'];
   	    $model->friendid=$data['friendid'];
   	    echo $model->myid;
   	    echo $model->friendid;
   	    $num=$model->find()->andWhere(['myid'=>$data['myid'],'friendid'=>$data['friendid']])->count();
   	    echo $num;
   	   if($num==0){
   	    	$model->save();
   	    echo "Add Success";
   	    }else{
   	    	echo "Already Added";
   	    }
   }
}