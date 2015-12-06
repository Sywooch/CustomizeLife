<?php

namespace app\controllers;

use Yii;
use app\modules\v1\models\Appcomments;
use app\models\AppcommentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\User;
use app\models\app;
use app\modules\v1\models\Appl;

/**
 * AppcommentsController implements the CRUD actions for Appcomments model.
 */
class AppcommentsController extends Controller {
	public function behaviors() {
		return [ 
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'delete' => [ 
										'post' 
								] 
						] 
				] 
		];
	}
	
	/**
	 * Lists all Appcomments models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new AppcommentsSearch ();
		$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
		
		$pagination = $dataProvider->getPagination ();
		$count = $pagination->pageCount;
		$count1 = 0;
		while ( $categories = $dataProvider->models ) {
			$models = $categories;
			foreach ( $models as $model ) {
				$userinfo = User::findOne ( [ 
						'id' => $model ['userid'] 
				] );
				$appinfo = app::findOne ( [ 
						'id' => $model ['appid'] 
				] );
				$model ['userid'] = $userinfo ['phone'];
				$model ['appid'] = $appinfo ['name'];
			}
			$dataProvider->setModels ( $models );
			$count1 ++;
			if ($count1 > $count) {
				break;
			}
		}
		
		return $this->render ( 'index', [ 
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider 
		] );
	}
	public function actionIndexofapp() {
		$searchModel = new AppcommentsSearch ();
		$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
	
		$pagination = $dataProvider->getPagination ();
		$count = $pagination->pageCount;
		$count1 = 0;
		while ( $categories = $dataProvider->models ) {
			$models = $categories;
			foreach ( $models as $model ) {
				$userinfo = User::findOne ( [
						'id' => $model ['userid']
						] );
				$appinfo = app::findOne ( [
						'id' => $model ['appid']
						] );
				$model ['userid'] = $userinfo ['phone'];
				$model ['appid'] = $appinfo ['name'];
			}
			$dataProvider->setModels ( $models );
			$count1 ++;
			if ($count1 > $count) {
				break;
			}
		}
	
		return $this->render ( 'index_app', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider
				] );
	}
	/**
	 * Displays a single Appcomments model.
	 * 
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionView($id) {
		$model = $this->findModel ( $id );
		$userinfo = User::findOne ( [ 
				'id' => $model ['userid'] 
		] );
		$appinfo = app::findOne ( [ 
				'id' => $model ['appid'] 
		] );
		$model ['userid'] = $userinfo ['phone'];
		$model ['appid'] = $appinfo ['name'];
		return $this->render ( 'view', [ 
				'model' => $model 
		] );
	}
	
	/**
	 * Creates a new Appcomments model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Appcomments ();
		
		$data = Yii::$app->request->post ();
		if ($data != false) {
			$userinfo = User::findOne ( [ 
					'phone' => $data['Appcomments'] ['userid'] 
			] );
			$appinfo = app::findOne ( [ 
					'name' => $data ['Appcomments']['appid'] 
			] );
			
			$model->appid=(string)$appinfo ['id'];
			$model->userid=$userinfo ['id'];
			$model->usernickname=$userinfo ['nickname'];
			$model->userthumb=$userinfo ['thumb'];
			$model->created_at=(string)time();
			$model->title=$data ['Appcomments']['title'];
			$model->commentstars=$data ['Appcomments']['commentstars'];
			$model->comments=$data ['Appcomments']['comments'];
			
			if ($model->save()) {
				return $this->redirect ( [ 
						'view',
						'id' => $model->id 
				] );
			} else {
				return $this->render ( 'create', [ 
						'model' => $model 
				] );
			}
		}else{
			return $this->render ( 'create', [
					'model' => $model
					] );
		}
	}
	
	/**
	 * Updates an existing Appcomments model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel ( $id );
		
		$userinfo = User::findOne ( [
				'id' => $model ['userid']
				] );
		$appinfo = app::findOne ( [
				'id' => $model ['appid']
				] );
		$model ['userid'] = $userinfo ['phone'];
		$model ['appid'] = $appinfo ['name'];
		
		$data = Yii::$app->request->post ();
		if ($data != false) {
			$userinfo = User::findOne ( [
					'phone' => $data['Appcomments'] ['userid']
					] );
			$appinfo = app::findOne ( [
					'name' => $data ['Appcomments']['appid']
					] );
				
			$model->appid=(string)$appinfo ['id'];
			$model->userid=$userinfo ['id'];
			$model->usernickname=$userinfo ['nickname'];
			$model->userthumb=$userinfo ['thumb'];
			$model->created_at=(string)time();
			$model->title=$data ['Appcomments']['title'];
			$model->commentstars=$data ['Appcomments']['commentstars'];
			$model->comments=$data ['Appcomments']['comments'];
				
			if ($model->save()) {
				return $this->redirect ( [
						'view',
						'id' => $model->id
						] );
			} else {
				return $this->render ( 'update', [
						'model' => $model
						] );
			}
		}else{
			return $this->render ( 'update', [
					'model' => $model
					] );
		}
	}
	
	/**
	 * Deletes an existing Appcomments model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * 
	 * @param integer $id        	
	 * @return mixed
	 */
	
	public function actionDeleteone($id) {
		$model=$this->findModel($id);
		$app=Appl::findOne(['id'=>$model->appid]);
		$this->findModel ( $id )->delete ();
	
		return $this->redirect ( [
				'indexofapp?AppcommentsSearch%5Bappid%5D='.$app->name
		] );
	}
	
	public function actionDelete($id) {
		$this->findModel ( $id )->delete ();
		
		return $this->redirect ( [ 
				'index'
		] );
	}
	
	/**
	 * Finds the Appcomments model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param integer $id        	
	 * @return Appcomments the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Appcomments::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
