<?php

namespace app\controllers;

use Yii;
use app\modules\v1\models\User;
use app\models\StaruserSearch;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class StaruserController extends Controller
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
    
    public function actionRecom($id){
    	$model = $this->findModel($id);
    	//echo $model->authKey;
    	$model->authKey=$model->authKey?0:1;
    	//echo $model->authKey;
    	$model->save();
    	return $this->redirect(['index']);
    	//echo $id;
    }
    
    public function actionDown($id){
    	$model = $this->findModel($id);
    	//echo $model->authKey;
    	$model->famous=0;
    	//echo $model->authKey;
    	$model->save();
    	 
    	return $this->redirect(['index']);
    	//echo $id;
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaruserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query = $dataProvider->query->orderBy("authKey desc");
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    $model = new User();
        
        $data = Yii::$app->request->post ();
        // echo var_dump($data);
        if ($data != false) {
        	$model->pwd = md5($data ['User'] ['pwd']);
        	$model->shared = $data ['User'] ['shared'];
        	$model->follower = $data ['User'] ['follower'];
        	$model->favour = $data ['User'] ['favour'];
        	$model->area = $data ['User'] ['area'];
        	$model->gender = $data ['User'] ['gender'];
        	$model->hobby = $data ['User'] ['hobby'];
        	$model->nickname = $data ['User'] ['nickname'];
        	$model->phone = $data ['User'] ['phone'];
        	$model->signature = $data ['User'] ['signature'];
        	$model->created_at=time();
        	$model->updated_at=time();
        	$model->thumb = $data ['icon'];
        	$model->job=$data ['User'] ['job'];
        	$model->authKey=0;
        	
        	if ($model->save ()) {
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
     }
    	

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $data = Yii::$app->request->post ();
        // echo var_dump($data);
        if ($data != false) {
        	if ($data ['User'] ['pwd']!=false){
        		$model->pwd = md5($data ['User'] ['pwd']);
        	}
        	
        	$model->shared = $data ['User'] ['shared'];
        	$model->follower = 1;
        	$model->favour = $data ['User'] ['favour'];
        	$model->area = $data ['User'] ['area'];
        	$model->gender = $data ['User'] ['gender'];
        	$model->hobby = $data ['User'] ['hobby'];
        	$model->nickname = $data ['User'] ['nickname'];
        	$model->phone = $data ['User'] ['phone'];
        	$model->signature = $data ['User'] ['signature'];
        	//$model->created_at=time();
        	$model->updated_at=time();
        	$model->job=$data ['User'] ['job'];
        	
        	if(!empty($data ['icon'])){
        		$model->thumb =$data ['icon'];
        	}
        	
        	if ($model->save ()) {
        		return $this->redirect ( [
        				'view',
        				'id' => $model->id
        				] );
        	}
        } else {
        	unset($model->pwd);
        	return $this->render ( 'update', [
        			'model' => $model
        			] );
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}