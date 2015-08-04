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
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpload(){
    	$accessKey='6dnAU0jREe7QO0nD1ujr6CizVZ87HGhivNS1W9hR';
    	$secretKey='RYuzaeIJDvFb8KOa9OSlsmlVs7j9A6oFbzwjh9Z0';
    	$auth=new Auth($accessKey, $secretKey);
    	$bucket='customizelife';
    	$token = $auth->uploadToken($bucket);
    	$uploadMgr = new UploadManager();
    	//list($ret, $err) = $uploadMgr->put($token, null, 'content string');
    	list($ret, $err) = $uploadMgr->putFile($token, 'hello','/home/dawei/2.jpg');
    	echo "\n====> put result: \n";
    	if ($err !== null) {
    		var_dump($err);
    	} else {
    		var_dump($ret);
    	}
    }
    public function actionDownload(){
    	$accessKey='6dnAU0jREe7QO0nD1ujr6CizVZ87HGhivNS1W9hR';
    	$secretKey='RYuzaeIJDvFb8KOa9OSlsmlVs7j9A6oFbzwjh9Z0';
    	$auth=new Auth($accessKey, $secretKey);
    	$baseUrl='http://7xkbeq.com1.z0.glb.clouddn.com/FkRvouCaQN6HmCyPmMuBd0OnhiOi';
    	$authUrl = $auth->privateDownloadUrl($baseUrl);
    	echo $authUrl;
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
