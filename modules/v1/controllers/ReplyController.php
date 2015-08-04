<?php
namespace app\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use app\modules\v1\models\Reply;
//use app\modules\v1\models\Msgtoapp;
use yii\data\ActiveDataProvider;
//use app\modules\v1\models\Reply;

class ReplyController extends ActiveController {
	public $modelClass = 'app\modules\v1\models\Reply';
	public $serializer = [
	'class' => 'yii\rest\Serializer',
	'collectionEnvelope' => 'items'
			];
	public function actions() {
		$actions = parent::actions ();
		unset ( $actions ['index'] );
		unset ( $actions ['create'] );
		//unset ( $actions ['delete'] );
		return $actions;
	}
	public function actionIndex(){
		
	}
	public function actionCreate(){
		$data = Yii::$app->request->post();
		$model=new Reply();
		$model->fromid= Yii::$app->user->id;
		//if($data['toid'])
		$model->toid=$data['toid'];
		$model->msgid=$data['msgid'];
		$model->content=$data['content'];
		$model->isread=0;
		$model->created_at=time();
		return $model->save();
	}
	public function actionDeletereply(){
		$data = Yii::$app->request->post ();
		$id = $data['id'];
		$model = Reply::find()->where(['id'=>$id])->one();
		if($model == null){
			//throw new \yii\web\NotFoundHttpException("record not found",401);
			throw new \yii\web\HttpException(404,"recode not found");
			//return "no record";
		}
		$err=$model->delete();
		if($err==false){
			throw new \yii\web\HttpException(404,"recode delete error");
		}else{
			return "delete ok";
		}
		//$model=new Reply();
		//$model->fromid=$data['fromid'];
		//$model->toid=$data['toid'];
		//$model->msgid=$data['msgid'];
		//$model->content=$data['content'];
		//$model->isread=false;
		//$model->created_at=time();
		//$model->save();
	}
	
}