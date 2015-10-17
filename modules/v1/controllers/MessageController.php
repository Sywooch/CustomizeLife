<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use app\modules\v1\models\Message;
use app\modules\v1\models\Msgtoapp;
use app\modules\v1\models\User;
use app\modules\v1\models\Zan;
use app\modules\v1\models\Notify;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Reply;
use app\modules\v1\models\Appcomments;

require dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/../vendor/pushserver/sdk.php';
use PushSDK;
use app\modules\v1\models\Appl;

class MessageController extends ActiveController {
	public $modelClass = 'app\modules\v1\models\Message';
	public $serializer = [ 
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items' 
	];
	public function actions() {
		$actions = parent::actions ();
		unset ( $actions ['index'] );
		unset ( $actions ['view'] );
		return $actions;
	}
	// public function actionTest() {
	// // $sql = "SELECT * FROM table WHERE cid=2 and status=1";
	// $criteria = new CDbCriteria ();
	// $result = $msg = Message::find ()->select ( 'msg.id' )->join ( 'INNER JOIN', 'friends', 'friends.friendid = msg.userid and friends.myid=:id',[ ':id' => Yii::$app->user->id ] );
	// $pages = new CPagination ( $result->rowCount );
	// $pages->pageSize = 10;
	// $pages->applyLimit ( $criteria );
	// $result = $result->offset ( $pages->currentPage * $pages->pageSize )->limit ( $pages->pageSize );
	// // $result=Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
	// // $result->bindValue(':offset', $pages->currentPage*$pages->pageSize);
	// // $result->bindValue(':limit', $pages->pageSize);
	// $posts = $result->query ();
	// return $posts->all ();
	// }
	public function actionId() {
		$data = Yii::$app->request->post ();
		$id = $data ['id'];
		$msg = (new \yii\db\Query ())->select ( [ 
				'msg.*',
				'user.nickname',
				'user.thumb' 
		] )->from ( 'msg' )->join ( 'INNER JOIN', 'user', 'msg.userid = user.id and msg.id = :id', [ 
				':id' => $id 
		] )->one ();
		$info = $msg;
		$info['appkinds'] = explode(" ", $info['appkinds']);
		$info ['apps'] = (new \yii\db\Query ())->select ( [ 
				'app.*' 
		] )->from ( 'msgtoapp' )->join ( 'INNER JOIN', 'app', 'app.version>\'\' and msgtoapp.appid = app.id and msgtoapp.msgid = :id', [ 
				':id' => $id 
		] )->all ();
		$info ['replys'] = (new \yii\db\Query ())->select ( [ 
				'reply.*',
				'user1.nickname as fromnickname',
				'user1.phone as fromphone',
				'user2.nickname as tonickname',
				'user2.phone as tophone' 
		] )->from ( 'reply' )->join ( 'INNER JOIN', 'user user1', 'user1.id = reply.fromid and reply.msgid= :id', [ 
				':id' => $id 
		] )->join ( 'Left JOIN', 'user user2', 'user2.id = reply.toid' )->orderBy ( "reply.created_at" )->all ();
		$info['zan']=(new \yii\db\Query())
		->select('u.phone,u.nickname')->from('zan z')
		->join('INNER JOIN','user u','u.id=z.myid and z.msgid=:id',[':id'=>$id ])
		->all();
		return $info;
	}
	public function actionGet() {
		$data = Yii::$app->request->post ();
		$phone = User::findOne ( [ 
				'phone' => $data ['phone'] 
		] );
		// $data = Message::find ()->select ( 'msg.id' )->join ( 'INNER JOIN', 'friends', ' msg.userid =friends.friendid and msg.userid = :id ', [':id' => Yii::$app->user->id ]);
		$data = Message::find ()->select ( 'msg.id' )->join ( 'INNER JOIN', 'friends', ' msg.userid =friends.friendid and friends.myid = :id ', [ 
				':id' => $phone ['id'] 
		] );
// 		$pages = new \yii\data\Pagination ( [ 
// 				'totalCount' => $data->count (),
// 				'pageSize' => '10' 
// 		] );
		//$models = $data->orderBy ( "msg.created_at desc" )->offset ( $pages->offset )->limit ( $pages->limit )->all ();
		//$models = $data->orderBy ( "msg.created_at desc" )->limit ( $pages->limit )->all ();
		$models = $data->orderBy ( "msg.created_at desc" )->all ();
		$result = array ();
		$result ['item'] = array ();
		foreach ( $models as $model ) {
			$msg = (new \yii\db\Query ())->select ( [ 
					'msg.*',
					'user.nickname',
					'user.thumb' 
			] )->from ( 'msg' )->join ( 'INNER JOIN', 'user', 'msg.userid = user.id and msg.id = :id', [ 
					':id' => $model ['id'] 
			] )->one ();
			$info = $msg;
			$info['appkinds'] = explode(" ", $info['appkinds']);
			$info ['apps'] = (new \yii\db\Query ())->select ( [ 
					'app.*' 
			] )->from ( 'msgtoapp' )->join ( 'INNER JOIN', 'app', 'app.version>\'\' and msgtoapp.appid = app.id and msgtoapp.msgid = :id', [ 
					':id' => $model ['id'] 
			] )->all ();
			$info ['replys'] = (new \yii\db\Query ())->select ( [ 
					'reply.*',
					'user1.nickname as fromnickname',
					'user1.phone as fromphone',
					'user2.nickname as tonickname',
					'user2.phone as tophone' 
			] )->from ( 'reply' )->join ( 'INNER JOIN', 'user user1', 'user1.id = reply.fromid and reply.msgid= :id', [ 
					':id' => $model ['id'] 
			] )->join ( 'Left JOIN', 'user user2', 'user2.id = reply.toid' )->orderBy ( "reply.created_at" )->all ();
			$info['zan']=(new \yii\db\Query())
			->select('u.phone,u.nickname')->from('zan z')
			->join('INNER JOIN','user u','u.id=z.myid and z.msgid=:id',[':id'=>$model ['id'] ])
			->all();
			
			$result ['item'] [] = $info;
		}
// 		$result ['_meta'] = array (
// 				'pageCount' => $pages->pageCount,
// 				'currentPage' => $pages->page + 1 
// 		);
		return $result;
		// return $model;
	}
	public function actionSend() {
		$data = Yii::$app->request->post ();
		$msg = new Message ();
		$phone = User::findOne ( [ 
				'phone' => $data ['phone'] 
		] );
		// $msg->userid = Yii::$app->user->id;
		$msg->userid = $phone ['id'];
		$msg->content = $data ['content'];
		if(isset($data['kind'])){
		$msg->kind = $data ['kind'];
		}
		if(isset($data['area'])){
		$msg->area = $data ['area'];
		}
		$msg->created_at = time ();
		$msg->appstars = $data['appstarts'];
		$msg->appkinds = join(" ",$data['appkinds']);
		$err = $msg->save ();
		if ($err == false) {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Send fail!' 
			) );
			// throw new \yii\web\HttpException(404,"msg recode insert error");
		}
		foreach ( $data ['apps'] as $app ) {
			// echo $app;
			$msgtoapp = new Msgtoapp ();
			$msgtoapp->msgid = $msg->id;
			$msgtoapp->appid = $app ['id'];
			
			$err = $msgtoapp->save ();
			if ($err == false) {
				echo json_encode ( array (
						'flag' => 1,
						'msg' => 'Send fail!' 
				) );
				// throw new \yii\web\HttpException(404,"msgtoapp recode insert error");
			}
		}
		echo json_encode ( array (
				'flag' => 1,
				'msg' => 'Send success!' 
		) );
	}
	public function actionDeletemsg() {
		$data = Yii::$app->request->post ();
		$id = $data ['id'];
		$msg = new Message ();
		$msg = Message::find ()->where ( [ 
				'id' => $id 
		] )->one ();
		if ($msg == null) {
			// throw new \yii\web\NotFoundHttpException("record not found",401);
			//throw new \yii\web\HttpException ( 404, "recode not found" );
			// return "no record";
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Message do not exist!'
			) );
			return;
		}
		// $msg->id = $id;
		$err = $msg->delete ();
		if ($err == false) {
			//throw new \yii\web\HttpException ( 404, "recode delete error" );
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Delete failed!'
			) );
		} else {
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Delete success!' 
			) );
		}
	}
	public function actionZan() {
		$data = Yii::$app->request->post ();
		$user = new User ();
		$phone = $user->find ()->select ( 'id' )->where ( [ 
				'phone' => $data ['phone'] 
		] )->one ();
		$info = Zan::findOne ( [ 
				'myid' => $phone ['id'],
				'msgid' => $data ['msgid'] 
		] );
		if ($info) {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Already zan!' 
			) );
		} else {
			$model = new Zan ();
			$model->myid = $phone ['id'];
			$model->msgid = $data ['msgid'];
			$model->save ();
			$to=Message::findOne(['id'=>$data['msgid']]);
			$model2=new Notify();
			$model2->from=$phone['id'];
			$model2->to=$to['userid'];
			$model2->kind='点赞';
			$model2->created_at=time();
			$model2->msg_id=$data['msgid'];
			$model2->save();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Zan success!' 
			) );
		}
	}
	public function actionCancelZan() {
		$data = Yii::$app->request->post ();
		$user = new User ();
		$phone = $user->find ()->select ( 'id' )->where ( [ 
				'phone' => $data ['phone'] 
		] )->one ();
		$info = Zan::findOne ( [ 
				'myid' => $phone ['id'],
				'msgid' => $data ['msgid'] 
		] );
		if ($info) {
			$info->delete ();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Cancel success!' 
			) );
		} else {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Cancel failed!' 
			) );
		}
	}
	public function actionReply() {
		$data = Yii::$app->request->post ();
		$user=new User();
		$fromphone=$user->find()->select('id')->where(['phone'=>$data['fphone']])->one();
		$model=new Reply();
		if($data['tphone']==''){
			$model->toid=0;
		}else{
			$tophone=$user->find()->select('id')->where(['phone'=>$data['tphone']])->one();
			$model->toid=$tophone['id'];
		}
		$to=Message::findOne(['id'=>$data['msgid']]);
		if($fromphone['id']!=$to['id']){
			$model3=new Notify();
			$model3->from=$fromphone['id'];
			$model3->to=$to['userid'];
			//$model3->kind='评论';
			$model3->kind=$data['content'];
			$model3->created_at=time();
			$model3->msg_id=$data['msgid'];
			if(!$model3->save()){
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Reply failed!'
				));
				return;
			}
		}
		$model->fromid=$fromphone['id'];
		$model->msgid=$data['msgid'];
		$model->content=$data['content'];
		$model->isread=0;
		$model->created_at=time();
		
		if($model->save()){
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Reply success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Reply failed!'
					));
		}
	}
	public function actionBeforeSend(){
		$data=Yii::$app->request->post();
		$ans=array();
		foreach ($data['packages'] as $package){
			$ans[$package]=array();
			$app=Appl::findOne(['package'=>$package]);
			if($app){
				$ans[$package]['appid']=$app->id;
				$ans[$package]['exist']=1;
			}else{
				$ans[$package]['appid']=0;
				$ans[$package]['exist']=0;
			}
		}
		return $ans;
	}
	public function actionPush() {
		$sdk = new PushSDK ();
		$channelId = '4483825412066692748';
		$message = array (
				// 消息的标题.
				'title' => 'Hi!.',
				// 消息内容
				'description' => "杨老板卧槽" 
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
			print_r ( $sdk->getLastErrorCode () );
			print_r ( $sdk->getLastErrorMsg () );
		} else {
			// 将打印出消息的id,发送时间等相关信息.
			print_r ( $rs );
		}
		echo "done!";
	}
	public function actionTestl(){
		echo "sss";
		$dataProvider = new ActiveDataProvider ( [
		 'query' => Appcomments::find ()
				] );
		//$dataProvider->keys;
		//$dataProvider->models;
		/*$dataProvider->setPagination(false);
		$mymodel=$dataProvider->models;
		foreach ($mymodel as $model){
			echo $model['appid'];
			
		}*/
		$pagination = $dataProvider->getPagination();
		var_dump($pagination->page);
	    $count=0;
		while ($categories = $dataProvider->models){
			/*foreach ($categories as $model) {
				$model['appid']=0;
			}*/
			//echo $pagination->page=1+$count;
			$count++;
			$dataProvider->setPagination($count);
		}
		//$mymodel[4]['kind']="bbbbbb";
		//$dataProvider->setModels($mymodel);
		//var_dump($dataProvider->models[4]['kind']);
		//echo $dataProvider->models;
	}
}
