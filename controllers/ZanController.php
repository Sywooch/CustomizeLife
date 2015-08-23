<?php

namespace app\controllers;

use Yii;
use app\modules\v1\models\Zan;
use app\models\ZanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\User;

/**
 * ZanController implements the CRUD actions for Zan model.
 */
class ZanController extends Controller
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
     * Lists all Zan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZanSearch();
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
        		$model ['myid'] = $userinfo ['phone'];
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
     * Displays a single Zan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel ( $id );
    	$userinfo = User::findOne ( [
    			'id' => $model ['myid']
    			] );
    	
    	$model ['myid'] = $userinfo ['phone'];
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Zan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Zan();

       $data = Yii::$app->request->post ();
		if ($data != false) {
			$userinfo = User::findOne ( [ 
					'phone' => $data['Zan'] ['myid'] 
			] );
			
			$model->myid=(string)$userinfo ['id'];
			$model->msgid=$data['Zan'] ['msgid'];
			
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
     * Updates an existing Zan model.
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
         
        $model ['myid'] = $userinfo ['phone'];
        $data = Yii::$app->request->post ();
    if ($data != false) {
			$userinfo = User::findOne ( [ 
					'phone' => $data['Zan'] ['myid'] 
			] );
			
			$model->myid=(string)$userinfo ['id'];
			$model->msgid=$data['Zan'] ['msgid'];
			
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
     * Deletes an existing Zan model.
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
     * Finds the Zan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Zan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Zan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
