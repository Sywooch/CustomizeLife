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
use app\modules\v1\models\Appofkind;
use app\models\appSearch;

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
			
			$searchModel = new appSearch();
			$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
			
				return $this->render ( 'app', [
						'dataProvider' => $dataProvider,
						'searchModel'=>$searchModel ,
				] );
			
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
					'model' => $this->findModel ( $id ) ,
					'apptopicture' => (new \yii\db\Query ())->from('apptopicture')->where(['appid'=>$id])->all(),
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
// 				echo var_dump ( $data );
// 				$model->name = $data ['app'] ['name'];
// 				$model->version = $data ['app'] ['version'];
// 				$model->profile = $data ['app'] ['profile'];
// 				$model->android_url = $data ['android_url'];
// 				$model->ios_url = $data ['ios_url'];
// 				$model->stars = $data ['app'] ['stars'];
// 				$model->downloadcount = $data ['app'] ['downloadcount'];
// 				$model->commentscount = $data ['app'] ['commentscount'];
// 				$model->introduction = $data ['app'] ['introduction'];
// 				$model->updated_at = time ();
// 				$model->updated_log = $data ['app'] ['updated_log'];
// 				$model->size = $data ['app'] ['size'];
				//$model->kind=$data ['app'] ['kind'];
				$model->load($data);
				$model->android_url = $data ['android_url'];
				$model->icon = $data ['icon'];
				$model->updated_at = time ();
// 				foreach ( $data['kind1array'] as $kind ) {
// 					$model->kind.=$kind." ";
// 				}
				foreach ( $data['kind2array'] as $kind ) {
					$model->kind.=$kind." ";
				}
				
				
				
				if ($model->save ()) {
					$appdata = $model->findBySql ( "select * from app order by id desc limit 1" )->all ();
					
					foreach ( $data ['pic'] as $pic ) {
						$apptpic = new Apptopicture ();
						$apptpic->appid = $model->id;
						$apptpic->picture = $pic;
						$apptpic->save ();
					}
					
// 					foreach ( $data['kind1array'] as $kind ) {
// 						$appkind=new Appofkind();
// 						$appkind->appid=$model->id;
// 						$appkind->status =1;
// 						$appkind->kind=$kind;
// 						$appkind->save();
// 					}
					foreach ( $data['kind1array'] as $kind ) {
						$appkind=new Appofkind();
						$appkind->appid=$model->id;
						//$appkind->status =2;
						$appkind->kind=$kind;
						$appkind->save();
					}
					
					return $this->redirect ( [ 
							'view',
							'id' => $model->id 
					] );
				}
			} else {
				//$allkind1 = (new \yii\db\Query ())->select ('kind')->distinct(true)->from('appofkind')->where('status=1')->all();
				$allkind2 = (new \yii\db\Query ())->select ('second')->distinct(true)->from('tag')->where(['>','second',''])->all();
				//$checkbox1=array();
				$checkbox2=array();
// 				foreach($allkind1 as $name)
// 				{
// 					$checkbox1[$name['kind']]=$name['kind'];
// 				}
				foreach($allkind2 as $name)
				{
					$checkbox2[$name['second']]=$name['second'];
				}
				return $this->render ( 'create', [ 
						'model' => $model ,
						//'allkind1'=>$checkbox1,
						'allkind2'=>$checkbox2,
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
		$accessKey = '6dnAU0jREe7QO0nD1ujr6CizVZ87HGhivNS1W9hR';
		$secretKey = 'RYuzaeIJDvFb8KOa9OSlsmlVs7j9A6oFbzwjh9Z0';
		$auth = new Auth ( $accessKey, $secretKey );
		
		$baseUrl = 'http://7xkbeq.com1.z0.glb.clouddn.com/u=2117727038,2641018931&fm=21&gp=0.jpg';
		
		$authUrl = $auth->privateDownloadUrl ( $baseUrl );
		echo $authUrl;
	}
	public function actionToken() {
		$accessKey = '6dnAU0jREe7QO0nD1ujr6CizVZ87HGhivNS1W9hR';
		$secretKey = 'RYuzaeIJDvFb8KOa9OSlsmlVs7j9A6oFbzwjh9Z0';
		$auth = new Auth ( $accessKey, $secretKey );
		$bucket = 'customizelife';
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
					'admin/index#1/11' 
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
			

			//$data['kindarray'][] = '0';
			//$data = array();
			if ($model->load ( Yii::$app->request->post () )) {
				$dada = Yii::$app->request->post ();
				//$model->kind1array = $dada['app']['kind1array'];
				$model->kind2array = $dada['app']['kind2array'];
				$pics = array();
				if(isset($dada['pic']))
				{
					$pics = $dada['pic'];
				}
				
				//return var_dump($model);
// 				$appofkind1 = Appofkind::find()->where(['appid'=>$id,'status'=>1])->all();
// 				foreach ($appofkind1 as $a){
// 					$a->delete();
// 				}
				$model->kind = "";
// 				foreach ($model->kind1array as $k) {
// 					$model->kind = $model->kind . " " .$k;
// 					$appofkindnew = new Appofkind();
// 					$appofkindnew->kind = $k;
// 					$appofkindnew->appid = $id;
// 					$appofkindnew->status = 1;
// 					$appofkindnew->save();
					
// 				}
				
				$appofkind2 = Appofkind::find()->where(['appid'=>$id])->all();
				foreach ($appofkind2 as $a){
					$a->delete();
				}
				if(isset($dada['icon']))
					$model->icon = $dada['icon'];
				if(isset($dada['android_url']))
					$model->android_url =$dada['android_url'];
				
				foreach ($model->kind2array as $k) {
					$model->kind = $model->kind . " " .$k;
					$appofkindnew = new Appofkind();
					$appofkindnew->kind = $k;
					$appofkindnew->appid = $id;
					$appofkindnew->status = 2;
					$appofkindnew->save();
						
				}
				
				foreach ($pics as $pic){
					$apptopicture = new Apptopicture();
					$apptopicture->appid = $id;
					$apptopicture->picture = $pic;
					$apptopicture->save();
				}
				if ($model->save ()) {
					return $this->redirect ( [
							'view',
							'id' => $model->id
							] );
				}
			} else {
				$data=$model;
				//$kind1 = (new \yii\db\Query ())->select ('kind')->from('appofkind')->where(['appid'=>$id,'status'=>1])->all();
				$kind2 = (new \yii\db\Query ())->select ('kind')->from('appofkind')->where(['appid'=>$id])->all();
				//$kind1array = array();
				$kind2array = array();
// 				foreach ($kind1 as $index=>$kindname){
// 					$kind1array[]=$kindname['kind'];
// 				}
				foreach ($kind2 as $index=>$kindname){
					$kind2array[]=$kindname['kind'];
				}
				//$data['kind1array'] = $kind1array;
				$data['kind2array'] = $kind2array;
				//$allkind1 = (new \yii\db\Query ())->select ('kind')->distinct(true)->from('appofkind')->where('status=1')->all();
				$allkind2 = (new \yii\db\Query ())->select ('second')->distinct(true)->from('tag')->where(['>','second',''])->all();
				//$checkbox1=array();
				$checkbox2=array();
				
				$apptopicture = (new \yii\db\Query ())->from('apptopicture')->where(['appid'=>$id])->all();
// 				foreach($allkind1 as $name)
// 				{
// 					$checkbox1[$name['kind']]=$name['kind'];
// 				}
				foreach($allkind2 as $name)
				{
					$checkbox2[$name['second']]=$name['second'];
				}
				return $this->render ( 'update', [ 
						'model' => $data,
						//'allkind1' => $checkbox1,
						'allkind2' => $checkbox2,
						'apptopicture'=>$apptopicture,
						//['社交'=>'社交','休闲'=>'休闲','娱乐'=>'娱乐','工具'=>'工具','导航'=>'导航','购物'=>'购物','体育'=>'体育','旅游'=>'旅游','生活'=>'生活','音乐'=>'音乐','教育'=>'教育','办公'=>'办公','理财'=>'理财','图像'=>'图像']
						//'model' => $model 
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