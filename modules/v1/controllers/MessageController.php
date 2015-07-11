<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use app\modules\v1\models\Message;
use yii\data\ActiveDataProvider;

class MessageController extends ActiveController {
	public $modelClass = 'app\modules\v1\models\Message';
	public $serializer = [ 
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items' 
	];
	public function actions() {
		$actions = parent::actions ();
		unset ( $actions ['index'] );
		return $actions;
	}
	public function actionTest() {
		// $sql = "SELECT * FROM table WHERE cid=2 and status=1";
		$criteria = new CDbCriteria ();
		$result = $msg = Message::find ()->select ( 'msg.id' )->join ( 'INNER JOIN', 'friends', 'friends.friendid = msg.userid' )->where ( 'friends.myid=:id', [ 
				':id' => Yii::$app->user->id 
		] );
		$pages = new CPagination ( $result->rowCount );
		$pages->pageSize = 10;
		$pages->applyLimit ( $criteria );
		$result = $result->offset ( $pages->currentPage * $pages->pageSize )->limit ( $pages->pageSize );
		// $result=Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
		// $result->bindValue(':offset', $pages->currentPage*$pages->pageSize);
		// $result->bindValue(':limit', $pages->pageSize);
		$posts = $result->query ();
		return $posts->all ();
	}
	public function actionIndex() {
		$data = Message::find ()->select ( 'msg.id' )->join ( 'INNER JOIN', 'friends', 'friends.friendid = msg.userid' )->where ( 'friends.myid=:id', [ 
				':id' => Yii::$app->user->id 
		] );
		$pages = new \yii\data\Pagination ( [ 
				'totalCount' => $data->count (),
				'pageSize' => '3' 
		] );	
		$models = $data->offset ( $pages->offset )->limit ( $pages->limit )->all ();
		$result = array ();
		$result['item']=array ();
		foreach ( $models as $model ) {
			$msg = Message::find ()->where ( [ 
					'id' => $model ['id'] 
			] )->one ();
			$info=$msg->attributes;
			$info['apps'] = (new \yii\db\Query())->
			select ( [ 
					'msgtoapp.appid',
					'app.icon' 
			] )->from ( 'msgtoapp' )->join ( 'INNER JOIN', 'app', 'msgtoapp.appid = app.id and msgtoapp.msgid = :id',[':id'=>$model ['id']])->all();
			$info['replys'] = (new \yii\db\Query())->from ( 'reply' )->where(['reply.msgid'=>$model ['id'] ])->all();
			$result['item'][]=$info;
		}
		$result ['_meta'] = array (
				'pageCount' => $pages->pageCount,
				'currentPage' => $pages->page + 1 
		);
		return $result;
		// return $model;
	}
	public function actionSendMessage(){
		
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
	public function actionShow() {
		$msgs = Message::find ()->all ();
		return $msgs;
	}
	public function actionHello() {
		$response = Yii::$app->response;
		$response->format = \yii\web\Response::FORMAT_JSON;
		return "hello";
	}
}