<?php

namespace app\controllers;

use Yii;
use app\modules\v1\models\Msgtoapp;
use app\models\MsgtoappSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\app;
use app\controllers\MessageController;
/**
 * MsgtoappController implements the CRUD actions for Msgtoapp model.
 */
class MsgtoappController extends Controller
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
     * Lists all Msgtoapp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsgtoappSearch();
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
        		$model ['appicon'] = $appinfo['icon'];
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

    public function actionIndexofmsg()
    {
    	$searchModel = new MsgtoappSearch();
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
    			$model ['appicon'] = $appinfo['icon'];
    		}
    		$dataProvider->setModels ( $models );
    		$count1 ++;
    		if ($count1 > $count) {
    			break;
    		}
    	}
    
    	return $this->render('index_msg', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			'msgid'=>Yii::$app->request->queryParams['MsgtoappSearch']['msgid'],
    			]);
    }
    /**
     * Displays a single Msgtoapp model.
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
    public function actionViewofmsg($id)
    {
    	$model = $this->findModel ( $id );
    	$appinfo = app::findOne ( [
    			'id' => $model ['appid']
    			] );
    	$model ['appid'] = $appinfo ['name'];
    	return $this->render('view_msg', [
    			'model' => $model,
    			]);
    }
    /**
     * Creates a new Msgtoapp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Msgtoapp();

        $data = Yii::$app->request->post ();
		if ($data != false) {
			$appinfo = app::findOne ( [ 
					'name' => $data ['Msgtoapp']['appid'] 
			] );
			
			$model->appid=(string)$appinfo ['id'];
			$model->msgid=$data ['Msgtoapp']['msgid'];
			
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

    public function actionCreateofmsg($msgid)
    {
    	$model = new Msgtoapp();
    
    	$data = Yii::$app->request->post ();
    	//$msgid= $data['msgid'];
    	//return var_dump($msgid);
    	if ($data != false) {
    		$appinfo = app::findOne ( [
    				'name' => $data ['Msgtoapp']['appid']
    				] );
    		$model->appid=(string)$appinfo ['id'];
    		$model->msgid=$msgid;
    			
    		if ($model->save()) {
    			return $this->redirect(['indexofmsg?MsgtoappSearch%5Bmsgid%5D='.$msgid]);
    		} else {
    			return $this->render ( 'create_msg', [
    					'model' => $model,
    					'msgid' =>$msgid,
    					] );
    		}
    	}else{
    		return $this->render ( 'create_msg', [
    				'model' => $model,
    				'msgid' =>$msgid,
    				] );
    	}
    }
    /**
     * Updates an existing Msgtoapp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $appinfo = app::findOne ( [
        		'id' => $model ['appid']
        		] );
        $model ['appid'] = $appinfo ['name'];

        $data = Yii::$app->request->post ();
		if ($data != false) {
			$appinfo = app::findOne ( [ 
					'name' => $data ['Msgtoapp']['appid'] 
			] );
			
			$model->appid=(string)$appinfo ['id'];
			$model->msgid=$data ['Msgtoapp']['msgid'];
			
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

    public function actionUpdateofmsg($id)
    {
    	$model = $this->findModel($id);
    	$appinfo = app::findOne ( [
    			'id' => $model ['appid']
    			] );
    	$model ['appid'] = $appinfo ['name'];
    
    	$data = Yii::$app->request->post ();
    	if ($data != false) {
    		$appinfo = app::findOne ( [
    				'name' => $data ['Msgtoapp']['appid']
    				] );
    			
    		$model->appid=(string)$appinfo ['id'];
    		if ($model->save()) {
    			return $this->redirect(['indexofmsg?MsgtoappSearch%5Bmsgid%5D='.$model->msgid]);
    			return $this->redirect ( [
    					'view',
    					'id' => $model->id
    					] );
    		} else {
    			return $this->render ( 'update_msg', [
    					'model' => $model
    					] );
    		}
    	}else{
    		return $this->render ( 'update_msg', [
    				'model' => $model
    				] );
    	}
    }
    /**
     * Deletes an existing Msgtoapp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDeleteofmsg($id)
    {
    	$msgid = $this->findModel($id)->msgid;
    	$this->findModel($id)->delete();
    
    	return $this->redirect(['indexofmsg?MsgtoappSearch%5Bmsgid%5D='.$msgid]);
    }
    /**
     * Finds the Msgtoapp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Msgtoapp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Msgtoapp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
