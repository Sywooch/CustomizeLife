<?php

namespace app\controllers;

use Yii;
use app\modules\v1\models\Friend;
use app\models\FriendSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\User;

/**
 * FriendController implements the CRUD actions for Friend model.
 */
class FriendController extends Controller
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
     * Lists all Friend models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FriendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $pagination = $dataProvider->getPagination ();
        $count = $pagination->pageCount;
        $count1 = 0;
        while ( $categories = $dataProvider->models ) {
        	$models = $categories;
        	foreach ( $models as $model ) {
        		$userinfo = User::findOne ( [
        				'id' => $model ['myid']
        				] );
        		$appinfo = User::findOne ( [
        				'id' => $model ['friendid']
        				] );
        		$model ['myid'] = $userinfo ['phone'];
        		$model ['friendid'] = $appinfo ['phone'];
        		$model ['friendnickname'] = $appinfo ['nickname'];
        		$model ['friendicon'] = $appinfo ['thumb'];
        		//$model ['']="sss";
        	}
        	$dataProvider->setModels ( $models );
        	$count1 ++;
        	if ($count1 > $count) {
        		break;
        	}
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Friend model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel ( $id );
    	$userinfo = User::findOne ( [
    			'id' => $model ['myid']
    			] );
    	$appinfo = User::findOne ( [
    			'id' => $model ['friendid']
    			] );
    	$model ['myid'] = $userinfo ['phone'];
    	$model ['friendid'] = $appinfo ['phone'];
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Friend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Friend();
        $data = Yii::$app->request->post ();
		if ($data != false) {
			$userinfo = User::findOne ( [ 
					'phone' => $data['Friend'] ['myid'] 
			] );
			$appinfo = User::findOne ( [ 
					'phone' => $data ['Friend']['friendid'] 
			] );
			
			$model->myid=(string)$userinfo ['id'];
			$model->friendid=$appinfo ['id'];
			$model->isfriend= $data ['Friend']['isfriend'];
			
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
     * Updates an existing Friend model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       $userinfo = User::findOne ( [
    			'id' => $model ['myid']
    			] );
    	$appinfo = User::findOne ( [
    			'id' => $model ['friendid']
    			] );
    	$model ['myid'] = $userinfo ['phone'];
    	$model ['friendid'] = $appinfo ['phone'];
		
		$data = Yii::$app->request->post ();
		if ($data != false) {
			$userinfo = User::findOne ( [ 
					'phone' => $data['Friend'] ['myid'] 
			] );
			$appinfo = User::findOne ( [ 
					'phone' => $data ['Friend']['friendid'] 
			] );
			
			$model->myid=(string)$userinfo ['id'];
			$model->friendid=$appinfo ['id'];
			$model->isfriend= $data ['Friend']['isfriend'];
				
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
     * Deletes an existing Friend model.
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
     * Finds the Friend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Friend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Friend::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
