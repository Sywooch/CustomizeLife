<?php

namespace app\controllers;

use Yii;
use app\modules\v1\models\Usertoapp;
use app\models\UsertoappSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\User;
use app\models\app;

/**
 * UsertoappController implements the CRUD actions for Usertoapp model.
 */
class UsertoappController extends Controller
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
     * Lists all Usertoapp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsertoappSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usertoapp model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel ( $id );
    	$userinfo = User::findOne ( [
    			'id' => $model ['userid']
    			] );
    	$appinfo = app::findOne ( [
    			'id' => $model ['appid']
    			] );
    	$model ['userid'] = $userinfo ['phone'];
    	$model ['appid'] = $appinfo ['name'];
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Usertoapp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usertoapp();

        $data = Yii::$app->request->post ();
        if ($data != false) {
        	$userinfo = User::findOne ( [
        			'phone' => $data['Usertoapp'] ['userid']
        			] );
        	$appinfo = app::findOne ( [
        			'name' => $data ['Usertoapp']['appid']
        			] );
        		
        	$model->appid=(string)$appinfo ['id'];
        	$model->userid=$userinfo ['id'];
        	$model->created_at=(string)time();
        	
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
     * Updates an existing Usertoapp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

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
					'phone' => $data['Usertoapp'] ['userid']
					] );
			$appinfo = app::findOne ( [
					'name' => $data ['Usertoapp']['appid']
					] );
				
			$model->appid=(string)$appinfo ['id'];
			$model->userid=$userinfo ['id'];
			$model->created_at=(string)time();
			
				
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
     * Deletes an existing Usertoapp model.
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
     * Finds the Usertoapp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usertoapp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usertoapp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
