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
use app\models\userappSearch;
use app\modules\v1\models\Reltag;
use app\modules\v1\models\Apptoreltag;
use app\modules\v1\models\Tag;

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
	
	public function actionRecom($id){
		$model = $this->findModel($id);
		//echo $model->authKey;
		$model->commend=$model->commend?0:1;
		//echo $model->authKey;
		$model->save();
		$arr=explode('/',$_SERVER['HTTP_REFERER']);
		return $this->redirect([$arr[4]]);
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
			
			$pagination = $dataProvider->getPagination ();
			$count = $pagination->pageCount;
			$count1 = 0;
			while ( $categories = $dataProvider->models ) {
				$models = $categories;
				foreach ( $models as $model ) {
					$taginfo=(new \yii\db\Query ())->select ( 'r.tag' )->from ( 'apptoreltag a' )
					->join('INNER JOIN', 'reltag r','a.tagid=r.id')
					->where ( [
							'a.appid' => $model ['id']
					] )->all();
					$model['reltag']="";
					if(count($taginfo)>0){
						foreach($taginfo as $tag){
							$model['reltag']=$model['reltag'].$tag['tag']." ";
						}
					}
					
					
					$kindinfo=(new \yii\db\Query ())->select ( 'r.second' )->from ( 'appofkind a' )
				->join('INNER JOIN', 'tag r','a.kindid=r.id')
				->where ( [
						'a.appid' => $model ['id']
				] )->all();
					$model['kind']="";
					if(count($kindinfo)>0){
						foreach($kindinfo as $kind){
							$model['kind']=$model['kind'].$kind['second']." ";
						}
					}
					
					//$model ['reltag'] = $userinfo ['phone'];
				}
				$dataProvider->setModels ( $models );
				$count1 ++;
				if ($count1 > $count) {
					break;
				}
			}
			
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
	
	public function actionTagrecom() {
		if (Yii::$app->session ['var'] === 'admin') {
				
			$searchModel = new appSearch();
			$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
			$dataProvider->query = $dataProvider->query->orderBy("commend desc");
			$pagination = $dataProvider->getPagination ();
			$count = $pagination->pageCount;
			$count1 = 0;
			while ( $categories = $dataProvider->models ) {
				$models = $categories;
				foreach ( $models as $model ) {
					$taginfo=(new \yii\db\Query ())->select ( 'r.tag' )->from ( 'apptoreltag a' )
					->join('INNER JOIN', 'reltag r','a.tagid=r.id')
					->where ( [
							'a.appid' => $model ['id']
					] )->all();
					$model['reltag']="";
					if(count($taginfo)>0){
						foreach($taginfo as $tag){
							$model['reltag']=$model['reltag'].$tag['tag']." ";
						}
					}
						
						
					$kindinfo=(new \yii\db\Query ())->select ( 'r.second' )->from ( 'appofkind a' )
					->join('INNER JOIN', 'tag r','a.kindid=r.id')
					->where ( [
							'a.appid' => $model ['id']
					] )->all();
					$model['kind']="";
					if(count($kindinfo)>0){
						foreach($kindinfo as $kind){
							$model['kind']=$model['kind'].$kind['second']." ";
						}
					}
						
					//$model ['reltag'] = $userinfo ['phone'];
				}
				$dataProvider->setModels ( $models );
				$count1 ++;
				if ($count1 > $count) {
					break;
				}
			}
			return $this->render ( 'tagrecom', [
					'dataProvider' => $dataProvider,
					'searchModel'=>$searchModel ,
					] );
				
		} else {
			return $this->redirect ( [
					'login'
					] );
		}
	}
	
	public function actionUserapp() {
		if (Yii::$app->session ['var'] === 'admin') {
				
		$searchModel = new appSearch();
			$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
			
			$pagination = $dataProvider->getPagination ();
			$count = $pagination->pageCount;
			$count1 = 0;
			while ( $categories = $dataProvider->models ) {
				$models = $categories;
				foreach ( $models as $model ) {
					$taginfo=(new \yii\db\Query ())->select ( 'r.tag' )->from ( 'apptoreltag a' )
					->join('INNER JOIN', 'reltag r','a.tagid=r.id')
					->where ( [
							'a.appid' => $model ['id']
					] )->all();
					$model['reltag']="";
					if(count($taginfo)>0){
						foreach($taginfo as $tag){
							$model['reltag']=$model['reltag'].$tag['tag']." ";
						}
					}
					
					
					$kindinfo=(new \yii\db\Query ())->select ( 'r.second' )->from ( 'appofkind a' )
				->join('INNER JOIN', 'tag r','a.kind=r.id')
				->where ( [
						'a.appid' => $model ['id']
				] )->all();
					$model['kind']="";
					if(count($kindinfo)>0){
						foreach($kindinfo as $kind){
							$model['kind']=$model['kind'].$kind['second']." ";
						}
					}
					
					//$model ['reltag'] = $userinfo ['phone'];
				}
				$dataProvider->setModels ( $models );
				$count1 ++;
				if ($count1 > $count) {
					break;
				}
			}
			return $this->render ( 'userapp', [
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
			$model=$this->findModel ( $id );
			$taginfo=(new \yii\db\Query ())->select ( 'r.tag' )->from ( 'apptoreltag a' )
			->join('INNER JOIN', 'reltag r','a.tagid=r.id')
			->where ( [
					'a.appid' => $model ['id']
			] )->all();
			$model->reltag="";
			if(count($taginfo)>0){
				foreach($taginfo as $tag){
					$model->reltag=$model->reltag.$tag['tag']." ";
				}
			}
			$kindinfo=(new \yii\db\Query ())->select ( 'r.second' )->from ( 'appofkind a' )
			->join('INNER JOIN', 'tag r','a.kindid=r.id')
			->where ( [
					'a.appid' => $model ['id']
			] )->all();
			$model['kind']="";
			if(count($kindinfo)>0){
				foreach($kindinfo as $kind){
					$model['kind']=$model['kind'].$kind['second']." ";
				}
			}
			return $this->render ( 'view', [ 
					'model' =>  $model,
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
			$allkind2 = (new \yii\db\Query ())->distinct(true)->from('tag')->where(['>','second',''])->all();
			$allkindlab = (new \yii\db\Query ())->select('tag')->from('reltag')->all();
			//$checkbox1=array();
			$checkbox2=array();
			// 				foreach($allkind1 as $name)
				// 				{
				// 					$checkbox1[$name['kind']]=$name['kind'];
				// 				}
			foreach($allkind2 as $name)
			{
				$checkbox2[$name['first']][$name['second']]=$name['second'];
			}
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
				$appinfo=$model->find()->where(['package'=>$data ['app']['package']])->one();
				if($appinfo){
					return $this->redirect ( [
							'view',
							'id' => $appinfo->id
					] );
				}
				
				$model->load($data);
				unset($model->reltag);
				$model->android_url = $data ['android_url'];
				$model->icon = $data ['icon'];
				$model->updated_at = time ();
// 				$allreltag=trim($model->reltag);
// 				$row=explode(" ",$allreltag);
				
				
// 				foreach ($row as $tag){
// 				if(trim($tag)==''){
// 						continue;
// 					}
// 					$relmodel=new Reltag();
// 					$one=$relmodel->find()->where(['tag'=>$tag])->one();
// 					if(!$one){
// 						$relmodel->tag=$tag;
// 						$relmodel->created_at=time();
// 						$relmodel->save();
// 					}
// 				}
// 				foreach ( $data['kind1array'] as $kind ) {
// 					$model->kind.=$kind." ";
// 				}
				foreach ( $data['app']['kind2array'] as $kind ) {
					$model->kind.=$kind." ";
				}
				
				foreach ( $data['app']['reltag'] as $label ) {
 					$model->reltag.=$label." ";
 				}
				
				
				
				if ($model->save ()) {
					$appdata = $model->findBySql ( "select * from app order by id desc limit 1" )->all ();
					
					foreach ( $data ['pic'] as $pic ) {
						$apptpic = new Apptopicture ();
						$apptpic->appid = $model->id;
						$apptpic->picture = $pic;
						$apptpic->save ();
					}
					
					
// 					$allreltag=trim($model->reltag);
// 					$row=explode(" ",$allreltag);
// 					foreach ($row as $tag){
// 						if(trim($tag)==''){
// 							continue;
// 						}
// 						$relmodel=new Reltag();
// 						$one=$relmodel->find()->where(['tag'=>$tag])->one();
						
// 						$apptoreltag=new Apptoreltag();
// 						$apptoreltag->appid=$model->id;
// 						$apptoreltag->tagid=$one->id;
// 						$apptoreltag->save();
// 					}
					
					foreach ( $data['app']['reltag'] as $label ) {
						$relmodel=new Reltag();
						$one=$relmodel->find()->where(['tag'=>$label])->one();
						$apptoreltag=new Apptoreltag();
						$apptoreltag->appid=$model->id;
						$apptoreltag->tagid=$one->id;
						$apptoreltag->save();
					}
// 					foreach ( $data['kind1array'] as $kind ) {
// 						$appkind=new Appofkind();
// 						$appkind->appid=$model->id;
// 						$appkind->status =1;
// 						$appkind->kind=$kind;
// 						$appkind->save();
// 					}
					foreach ( $data['app']['kind2array'] as $kind ) {
						$appkind=new Appofkind();
						$one=Tag::find()->where(['second'=>$kind])->one();
						
						$appkind->appid=$model->id;
						//$appkind->status =2;
						$appkind->kindid=$one->id;
						$appkind->save();
					}
					
					return $this->redirect ( [ 
							'view',
							'id' => $model->id 
					] );
				}
			} else {
				//$allkind1 = (new \yii\db\Query ())->select ('kind')->distinct(true)->from('appofkind')->where('status=1')->all();
				return $this->render ( 'create', [ 
						'model' => $model ,
						//'allkind1'=>$checkbox1,
						'allkind2'=>$checkbox2,
						'allkindlab'=>$allkindlab,
				] );
			}
			
			return $this->render ( 'create', [ 
					'model' => $model ,
					'allkind2'=>$checkbox2,
					'allkindlab'=>$allkindlab,
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
			$allkindlab = (new \yii\db\Query ())->select('tag')->from('reltag')->all();

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
				
// 				$allreltag=array();
// 				foreach ( $dada['app']['reltag']as $tag){
// 					$allreltag[]=$tag;
// 				}
				
				//$data->reltag='旅游';
				//return;
// 				foreach ($model->kind1array as $k) {
// 					$model->kind = $model->kind . " " .$k;
// 					$appofkindnew = new Appofkind();
// 					$appofkindnew->kind = $k;
// 					$appofkindnew->appid = $id;
// 					$appofkindnew->status = 1;
// 					$appofkindnew->save();
					
// 				}

// 			$allreltag=trim($model->reltag);
// 				$row=explode(" ",$allreltag);
				
				
// 				foreach ($row as $tag){
// 					//trim($tag)
// 					if(trim($tag)==''){
// 						continue;
// 					}
// 					$relmodel=new Reltag();
// 					$one=$relmodel->find()->where(['tag'=>$tag])->count();
// 					if($one==0){
// 						$relmodel->tag=$tag;
// 						$relmodel->created_at=time();
// 						$relmodel->save();
// 					}
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
					
					$one=Tag::find()->where(['second'=>$k])->one();
					$appofkindnew->kindid=$one->id;
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
				unset($model->reltag);
				if ($model->save ()) {
					Apptoreltag::deleteAll(['appid'=>$id]);
					
// 					$allreltag=trim($model->reltag);
// 					$row=explode(" ",$allreltag);
// 					foreach ($row as $tag){
// 						if(trim($tag)==''){
// 							continue;
// 						}
// 						$relmodel=new Reltag();
// 						$one=$relmodel->find()->where(['tag'=>$tag])->one();
					
// 						$apptoreltag=new Apptoreltag();
// 						$apptoreltag->appid=$model->id;
// 						$apptoreltag->tagid=$one->id;
// 						$apptoreltag->save();
// 					}
					
					foreach ( $dada['app']['reltag'] as $label ) {
						$relmodel=new Reltag();
						$one=$relmodel->find()->where(['tag'=>$label])->one();
						$apptoreltag=new Apptoreltag();
						$apptoreltag->appid=$model->id;
						$apptoreltag->tagid=$one->id;
						$apptoreltag->save();
					}
					
					return $this->redirect ( [
							'view',
							'id' => $model->id
							] );
				}
			} else {
				$data=$model;
				//$kind1 = (new \yii\db\Query ())->select ('kind')->from('appofkind')->where(['appid'=>$id,'status'=>1])->all();
				//$kind2 = (new \yii\db\Query ())->select ('kind')->from('appofkind')->where(['appid'=>$id])->all();
				$kind2=(new \yii\db\Query ())->select ( 'r.second' )->from ( 'appofkind a' )
				->join('INNER JOIN', 'tag r','a.kindid=r.id')
				->where ( [
						'a.appid' => $model ['id']
				] )->all();
				//$kind1array = array();
				$kind2array = array();
// 				foreach ($kind1 as $index=>$kindname){
// 					$kind1array[]=$kindname['kind'];
// 				}
				foreach ($kind2 as $kindname){
					$kind2array[]=$kindname['second'];
				}
				//$data['kind1array'] = $kind1array;
				$data['kind2array'] = $kind2array;
				//$allkind1 = (new \yii\db\Query ())->select ('kind')->distinct(true)->from('appofkind')->where('status=1')->all();
				$allkind2 = (new \yii\db\Query ())->distinct(true)->from('tag')->where(['>','second',''])->all();
				//$checkbox1=array();
				$checkbox2=array();
				
				$apptopicture = (new \yii\db\Query ())->from('apptopicture')->where(['appid'=>$id])->all();
// 				foreach($allkind1 as $name)
// 				{
// 					$checkbox1[$name['kind']]=$name['kind'];
// 				}
				foreach($allkind2 as $name)
				{
					$checkbox2[$name['first']][$name['second']]=$name['second'];
				}
				
				$taginfo=(new \yii\db\Query ())->select ( 'r.tag' )->from ( 'apptoreltag a' )
				->join('INNER JOIN', 'reltag r','a.tagid=r.id')
				->where ( [
						'a.appid' => $model ['id']
				] )->all();
				$allreltag=array();
				foreach ($taginfo as $tag){
					$allreltag[]=$tag['tag'];
				}
				
				$data->reltag=$allreltag;
// 				if(count($taginfo)>0){
// 					foreach($taginfo as $tag){
// 						$data->reltag=$data->reltag.$tag['tag']." ";
// 					}
// 				}
				
				return $this->render ( 'update', [ 
						'model' => $data,
						//'allkind1' => $checkbox1,
						'allkind2' => $checkbox2,
						'apptopicture'=>$apptopicture,
						'allkindlab'=>$allkindlab,
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
	
	public function actionUserupdate($id) {
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
	
				$allreltag=trim($model->reltag);
				$row=explode(" ",$allreltag);
				
				
				foreach ($row as $tag){
				if(trim($tag)==''){
						continue;
					}
					$relmodel=new Reltag();
					$one=$relmodel->find()->where(['tag'=>$tag])->count();
					if($one==0){
						$relmodel->tag=$tag;
						$relmodel->created_at=time();
						$relmodel->save();
					}
				}
				
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
					$appofkindnew->kindid = $k;
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
				$allkind2 = (new \yii\db\Query ())->distinct(true)->from('tag')->where(['>','second',''])->all();
				//$checkbox1=array();
				$checkbox2=array();
	
				$apptopicture = (new \yii\db\Query ())->from('apptopicture')->where(['appid'=>$id])->all();
				// 				foreach($allkind1 as $name)
					// 				{
					// 					$checkbox1[$name['kind']]=$name['kind'];
					// 				}
						foreach($allkind2 as $name)
						{
							$checkbox2[$name['first']][$name['second']]=$name['second'];
						}
						return $this->render ( 'userupdate', [
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
					'app' 
			] );
		} else {
			return $this->redirect ( [ 
					'login' 
			] );
		}
	}
	
	public function actionUserdelete($id) {
		if (Yii::$app->session ['var'] === 'admin') {
			$this->findModel ( $id )->delete ();
				
			return $this->redirect ( [
					'userapp'
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
