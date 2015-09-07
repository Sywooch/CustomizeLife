<?php

namespace app\controllers;

use Yii;
use app\models\Push;
use app\models\PushSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
require dirname ( __FILE__ ) . '/../vendor/pushserver/sdk.php';
use PushSDK;

/**
 * PushController implements the CRUD actions for Push model.
 */
class PushController extends Controller
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
     * Lists all Push models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PushSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Push model.
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
     * Creates a new Push model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Push();
        
        $allkind2 = (new \yii\db\Query ())->select('second distinct')->from('tag')->all();
        //var_dump($allkind2);
        $data=Yii::$app->request->post();
        if ($data != false) {
         	$model->load($data);
         	unset($model->label);
         	$model->created_at=time();

         	if ($data['Push']['label'][0]!="全部用户"){
	         	$like="";
	         	$users = (new \yii\db\Query ())->from('user')->join("INNER JOIN","channel","user.id=channel.userid");
	        	foreach ( $data['Push']['label'] as $label ) {
	        		$like.=$label." ";
	        		$users=$users->orWhere(['like','user.hobby',$label]);
	        	}
	        	$query=$users->all();
	            $model->label=$like;
	            if ($model->save()){
		            foreach ($query as $first){
		            		$this->push($first['channel'], $model->title, $model->message);
		            }
		            return $this->redirect(['index']);
	            }else{
	            	echo "<script language='javascript'>;alert('推送失败,请重新推送');</script>";
	            	return $this->render('create', [
	            	                'model' => $model,
	            	            	'allkind2' => $allkind2,
	            	            ]);
	            }
         	}else{
         		 $model->label="全部用户";
         		 if ($model->save()){
         		 		$this->pushtoall($model->title, $model->message);
         		 	return $this->redirect(['index']);
         		 }else{
         		 	echo "<script language='javascript'>;alert('推送失败,请重新推送');</script>";
         		 	return $this->render('create', [
         		 			'model' => $model,
         		 			'allkind2' => $allkind2,
         		 			]);
         		 }
         	}
        }else {
            return $this->render('create', [
                'model' => $model,
            	'allkind2' => $allkind2,
            ]);
        }
    }
    
    public function push($channel,$title,$message){
    	$sdk = new PushSDK ();
    	//$channelId = '4483825412066692748';
    	$optmessage = array (
    			// 消息的标题.
    			'title' => $title,
    			// 消息内容
    			'description' => $message
    	);
    	 
    	// 设置消息类型为 通知类型.
    	$opts = array (
    			'msg_type' => 1
    	);
    	 
    	// 向目标设备发送一条消息
    	$rs = $sdk->pushMsgToSingleDevice ( $channel, $optmessage, $opts );
    	//pushMsgToSingleDevice ( $channelId, $message, $opts );
    	 
    	// 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
//     	if ($rs === false) {
//     		echo "<script language='javascript'>;alert('推送失败');</script>";
//     		return $this->render ( 'create', [
//     				'model' => $model
//     				] );
//     	} else {
//     		echo "<script language='javascript'>;alert('推送成功');</script>";
//     		$model->title='';
//     		$model->content='';
//     		return $this->render ( 'create', [
//     				'model' => $model
//     				] );
//     	}
    }
    
    public function pushtoall($title,$message){
    	$sdk = new PushSDK ();
    	//$channelId = '4483825412066692748';
    	$optmessage = array (
    			// 消息的标题.
    			'title' => $title,
    			// 消息内容
    			'description' => $message
    	);
    
    	// 设置消息类型为 通知类型.
    	$opts = array (
    			'msg_type' => 1
    	);
    
    	// 向目标设备发送一条消息
    	$rs = $sdk->pushMsgToAll($optmessage, $opts);
    	//pushMsgToSingleDevice ( $channelId, $message, $opts );
    
    	// 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
    	//     	if ($rs === false) {
    	//     		echo "<script language='javascript'>;alert('推送失败');</script>";
    	//     		return $this->render ( 'create', [
    	//     				'model' => $model
    	//     				] );
    	//     	} else {
    	//     		echo "<script language='javascript'>;alert('推送成功');</script>";
    	//     		$model->title='';
    	//     		$model->content='';
    	//     		return $this->render ( 'create', [
    	//     				'model' => $model
    	//     				] );
    	//     	}
        }

    /**
     * Updates an existing Push model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Push model.
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
     * Finds the Push model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Push the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Push::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
