<?php

namespace app\controllers;



use Yii;
use app\models\app;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use yii\web\UploadedFile;
use Qiniu\json_decode;

/**
 * AdminController implements the CRUD actions for app model.
 */
class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all app models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => app::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single app model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new app model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new app();
        $data=Yii::$app->request->post ();
        //echo var_dump($data);
        if($data!=false){
        	echo var_dump($data);
        $model->name=$data['app']['name'];
        $model->version=$data['app']['version'];
        $model->url=$data['app']['url'];
        $model->stars=$data['app']['stars'];
        $model->downloadcount=$data['app']['downloadcount'];
        $model->introduction=$data['app']['introduction'];
        $model->updated_at=$data['app']['updated_at'];
        
        $model->size=$data['app']['size'];
        $model->icon=$data['icon'];
        $model->save();
        }
        /*if (isset($_POST['app'])) {
        	$model->attributes=$_POST['app'];
        	//$rootPath = "uploads/";
        	$image = UploadedFile::getInstance($model, 'icon');
        	/*$ext = $image->getExtension();
        	$randName = time() . rand(1000, 9999) . ".".$ext ;
        	$path = abs(crc32($randName) % 500);
        	$rootPath = $rootPath . $path . "/";
        	if (!file_exists($path)) {
        		mkdir($rootPath,0777,true);
        	}
        	$image->saveAs($rootPath . $randName);
        	$accessKey='LsJtdgRp5sm2UXbF2HNhzn6ZzZpA11O7CAXGlJLS';
        	$secretKey='tfGAEgVEaQYJDLjMT1XAae1uznqCyZTVPlmcImpo';
        	$auth=new Auth($accessKey, $secretKey);
        	$bucket='my-space';
        	$token = $auth->uploadToken($bucket);
        	$uploadMgr = new UploadManager();
        	
        	list($ret, $err) = $uploadMgr->put($token, null, $image);
        	
        	if ($err !== null) {
        		var_dump($err);
        	} else {
        		$baseUrl='http://my-space.qiniudn.com/'.$ret['key'];
        		$authUrl = $auth->privateDownloadUrl($baseUrl);
        		$model->icon=$authUrl;
        	}
        
        	if($model->save())
        	{
        		echo "already save";
        		return $this->redirect(['view', 'id' => $model->id]);
        	}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
        return $this->render('create', [
        		'model' => $model,
        		]);
    }
    public function actionUpload(){
    	$accessKey='LsJtdgRp5sm2UXbF2HNhzn6ZzZpA11O7CAXGlJLS';
    	$secretKey='tfGAEgVEaQYJDLjMT1XAae1uznqCyZTVPlmcImpo';
    	$auth=new Auth($accessKey, $secretKey);
    	$bucket='my-space';
    	$token = $auth->uploadToken($bucket);
    	$uploadMgr = new UploadManager();
    	//list($ret, $err) = $uploadMgr->put($token, null, 'content string');
    	list($ret, $err) = $uploadMgr->putFile($token, 'hello','/home/xufei/Dockerfile');
    	echo "\n====> put result: \n";
    	if ($err !== null) {
    		var_dump($err);
    	} else {
    		echo $ret['key'];
    	}
    }
    public function actionDownload(){
    	$accessKey='LsJtdgRp5sm2UXbF2HNhzn6ZzZpA11O7CAXGlJLS';
    	$secretKey='tfGAEgVEaQYJDLjMT1XAae1uznqCyZTVPlmcImpo';
    	$auth=new Auth($accessKey, $secretKey);

    	$baseUrl='http://my-space.qiniudn.com/hello';

    	$authUrl = $auth->privateDownloadUrl($baseUrl);
    	echo $authUrl;
    }
    
    public function actionToken(){
    	$accessKey='LsJtdgRp5sm2UXbF2HNhzn6ZzZpA11O7CAXGlJLS';
    	$secretKey='tfGAEgVEaQYJDLjMT1XAae1uznqCyZTVPlmcImpo';
    	$auth=new Auth($accessKey, $secretKey);
    	$bucket='my-space';
    	$token = $auth->uploadToken($bucket);
    	echo json_encode(array("uptoken"=>$token));
    }

    /**
     * Updates an existing app model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing app model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the app model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return app the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = app::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
