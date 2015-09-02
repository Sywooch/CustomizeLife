<?php

namespace app\controllers;

use Yii;
use app\modules\v1\models\Apptopicture;
use app\models\ApptopictureSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\app;

/**
 * ApptopictureController implements the CRUD actions for Apptopicture model.
 */
class ApptopictureController extends Controller
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
     * Lists all Apptopicture models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApptopictureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $pagination = $dataProvider->getPagination ();
        $count = $pagination->pageCount;
        $count1 = 0;
        while ( $categories = $dataProvider->models ) {
        	$models = $categories;
        	foreach ( $models as $model ) {
        		$appinfo = app::findOne ( [
        				'id' => $model ['appid']
        				] );
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
     * Displays a single Apptopicture model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel ( $id );
    	$appinfo = app::findOne ( [
    			'id' => $model ['appid']
    			] );
    	$model ['appid'] = $appinfo ['name'];
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Apptopicture model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Apptopicture();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Apptopicture model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data=Yii::$app->request->post();
        if($data!=false){
        	//$model->appid = $data['Apptopicture']['appid'];
        	$model->picture = $data['pic'][0];
        	//echo $data['apptopicture']['pic'][0];
        	if ($model->save()) {
        		return $this->redirect(['view', 'id' => $model->id]);
        	}else{
        		return $this->render('update', [
        				'model' => $model,
        		]);
        	}
        }else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Apptopicture model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $app=Apptopicture::findOne(['id' => $id]);
        $model->delete();
        return $this->redirect(['admin/update/'.$app->appid]);
    }

    /**
     * Finds the Apptopicture model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apptopicture the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apptopicture::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
