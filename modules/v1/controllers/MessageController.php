<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use app\modules\v1\models\Message;
use app\modules\v1\models\Msgtoapp;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Reply;

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
// 	public function actionTest() {
// 		// $sql = "SELECT * FROM table WHERE cid=2 and status=1";
// 		$criteria = new CDbCriteria ();
// 		$result = $msg = Message::find ()->select ( 'msg.id' )->join ( 'INNER JOIN', 'friends', 'friends.friendid = msg.userid and friends.myid=:id',[ ':id' => Yii::$app->user->id ] );
// 		$pages = new CPagination ( $result->rowCount );
// 		$pages->pageSize = 10;
// 		$pages->applyLimit ( $criteria );
// 		$result = $result->offset ( $pages->currentPage * $pages->pageSize )->limit ( $pages->pageSize );
// 		// $result=Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
// 		// $result->bindValue(':offset', $pages->currentPage*$pages->pageSize);
// 		// $result->bindValue(':limit', $pages->pageSize);
// 		$posts = $result->query ();
// 		return $posts->all ();
// 	}
	public function actionId(){
		$data = Yii::$app->request->post ();
		$id = $data['id'];
		$msg = (new \yii\db\Query())->select(['msg.*','user.nickname','user.thumb'])->from ('msg')->join('INNER JOIN', 'user','msg.userid = user.id and msg.id = :id',[':id'=>$id])->one ();
		$info=$msg;
		$info['apps'] = (new \yii\db\Query())->
		select ( [
				'msgtoapp.appid',
				'app.icon'
				] )->from ( 'msgtoapp' )->join ( 'INNER JOIN', 'app', 'msgtoapp.appid = app.id and msgtoapp.msgid = :id',[':id'=>$id])->all();
		$info['replys'] = (new \yii\db\Query())->select(['reply.*','user1.nickname as fromnickname','user2.nickname as tonickname'])->from ( 'reply' )->join('INNER JOIN','user user1','user1.id = reply.fromid and reply.msgid= :id',[':id'=>$id ])->join('Left JOIN','user user2','user2.id = reply.toid')->orderBy("reply.created_at")->all();
		return $info;
	}
	public function actionIndex() {
		$data = Message::find ()->select ( 'msg.id' )->join ( 'INNER JOIN', 'friends', ' msg.userid =friends.friendid and msg.userid = :id ', [':id' => Yii::$app->user->id ]);
		$pages = new \yii\data\Pagination ( [ 
				'totalCount' => $data->count (),
				'pageSize' => '10' 
		] );
		$models = $data->orderBy("msg.created_at desc")->offset ( $pages->offset )->limit ( $pages->limit )->all ();
		$result = array ();
		$result['item']=array ();
		foreach ( $models as $model ) {
			$msg = (new \yii\db\Query())->select(['msg.*','user.nickname','user.thumb'])->from ('msg')->join('INNER JOIN', 'user','msg.userid = user.id and msg.id = :id',[':id'=>$model['id']])->one ();
			$info=$msg;
			$info['apps'] = (new \yii\db\Query())->
			select ( [ 
					'msgtoapp.appid',
					'app.icon' 
			] )->from ( 'msgtoapp' )->join ( 'INNER JOIN', 'app', 'msgtoapp.appid = app.id and msgtoapp.msgid = :id',[':id'=>$model ['id']])->all();
			$info['replys'] = (new \yii\db\Query())->select(['reply.*','user1.nickname as fromnickname','user2.nickname as tonickname'])->from ( 'reply' )->join('INNER JOIN','user user1','user1.id = reply.fromid and reply.msgid= :id',[':id'=>$model ['id'] ])->join('Left JOIN','user user2','user2.id = reply.toid')->orderBy("reply.created_at")->all();
			$result['item'][]=$info;
		}
		$result ['_meta'] = array (
				'pageCount' => $pages->pageCount,
				'currentPage' => $pages->page + 1 
		);
		return $result;
		// return $model;
	}
	public function actionSend(){
		$data = Yii::$app->request->post ();
		$msg = new Message();
		$msg->userid = Yii::$app->user->id;
		$msg->content = $data['content'];
		$msg->created_at = time();
		$err=$msg->save();
		if($err==false){
			throw new \yii\web\HttpException(404,"msg recode insert error");
		}
		foreach ($data['apps'] as $app) {
			//echo $app;
			$msgtoapp=new Msgtoapp();
			$msgtoapp->msgid=$msg->id;
			$msgtoapp->appid = $app['id'];
			$err=$msgtoapp->save();
			if($err==false){
				throw new \yii\web\HttpException(404,"msgtoapp recode insert error");
			}
		}
		return $data['apps'];
	}
	public function actionDeletemsg(){
		$data = Yii::$app->request->post();
		$id = $data['id'];
		$msg = new Message();
		$msg = Message::find()->where(['id'=>$id])->one();
		if($msg == null){
			//throw new \yii\web\NotFoundHttpException("record not found",401);
			throw new \yii\web\HttpException(404,"recode not found");
			//return "no record";
		}
		//$msg->id = $id;
		$err=$msg->delete();
		if($err==false){
			throw new \yii\web\HttpException(404,"recode delete error");
		}else{
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Delete success!' 
			) );
		}
	}
// 	public function actionIndex() {
// 		// echo Yii::$app->user->id;
// 		$msg = Message::find ()->select ( 'msg.id' )->join ( 'INNER JOIN', 'friends', 'friends.friendid = msg.userid' )->where ( 'friends.myid=:id', [ 
// 				':id' => Yii::$app->user->id 
// 		] )->orderBy ( 'msg.created_at' )->all ();
// 		// return $msg;
// 		$activeData = new ActiveDataProvider ( [ 
// 				'query' => Message::find ()->where ( 'userid=:id', [ 
// 						':id' => Yii::$app->user->id 
// 				] ),
// 				'pagination' => [ 
// 						'defaultPageSize' => 10 
// 				] 
// 		] );
// 		return $activeData;
// 	}
// 	public function actionShow() {
// 		$msgs = Message::find ()->all ();
// 		return $msgs;
// 	}
// 	public function actionHello() {
// 		$response = Yii::$app->response;
// 		$response->format = \yii\web\Response::FORMAT_JSON;
// 		return "hello";
// 	}
	
	public function actionReply(){
		$data = Yii::$app->request->post ();
		$model=new Reply();
		$model->fromid=$data['fromid'];
		$model->toid=$data['toid'];
		$model->msgid=$data['msgid'];
		$model->content=$data['content'];
		$model->isread=false;
		$model->created_at=time();
		$model->save();
	}
	
	
}
