<?php

namespace app\controllers;

use Yii;
use app\modules\v1\models\Reply;
use app\models\ReplySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\User;

/**
 * ReplyController implements the CRUD actions for Reply model.
 */
class ReplyController extends Controller
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
     * Lists all Reply models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReplySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $pagination = $dataProvider->getPagination ();
        $count = $pagination->pageCount;
        $count1 = 0;
        while ( $categories = $dataProvider->models ) {
        	$models = $categories;
        	foreach ( $models as $model ) {
        		$userinfo = User::findOne ( [
        				'id' => $model ['fromid']
        				] );
        		if ($model ['toid']==0){
        			$model ['fromid'] = $userinfo ['phone'];
        			$model ['toid'] = '直接回复消息';
        		}else{
        			$appinfo = User::findOne ( [
        					'id' => $model ['toid']
        					] );
        			$model ['fromid'] = $userinfo ['phone'];
        			$model ['toid'] = $appinfo ['phone'];
        		}
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
     * Displays a single Reply model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel ( $id );
    	$userinfo = User::findOne ( [
    			'id' => $model ['fromid']
    			] );
    	if ($model ['toid']==0){
    		$model ['fromid'] = $userinfo ['phone'];
    		$model ['toid'] = '直接回复消息';
    	}else{
    		$appinfo = User::findOne ( [
    				'id' => $model ['toid']
    				] );
    		$model ['fromid'] = $userinfo ['phone'];
    		$model ['toid'] = $appinfo ['phone'];
    	}
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Reply model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reply();

        $data = Yii::$app->request->post ();
        if ($data != false) {
        	$userinfo = User::findOne ( [
        			'phone' => $data['Reply'] ['fromid']
        			] );
        	if($data ['Reply']['toid']=='直接回复消息'){
        		$model->toid=0;
        	}else{
        		$appinfo = User::findOne ( [
        				'name' => $data ['Reply']['toid']
        				] );
        		$model->toid=$appinfo['id'];
        	}
        	
        	$model->msgid=$data['Reply'] ['msgid'];
        	$model->fromid=$userinfo ['id'];
        	$model->created_at=(string)time();
        	$model->isread=$data ['Reply']['isread'];
        	$model->content=$data ['Reply']['content'];
        		
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
     * Updates an existing Reply model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userinfo = User::findOne ( [
        		'id' => $model ['fromid']
        		] );
        if ($model ['toid']==0){
        	$model ['fromid'] = $userinfo ['phone'];
        	$model ['toid'] = '直接回复消息';
        }else{
        	$appinfo = User::findOne ( [
        			'id' => $model ['toid']
        			] );
        	$model ['fromid'] = $userinfo ['phone'];
        	$model ['toid'] = $appinfo ['phone'];
        }
     $data = Yii::$app->request->post ();
        if ($data != false) {
        	$userinfo = User::findOne ( [
        			'phone' => $data['Reply'] ['fromid']
        			] );
        	if($data ['Reply']['toid']=='直接回复消息'){
        		$model->toid=0;
        	}else{
        		$appinfo = User::findOne ( [
        				'name' => $data ['Reply']['toid']
        				] );
        		$model->toid=$appinfo['id'];
        	}
        	
        	$model->msgid=$data['Reply'] ['msgid'];
        	$model->fromid=$userinfo ['id'];
        	$model->created_at=(string)time();
        	$model->isread=$data ['Reply']['isread'];
        	$model->content=$data ['Reply']['content'];
        		
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
     * Deletes an existing Reply model.
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
     * Finds the Reply model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reply the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reply::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
