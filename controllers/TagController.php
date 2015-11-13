<?php

namespace app\controllers;

use Yii;
use app\modules\v1\models\Tag;
use app\models\TagSearch;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\app\modules\v1\models;


/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
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
    	$model->commend=$model->commend?0:1;
    	//echo $model->authKey;
    	$model->save();
    	return $this->redirect(['index']);
    	//echo $id;
    }
    /**
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query=$dataProvider->query->andWhere(['=','second',''])->orderBy('commend desc');
       // $models=$searchModel->find()->where(['=','second',''])->orderBy('commend desc')->all();
		//$pagination = $dataProvider->getPagination ();
		//$dataProvider->setModels($models);
		//var_dump($pagination->pageCount);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexoftag()
    {
    	$searchModel = new TagSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$first= Yii::$app->request->queryParams['TagSearch']['first'];
    	$dataProvider->query = $dataProvider->query->andWhere(['>','second','']);
    	//$models=$searchModel->find()->where(['>','second',''])->all();
    	//$dataProvider->setModels($models);
    	return $this->render('index_tag', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			'first'=>$first,
    	]);
    }

    /**
     * Displays a single Tag model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model=$this->findModel($id);
    	$tags=Tag::find()->where('second>\'\' and first=:id',['id'=>$model->first])->all();
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         	'tags'=>$tags,
//         ]);
    	return $this->redirect(['indexoftag?TagSearch%5Bfirst%5D='.$model->first]);
    }
    public function actionViewoftag($id)
    {
    	$model=$this->findModel($id);
    	//$tags=Tag::find()->where('second>\'\' and first=:id',['id'=>$model->first])->all();
    	return $this->render('view_tag', [
    			'model' => $this->findModel($id)
    	]);
    }
    /**
     * Creates a new Tag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tag();
        //$data=Yii::$app->request->post();
        
        if ($model->load(Yii::$app->request->post())) {
        	    $model->commend=0;
        	    if($model->save()){
                 return $this->redirect(['index']);
        	    }
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateoftag($first)
    {
    	$model = new Tag();
    
    	if ($model->load(Yii::$app->request->post())) {
    		$model->first =$first;
    		$model->commend=0;
    		if($model->save())
    			return $this->redirect(['indexoftag?TagSearch%5Bfirst%5D='.$first]);
    		else 
    			return $this->render('create_tag', [
    					'model' => $model,
    					'first'=>$first,
    			]);
    	} else {
    		return $this->render('create_tag', [
    				'model' => $model,
    				'first'=>$first,
    		]);
    	}
    }
    /**
     * Updates an existing Tag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    
        $model = $this->findModel($id);
        $data=Yii::$app->request->post();
        if ($data!=false){
        $tag=new Tag();
        $tag->updateAll(['first'=>$data['Tag']['first']],'first=:first',['first'=>$model->first]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpdateoftag($id)
    {
    	$model = $this->findModel($id);
    
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['indexoftag?TagSearch%5Bfirst%5D='.$model->first]);
    	} else {
    		return $this->render('update_tag', [
    				'model' => $model,
    		]);
    	}
    }
    
    /**
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->first;
        $model=$this->findModel($id);
        $tags=Tag::deleteAll('first=:id',['id'=>$model->first]);
        //var_dump($tags);
        return $this->redirect(['index']);
    }

    public function actionDeleteoftag($id)
    {
    	$first=  $this->findModel($id)->first;
    	$this->findModel($id)->delete();
    
    	return $this->redirect(['indexoftag?TagSearch%5Bfirst%5D='.$first]);
    }
    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
