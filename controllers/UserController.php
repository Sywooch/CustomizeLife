<?php

namespace app\controllers;

use Yii;
use app\modules\v1\models\User;
use app\models\UserSearch;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\modules\v1\models\Usertohobby;
use app\modules\v1\models\Hobby;
use app\modules\v1\models\Usertoprof;
use app\modules\v1\models\Profession;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
    
    
    public function actionUpgrade($id){
    	$model = $this->findModel($id);
    	//echo $model->authKey;
    	$model->famous=1;
    	//echo $model->authKey;
    	$model->save();
    	
    	return $this->redirect(['index']);
    	//echo $id;
    }
    
    public function actionBlacklist($id){
    	$model = $this->findModel($id);
    	//echo $model->authKey;
    	$model->blacklist=1;
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        
        $pagination = $dataProvider->getPagination ();
        $count = $pagination->pageCount;
        $count1 = 0;
        while ( $categories = $dataProvider->models ) {
        	$models = $categories;
        	foreach ( $models as $model ) {
        		$hobbyinfo=(new \yii\db\Query ())->select ( 'h.hobby' )->from ( 'usertohobby u' )
        		->join('INNER JOIN', 'hobby h','u.hobbyid=h.id')
        		->where ( [
        				'u.userid' => $model ['id']
        		] )->all();
        		$model['hobby']="";
        		if(count($hobbyinfo)>0){
        			foreach($hobbyinfo as $hobby){
        				$model['hobby']=$model['hobby'].$hobby['hobby']." ";
        			}
        		}
        		
        		
        		$profinfo=(new \yii\db\Query ())->select ( 'h.profession' )->from ( 'usertoprof u' )
        		->join('INNER JOIN', 'profession h','u.profid=h.id')
        		->where ( [
        				'u.userid' => $model ['id']
        		] )->all();
        		$model['job']="";
        		if(count($profinfo)>0){
        			foreach($profinfo as $prof){
        				$model['job']=$model['job'].$prof['profession']." ";
        			}
        		}
        		//$model ['reltag'] = $userinfo ['phone'];
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
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model=$this->findModel($id);
    	$hobbyinfo=(new \yii\db\Query ())->select ( 'h.hobby' )->from ( 'usertohobby u' )
    	->join('INNER JOIN', 'hobby h','u.hobbyid=h.id')
    	->where ( [
    			'u.userid' => $model ['id']
    	] )->all();
    	$model['hobby']="";
    	if(count($hobbyinfo)>0){
    		foreach($hobbyinfo as $hobby){
    			$model['hobby']=$model['hobby'].$hobby['hobby']." ";
    		}
    	}
    	
    	$profinfo=(new \yii\db\Query ())->select ( 'h.profession' )->from ( 'usertoprof u' )
    	->join('INNER JOIN', 'profession h','u.profid=h.id')
    	->where ( [
    			'u.userid' => $model ['id']
    	] )->all();
    	$model['job']="";
    	if(count($profinfo)>0){
    		foreach($profinfo as $prof){
    			$model['job']=$model['job'].$prof['profession']." ";
    		}
    	}
        return $this->render('view', [
            'model' =>$model ,
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
        	$model->follower = 0;
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
        	
        	if ($model->save ()) {
        		
        		$allhobby=trim($model->hobby);
        		$row=explode(" ",$allhobby);
        		foreach ($row as $hobby){
        			if(trim($hobby)==''){
        				continue;
        			}
        			$hobbymodel=new Hobby();
        			$one=$hobbymodel->find()->where(['hobby'=>$hobby])->one();
        		
        			$usertohobby=new Usertohobby();
        			$usertohobby->userid=$model->id;
        			$usertohobby->hobbyid=$one->id;
        			$usertohobby->save();
        		}
        		
        		$allprof=trim($model->job);
        		$row=explode(" ",$allprof);
        		foreach ($row as $prof){
        			if(trim($prof)==''){
        				continue;
        			}
        			$profmodel=new Profession();
        			$one=$profmodel->find()->where(['profession'=>$prof])->one();
        		
        			$usertoprof=new Usertoprof();
        			$usertoprof->userid=$model->id;
        			$usertoprof->profid=$one->id;
        			$usertoprof->save();
        		}
        		
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
        	$model->follower = 0;
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
        		Usertohobby::deleteAll(['userid'=>$id]);
        		
        		$allhobby=trim($model->hobby);
        		$row=explode(" ",$allhobby);
        		foreach ($row as $hobby){
        			if(trim($hobby)==''){
        				continue;
        			}
        			$hobbymodel=new Hobby();
        			$one=$hobbymodel->find()->where(['hobby'=>$hobby])->one();
        			$usertohobby=new Usertohobby();
        			$usertohobby->userid=$model->id;
        			$usertohobby->hobbyid=$one->id;
        			$usertohobby->save();
        		}
        		
        		Usertoprof::deleteAll(['userid'=>$id]);
        		$allprof=trim($model->job);
        		$row=explode(" ",$allprof);
        		foreach ($row as $prof){
        			if(trim($prof)==''){
        				continue;
        			}
        			$profmodel=new Profession();
        			$one=$profmodel->find()->where(['profession'=>$prof])->one();
        		
        			$usertoprof=new Usertoprof();
        			$usertoprof->userid=$model->id;
        			$usertoprof->profid=$one->id;
        			$usertoprof->save();
        		}
        		
        		return $this->redirect ( [
        				'view',
        				'id' => $model->id
        				] );
        	}
        } else {
        	unset($model->pwd);
        	$hobbyinfo=(new \yii\db\Query ())->select ( 'h.hobby' )->from ( 'usertohobby u' )
        	->join('INNER JOIN', 'hobby h','u.hobbyid=h.id')
        	->where ( [
        			'u.userid' => $model ['id']
        	] )->all();
        	$model['hobby']="";
        	if(count($hobbyinfo)>0){
        		foreach($hobbyinfo as $hobby){
        			$model['hobby']=$model['hobby'].$hobby['hobby']." ";
        		}
        	}
        	
        	$profinfo=(new \yii\db\Query ())->select ( 'h.profession' )->from ( 'usertoprof u' )
        	->join('INNER JOIN', 'profession h','u.profid=h.id')
        	->where ( [
        			'u.userid' => $model ['id']
        	] )->all();
        	$model['job']="";
        	if(count($profinfo)>0){
        		foreach($profinfo as $prof){
        			$model['job']=$model['job'].$prof['profession']." ";
        		}
        	}
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
