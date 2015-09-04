<?php

namespace app\controllers;

use Yii;
use app\modules\v1\models\Reply;
use app\models\ReplySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\User;
use app\models\Push;

require dirname ( __FILE__ ) . '/../vendor/pushserver/sdk.php';
use PushSDK;

/**
 * ReplyController implements the CRUD actions for Reply model.
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
     * Creates a new Reply model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Push();
        $data = Yii::$app->request->post ();
        if ($data != false) {
        	$model->title=$data['Push']['title'];
        	$model->content=$data['Push']['content'];
        	$sdk = new PushSDK ();
        	//$channelId = '4483825412066692748';
        	$message = array (
        			// 消息的标题.
        			'title' => $model->title,
        			// 消息内容
        			'description' => $model->content
        	);
        	
        	// 设置消息类型为 通知类型.
        	$opts = array (
        			'msg_type' => 1
        	);
        	
        	// 向目标设备发送一条消息
        	$rs = $sdk->pushMsgToAll($message, $opts);
        	//pushMsgToSingleDevice ( $channelId, $message, $opts );
        	
        	// 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
        	if ($rs === false) {
        		echo "<script language='javascript'>;alert('推送失败');</script>";
        		return $this->render ( 'create', [
        				'model' => $model
        				] );
        	} else {
        		echo "<script language='javascript'>;alert('推送成功');</script>";
        		$model->title='';
        	    $model->content='';
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
   
       
}
