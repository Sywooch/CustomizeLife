<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\v1\models\CollectInteract;
use app\modules\v1\models\CollectPerson;
use app\modules\v1\models\Message;
use app\modules\v1\models\User;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

class CollectController extends Controller {
	public function actionSetMsg() {
		$data = Yii::$app->request->post ();
		$phone=User::findOne([
				'phone'=>$data['phone']
		]);
		$info=CollectInteract::findOne([
				'userid'=>$phone['id'],
				'msg'=>$data['msg']
		]);
		if($info){
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Already collect!'
			) );
			return;
		}
		$model = new CollectInteract ();
		$model->userid = $phone['id'];
		$model->msg = $data ['msg'];
		$model->created_at = time ();
		
		if($model->save ()){
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Collect success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Collect fail!'
			) );
		}
	}
	public function actionCancelMsg() {
		$data = Yii::$app->request->post ();
		$phone=User::findOne([
				'phone'=>$data['phone']
		]);
		$info=CollectInteract::findOne([
				'userid'=>$phone['id'],
				'msg'=>$data['msg']
		]);
		if($info){
			$info->delete();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Cancel collect success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Cancel collect fail!'
			) );
		}
	}
	public function actionSetApp() {
		$data = Yii::$app->request->post ();
		$phone=User::findOne([
				'phone'=>$data['phone']
		]);
		$info=CollectPerson::findOne([
				'userid'=>$phone['id'],
				'app'=>$data['app']
		]);
		if($info){
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Already collect!'
			) );
			return;
		}
		$model = new CollectPerson ();
		$model->userid = $phone['id'];
		$model->app = $data ['app'];
		$model->created_at = time ();
		
		if($model->save ()){
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Collect success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Collect fail!'
			) );
		}
	}
	public function actionCancelApp() {
		$data = Yii::$app->request->post ();
		$phone=User::findOne([
				'phone'=>$data['phone']
		]);
		$info=CollectPerson::findOne([
				'userid'=>$phone['id'],
				'app'=>$data['app']
		]);
		if($info){
			$info->delete();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Cancel collect success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Cancel collect fail!'
			) );
		}
	}
	public function actionGetApp() {
		$data = Yii::$app->request->post ();
		$phone=User::findOne([
				'phone'=>$data['phone']
		]);
		$query = (new \yii\db\Query ())->select ( 'app.*' )
		->from('collect_person c')
		->join ( 'LEFT JOIN', 'app', 'app.id=c.app' )->where ( [ 
				'c.userid' => $phone['id'] 
		] );
		
		$pages = new Pagination ( [ 
				'totalCount' => $query->count (),
				'pageSize' => '10' 
		] );
		$models = $query->offset ( $pages->offset )->limit ( $pages->limit )->all ();
		
		$result = array ();
		$result ['item'] = array ();
		foreach ( $models as $model ) {
			$result ['item'] [] = $model;
		}
		$result ['_meta'] = array (
				'pageCount' => $pages->pageCount,
				'currentPage' => $pages->page + 1 
		);
		
		return $result;
	}
	public function actionGetMsg() {
		$dat=Yii::$app->request->post();
		$phone=User::findOne([
				'phone'=>$dat['phone']
		]);
 		$data = (new \yii\db\Query ())->select ( 'u.phone,u.thumb,u.nickname,content,kind,m.area,c.created_at,msg' )->from('msg m')
 		->join ( 'LEFT JOIN', 'collect_interact c', 'm.id=c.msg' )
 		->join('LEFT JOIN','user u','u.id=m.userid')
 		->where ( [
 				'c.userid' => $phone['id']
 		] );
		//return $data;
		//$data = Message::find ()->select ( 'msg.id' )->join ( 'INNER JOIN', 'collect_interact', ' msg.id =collect_interact.msg and collect_interact.userid = :id ', [':id' => $phone['id'] ]);
		
		$pages = new \yii\data\Pagination ( [ 
				'totalCount' => $data->count(),
				'pageSize' => '10' 
		] );
 		$models = $data->orderBy("created_at desc")->offset ( $pages->offset )->limit ( $pages->limit )->all ();
 		$result = array ();
 		$result['item']=array ();
 		foreach ( $models as $model ) {
//  			$msg = (new \yii\db\Query())->select(['msg.*','user.nickname','user.thumb'])->from ('msg')
//  			->join('INNER JOIN', 'user','msg.userid = user.id and msg.id = :id',[':id'=>$model['id']])
//  			->one ();
 			//$info=$msg;
 			$info=$model;
 			$info['apps'] = (new \yii\db\Query())->
 			select ( [ 
 					'app.*'
 			] )->from ( 'msgtoapp' )->join ( 'INNER JOIN', 'app', 'msgtoapp.appid = app.id and msgtoapp.msgid = :id',[':id'=>$model ['msg']])->all();
 			$info['replys'] = (new \yii\db\Query())
 			->select(['reply.*','user1.nickname as fromnickname','user1.phone as fromphone','user2.nickname as tonickname','user2.phone as tophone'])
 			->from ( 'reply' )
 			->join('INNER JOIN','user user1','user1.id = reply.fromid and reply.msgid= :id',[':id'=>$model ['msg'] ])
 			->join('Left JOIN','user user2','user2.id = reply.toid')->orderBy("reply.created_at")->all();
 			$info['zan']=(new \yii\db\Query())
 			->select('u.phone,u.nickname')->from('zan z')
 			->join('INNER JOIN','user u','u.id=z.myid and z.msgid=:id',[':id'=>$model ['msg'] ])
 			->all();
 			$result['item'][]=$info;
 		}
 		$result ['_meta'] = array (
 				'pageCount' => $pages->pageCount,
 				'currentPage' => $pages->page + 1 
 		);
 		return $result;
	}
}