<?php

namespace app\controllers;

use Yii;
use app\models\app;
use app\models\Apptopicture;
use app\models\Systemuser;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use yii\web\UploadedFile;
use Qiniu\json_decode;
use app\modules\v1\models\User;
use yii\db\ActiveQuery;

/**
 * AdminController implements the CRUD actions for app model.
 */
class AdminController extends Controller {
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
	 * Lists all app models.
	 *
	 * @return mixed
	 */
	public function actionIndex() {
		
		if (Yii::$app->session ['var'] === 'admin') {
			return $this->render('index');
			
		} else {
			return $this->redirect ( [ 
					'login' 
			] );
		}
	}
	
	public function actionApp() {
		if (Yii::$app->session ['var'] === 'admin') {
			$dataProvider = new ActiveDataProvider ( [
					'query' => app::find ()
			] );
			$model=new Systemuser();
			$data = Yii::$app->request->post ();
				
			$appdata=new ActiveDataProvider ( [
					'query' => Systemuser::find()->select("*")->where ( [ 'name' => 'ssssss' ] )
			] );
				
			if($data!=false){
				$appdata=new ActiveDataProvider ( [
						'query' => app::find()->select("*")->where ( [ 'name' => $data ['Systemuser']['name'] ] )
				] );
	
				return $this->render ( 'app', [
						'dataProvider' => $dataProvider,
						'model'=>$model ,
						'appdata'=>$appdata
				] );
			}else{
				return $this->render ( 'app', [
						'dataProvider' => $dataProvider,
						'model'=>$model ,
						'appdata'=>$appdata
				] );
			}
				
		} else {
			return $this->redirect ( [
					'login'
			] );
		}
	}
	
	
	/**
	 * Displays a single app model.
	 *
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionView($id) {
		if (Yii::$app->session ['var'] === 'admin') {
			return $this->render ( 'view', [ 
					'model' => $this->findModel ( $id ) 
			] );
		} else {
			return $this->redirect ( [ 
					'login' 
			] );
		}
	}
	
	/**
	 * Creates a new app model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate() {
		if (Yii::$app->session ['var'] === 'admin') {
			$model = new app ();
			$data = Yii::$app->request->post ();
			// echo var_dump($data);
			if ($data != false) {
				echo var_dump ( $data );
				$model->name = $data ['app'] ['name'];
				$model->version = $data ['app'] ['version'];
				$model->android_url = $data ['android_url'];
				$model->ios_url = $data ['ios_url'];
				$model->stars = $data ['app'] ['stars'];
				$model->downloadcount = $data ['app'] ['downloadcount'];
				$model->introduction = $data ['app'] ['introduction'];
				$model->updated_at = time ();
				$model->updated_log = $data ['app'] ['updated_log'];
				$model->size = $data ['app'] ['size'];
				$model->icon = $data ['icon'];
				
				if ($model->save ()) {
					$appdata = $model->findBySql ( "select * from app order by id desc limit 1" )->all ();
					
					foreach ( $data ['pic'] as $pic ) {
						echo $pic;
						$apptpic = new Apptopicture ();
						$apptpic->appid = $appdata [0] ["id"];
						$apptpic->picture = $pic;
						$apptpic->save ();
					}
					return $this->redirect ( [ 
							'view',
							'id' => $model->id 
					] );
				}
			} else {
				return $this->render ( 'create', [ 
						'model' => $model 
				] );
			}
			
			return $this->render ( 'create', [ 
					'model' => $model 
			] );
		} else {
			return $this->redirect ( [ 
					'login' 
			] );
		}
	}
	public function actionUpload() {
		$accessKey = '6dnAU0jREe7QO0nD1ujr6CizVZ87HGhivNS1W9hR';
		$secretKey = 'RYuzaeIJDvFb8KOa9OSlsmlVs7j9A6oFbzwjh9Z0';
		$auth = new Auth ( $accessKey, $secretKey );
		$bucket = 'customizelife';
		$token = $auth->uploadToken ( $bucket );
		$uploadMgr = new UploadManager ();
		// list($ret, $err) = $uploadMgr->put($token, null, 'content string');
		list ( $ret, $err ) = $uploadMgr->putFile ( $token, null, '/home/dawei/Downloads/6bef293afbe28923ee31acc31646bba3.apk' );
		echo "\n====> put result: \n";
		if ($err !== null) {
			var_dump ( $err );
		} else {
			echo $ret ['key'];
		}
	}
	public function actionDownload() {
		$accessKey = 'LsJtdgRp5sm2UXbF2HNhzn6ZzZpA11O7CAXGlJLS';
		$secretKey = 'tfGAEgVEaQYJDLjMT1XAae1uznqCyZTVPlmcImpo';
		$auth = new Auth ( $accessKey, $secretKey );
		
		$baseUrl = 'http://my-space.qiniudn.com/hello';
		
		$authUrl = $auth->privateDownloadUrl ( $baseUrl );
		echo $authUrl;
	}
	public function actionToken() {
		$accessKey = 'LsJtdgRp5sm2UXbF2HNhzn6ZzZpA11O7CAXGlJLS';
		$secretKey = 'tfGAEgVEaQYJDLjMT1XAae1uznqCyZTVPlmcImpo';
		$auth = new Auth ( $accessKey, $secretKey );
		$bucket = 'my-space';
		$token = $auth->uploadToken ( $bucket );
		echo json_encode ( array (
				"uptoken" => $token 
		) );
	}
	public function actionLogin() {
		$model = new Systemuser ();
		
		$model->load ( Yii::$app->request->post () );
		if ($model->name === 'admin' && $model->pwd === 'admin') {
			Yii::$app->session ['var'] = 'admin';
			return $this->redirect ( [ 
					'index' 
			] );
		} else {
			return $this->render ( 'login', [ 
					'model' => $model 
			] );
		}
	}
	/**
	 * Updates an existing app model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionUpdate($id) {
		if (Yii::$app->session ['var'] === 'admin') {
			$model = $this->findModel ( $id );
			
			if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
				return $this->redirect ( [ 
						'view',
						'id' => $model->id 
				] );
			} else {
				return $this->render ( 'update', [ 
						'model' => $model 
				] );
			}
		} else {
			return $this->redirect ( [ 
					'login' 
			] );
		}
	}
	
	/**
	 * Deletes an existing app model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionDelete($id) {
		if (Yii::$app->session ['var'] === 'admin') {
			$this->findModel ( $id )->delete ();
			
			return $this->redirect ( [ 
					'index' 
			] );
		} else {
			return $this->redirect ( [ 
					'login' 
			] );
		}
	}
	
	/**
	 * Finds the app model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id        	
	 * @return app the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = app::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}