<?php
namespace app\modules\v1\controllers;
use Yii;
use app\modules\v1\models\Usertoapp;
use app\modules\v1\models\Appl;
use app\modules\v1\models\User;
use app\modules\v1\models\Tag;
use yii\rest\Controller;
use app;
use app\modules\v1\models;
use yii\filters\AccessControl;
class MyappController extends Controller {
// 	public function actionDownload() {
// 		// \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
// 		$usertoapp = new Usertoapp ();
// 		// $user=new User();
// 		$appl = new Appl ();
// 		$data = Yii::$app->request->post ();
// 		if ($usertoapp->find ()->where ( [ 
// 				'userid' => $data ['userid'],
// 				'appid' => $data ['appid'] 
// 		] )->one ()) {
// 			echo json_encode ( array (
// 					'flag' => 0,
// 					'msg' => 'Already download!' 
// 			) );
// 			exit ();
// 		} else {
// 			/*$connection = \Yii::$app->db;
// 			$command = $connection->createCommand ( 'UPDATE app SET downloadcount=downloadcount+1 WHERE id=' . $data ['appid'] );
// 			$command->execute ();*/
// // 			$appinfo = $appl->find ()->where ( [ 
// // 					'id' => $data ['appid'] 
// // 			] )->one ();
// 			$appinfo=Appl::findOne([
// 					'id' => $data ['appid']
// 			]);
// 			$usertoapp->appid = $data ['appid'];
// 			$usertoapp->userid = $data ['userid'];
// 			$usertoapp->created_at = time ();
// 			$usertoapp->save ();
// 			$appinfo['downloadcount']=$appinfo['downloadcount']+1;
// 			$appinfo->save();
// 			return $appinfo;
// 		}
// 	}
	
	public function actionDownload() {
		$appl = new Appl ();
		$data = Yii::$app->request->post ();
		if (isset($data['phone'])){
			$userinfo=User::findOne([
					'phone'=>$data['phone']
			]);
			$userinfo['shared']+=1;
			$userinfo->save();
		} 
		$appinfo=Appl::findOne([
				'id' => $data ['appid']
		]);
		$appinfo['downloadcount']=$appinfo['downloadcount']+1;
	if($appinfo->save()){
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Failed!'
			) );
		}
	}
	
	public function actionDelete() {
		$usertoapp = new Usertoapp ();
		$data = Yii::$app->request->post ();
		$appl = new Appl ();
		$count = $usertoapp->find ()->where ( [ 
				'userid' => $data ['userid'],
				'appid' => $data ['appid'] 
		] )->one ();
		if ($count) {
			$count->delete ();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Success to delete your app!' 
			) );
		} else {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'You have not downloaded this app!' 
			) );
			exit ();
		}
	}
	public function actionTag() {
		$data=Yii::$app->request->post();
		$appl=new Appl();
	
		$ans= (new \yii\db\Query())->select('a.*')->from ( 'app a' )
		->join('INNER JOIN', 'apptoreltag ar','a.id=ar.appid')
		->join('INNER JOIN', 'reltag r','ar.tagid=r.id')
		->where ( [ 'like','tag',$data['tag']] )->all();
		
		return $ans;
	}
	public function actionLike(){
		$data=Yii::$app->request->post();
		$connection = \Yii::$app->db;
		//$aa = (new \yii\db\Query ())->select ( 'appid,name,icon' )->from ( 'usertoapp u' )->join ( 'LEFT JOIN', 'app a', 'u.appid=a.id' )->where ( [
		//		'userid' => $data['userid']
		//] )->all ();
		$model=new Appl();
		//$lin = $model->find()->select('id')->where(['phone'=>$data['phone']])->one();
		//$command = $connection->createCommand('SELECT `appid`, `name`, `icon` FROM `usertoapp` `u` LEFT JOIN `app` `a` ON u.appid=a.id WHERE (`userid`=' . $data['userid'] . ') AND (`appid`!=' . $data['appid'] . ')');
		//$aa = $command->queryAll();
// 		$ans=(new \yii\db\Query())
// 		->select('id,name,icon')
// 		->from('app')
// 		->limit(4)->all();
		$aa = (new \yii\db\Query ())->select ( '*' )->from ( 'usertoapp ua1' )
		->join ( 'LEFT JOIN', 'usertoapp ua2', 'ua1.userid=ua2.userid' )
		->join('LEFT JOIN','app a','a.id=ua2.appid')
		->where ( [
			 'ua1.appid' => $data['appid']
				] )->groupBy('a.id')
		->orderBy('a.downloadcount desc')
		->limit(6)
	    ->all ();
		return $aa;
	}
	public function actionGet(){
		$data=Yii::$app->request->post();
		$user=new User();
		$phone=$user->find()->select('id')->where(['phone'=>$data['phone']])->one();
		$aa = (new \yii\db\Query ())->select ( 'a.*' )->from ( 'usertoapp u' )
		->join('INNER JOIN','app a','a.id=u.appid')
		->where ('a.version >\'\' and u.userid=:id',['id'=>$phone['id']])
		->all ();
		return $aa;
	}
	public function actionTag8(){
		$model=new Tag();
		$tag=$model->find()->select('second')->from('tag')->where('second > \'\' and commend=1')->all();
		$ans=array();
		for($i=0;$i<count($tag);$i++){
			$ans[$i]=$tag[$i]['second'];
			
// 			$aa = (new \yii\db\Query ())->select ( 'a.*' )->from ( 'app a' )
// 			->join ( 'INNER JOIN', 'appofkind ak', 'a.id=ak.appid and ak.kind=:id',['id'=>$tag[$i]['second']] )
// 			->orderBy('a.downloadcount desc')
// 			->limit(3)
// 			->all ();
// 			$ans[$tag[$i]['second']]=$aa;
		}
		return $ans;
	}
	public function actionTagToApps(){
		$model=new Tag();
		$data=Yii::$app->request->post();
		//$tag=$model->find()->select('second')->from('tag')->where('second > \'\' and commend=1')->all();
		//return var_dump($data['tag'][0]);
		$ans=array();
		//var_dump($data);
		for($i=0;$i<count($data['tag']);$i++){
			//$ans[$i]=$tag[$i]['second'];
			$ans[$data['tag'][$i]]=array();
			$aa = (new \yii\db\Query ())->select ( 'a.*' )->from ( 'app a' )
			->where(['like','a.kind',$data['tag'][$i]])
			//->where('a.commend=1')
			->limit(3)
			->all ();
			$ans[$data['tag'][$i]]=$aa;
		}
		return $ans;
	}
	public function actionUpload(){
		$data=Yii::$app->request->post();
		$phone=User::findOne(['phone'=>$data['phone']]);
                $flag=1;
		foreach ($data['apps'] as $app){
		
                       if($data['platform']=='ios'){
				$a=Appl::findOne(['ios_url'=>$app]);
			}else{
				$a=Appl::findOne(['package'=>$app]);
			}	
                      if($a){
                        $flag=0;
			$model=new Usertoapp();
				$b=Usertoapp::findOne(['userid'=>$phone->id,'appid'=>$a->id]);
				if(!$b){
				$model->userid=$phone->id;
				$model->appid=$a->id;
				$model->created_at=time();
				if(!$model->save()){
					echo json_encode ( array (
							'flag' => 0,
							'msg' => 'Upload your app failed!'
					) );
					return;
				}
				}
                           }
			}
                if($flag==1){
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Upload your app failed!'
			) );
		}else{
		echo json_encode ( array (
							'flag' => 1,
							'msg' => 'Upload your app success!'
					) );
		}
	}
}
