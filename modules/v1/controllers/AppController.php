<?php

namespace app\modules\v1\controllers;

use Yii;
use app;
use app\modules\v1\models;
use yii\data;

class AppController extends \yii\rest\Controller
{
	public function actionKind(){
		//$appl=new Appl();
		$data=Yii::$app->request->post();
		$query=(new \yii\db\Query())
		->select('*')
		->from('app')
		->innerJoin('appofkind','app.id=appofkind.appid')
		->where(['appofkind.kind' => $data['kind']])
		->all();
		$pages = new Pagination(['totalCount' => $query->count()]);
		$models = $query->offset($pages->offset)
		->limit($pages->limit)
		->all();
		//return $models;
		//print_r($query);
		return $models;
	}
}
