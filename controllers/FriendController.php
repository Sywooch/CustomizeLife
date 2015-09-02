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
        	'myselfid' => Yii::$app->request->queryParams['FriendSearch']['myid'],
        ]);
    }
    
    public function actionIndexofall()
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
    			$model ['mynickname'] = $userinfo ['nickname'];
    			$model ['myicon'] = $userinfo ['thumb'];
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
    	return $this->render('index_all', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			//'myselfid' => Yii::$app->request->queryParams['FriendSearch']['myid'],
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
    	$model ['friendnickname'] = $appinfo ['nickname'];
    	$model ['friendicon'] = $appinfo ['thumb'];
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    
    public function actionViewall($id)
    {
    	$model = $this->findModel ( $id );
    	$userinfo = User::findOne ( [
    			'id' => $model ['myid']
    			] );
    	$appinfo = User::findOne ( [
    			'id' => $model ['friendid']
    			] );
    	$model ['myid'] = $userinfo ['phone'];
    	$model ['mynickname'] = $userinfo ['nickname'];
    	$model ['myicon'] = $userinfo ['thumb'];
    	$model ['friendid'] = $appinfo ['phone'];
    	$model ['friendnickname'] = $appinfo ['nickname'];
    	$model ['friendicon'] = $appinfo ['thumb'];
    	return $this->render('view_all', [
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
			$model ['friendnickname'] = $appinfo ['nickname'];
			$model ['friendicon'] = $appinfo ['thumb'];
			$model->isfriend= 1;
			
			if ($model->save()) {
				return $this->redirect ( [ 
						'viewall',
						'id' => $model->id 
				] );
			} else {
				return $this->render ( 'create_all', [ 
						'model' => $model 
				] );
			}
		}else{
			return $this->render ( 'create_all', [
					'model' => $model
					] );
		}
    }
    
    public function actionCreatefriend($myselfid)
    {
    	$model = new Friend();
    	$data = Yii::$app->request->post ();
    	if ($data != false) {
    		$userinfo = User::findOne ( [
    				'phone' => $myselfid
    				] );
    		$appinfo = User::findOne ( [
    				'phone' => $data ['Friend']['friendid']
    				] );
    			
    		$model->myid=(string)$userinfo ['id'];
    		$model->friendid=$appinfo ['id'];
    		$model->isfriend= 1;
    			
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
    	//$model ['myid'] = $userinfo ['phone'];
    	$model ['friendid'] = $appinfo ['phone'];
    	$model ['friendnickname'] = $appinfo ['nickname'];
    	$model ['friendicon'] = $appinfo ['thumb'];
		
		$data = Yii::$app->request->post ();
		if ($data != false) {
			
			$appinfo = User::findOne ( [ 
					'phone' => $data ['Friend']['friendid'] 
			] );
			
			//$model->myid=(string)$userinfo ['id'];
			$model->friendid=$appinfo ['id'];
			$model ['friendnickname'] = $appinfo ['nickname'];
			$model ['friendicon'] = $appinfo ['thumb'];
			$model->isfriend= 1;
				
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
    
    public function actionUpdateall($id)
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
    	$model ['friendnickname'] = $appinfo ['nickname'];
    	$model ['friendicon'] = $appinfo ['thumb'];
    
    	$data = Yii::$app->request->post ();
    	if ($data != false) {
    		$userinfo = User::findOne ( [
    				'phone' => $data ['Friend']['myid']
    				] );
    		$appinfo = User::findOne ( [
    				'phone' => $data ['Friend']['friendid']
    				] );
    			
    		$model->myid=(string)$userinfo ['id'];
    		$model->friendid=$appinfo ['id'];
    		//$model ['friendnickname'] = $appinfo ['nickname'];
    		//$model ['friendicon'] = $appinfo ['thumb'];
    		$model->isfriend= 1;
    
    		if ($model->save()) {
    			return $this->redirect ( [
    					'viewall',
    					'id' => $model->id
    					] );
    		} else {
    			return $this->render ( 'update_all', [
    					'model' => $model
    					] );
    		}
    	}else{
    		return $this->render ( 'update_all', [
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
        $model=$this->findModel($id);
        $model->delete();
        $user=User::findOne(['id' => $model->myid]);
        return $this->redirect(['index?FriendSearch%5Bmyid%5D='.$user->phone]);
    }
    
    public function actionDeleteall($id)
    {
    	$model=$this->findModel($id);
    	$model->delete();
    	$user=User::findOne(['id' => $model->myid]);
    	return $this->redirect(['indexofall']);
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
