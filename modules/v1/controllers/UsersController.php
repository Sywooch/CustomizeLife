<?php
namespace app\modules\v1\controllers;
use Yii;
use app\modules\v1\models\User;
use app\modules\v1\models\Friend;
use app\modules\v1\models\UserForm;
use app\modules\v1\models\Vercode;
use app\modules\v1\models\Message;
use app\modules\v1\models\Channel;
// use yii\web\Controller;
use yii\rest\Controller;
use app\modules\v1\models;
use app;
use yii\filters\AccessControl;
use app\modules\v1\models\Notify;
use app\modules\v1\models\Judge;
use Qiniu\Auth;
class UsersController extends Controller {
	public $enableCsrfValidation = false;
	
	public function actionSignup() {
		$model = new User ();
		$data = Yii::$app->request->post ();
		$model->pwd = md5 ( $data ['pwd'] );
		$model->phone = $data ['phone'];
		$userinfo = User::findOne ( [ 
				'phone' => $data ['phone'] 
		] );
		if ($userinfo&&$userinfo->blacklist==0) {
			$userinfo->pwd = md5 ( $data ['pwd'] );
			$userinfo->save ();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'change pwd success!' 
			) );
		} else if ($userinfo&&$userinfo->blacklist==1){
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Signup failed!'
			) );
		} else{
			$model->created_at = time ();
			$model->save ();
                        $myinfo = User::findOne ( [
                                'phone' => $data ['phone']
                        ] );
                        $friend=new Friend();
                        $friend->myid=$myinfo->id;
                        $friend->friendid=$myinfo->id;
                        $friend->isfriend='1';
                        $friend->save();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Signup success!' 
			) );
			// return 1;
			// return json_encode("sighup success");
		}
	}
	public function actionLogin() {
		$data=Yii::$app->request->post();
		$model=new User();
		$info=$model->findOne(['phone'=>$data['phone'],'pwd'=>md5($data['pwd'])]);
		if($info&&$info->blacklist==0){
			echo json_encode ( array (
			 						'flag' => 1,
			 						'msg' => 'Login success!'
			 				) );
		}else{
			echo json_encode ( array (
			 						'flag' => 0,
			 						'msg' => 'Login failed!'
			 				) );
		}
// 		$model = new UserForm ();
// 		if ($model->load ( Yii::$app->request->post (), '' )) {
// 			if ($model->login ()) {
// 				echo json_encode ( array (
// 						'flag' => 1,
// 						'msg' => 'Login success!' 
// 				) );
// 			} else {
// 				echo json_encode ( array (
// 						'flag' => 0,
// 						'msg' => 'Login failed!' 
// 				) );
// 			}
// 		}
	}
	public function actionLogout() {
		Yii::$app->user->logout ();
		echo json_encode ( array (
				'flag' => 1,
				'msg' => 'Logout success!' 
		) );
	}
	public function actionView() {
		// $response=Yii::$app->response;
		// $response->format=\yii\web\Response::FORMAT_JSON;
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = new User ();
		$data = Yii::$app->request->post ();
		$PersonInfo = $model->find ()->where ( [ 
				'phone' => $data ['phone'] 
		] )->one ();
		unset ( $PersonInfo ['updated_at'] );
		unset ( $PersonInfo ['pwd'] );
		unset ( $PersonInfo ['created_at'] );
		unset ( $PersonInfo ['authKey'] );
		unset ( $PersonInfo ['accessKey'] );
		return $PersonInfo;
	}
	public function actionGetinfo() {
		$data = Yii::$app->request->post ();
		// \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$userinfo = User::find ()->where ( [ 
				'phone' => $data ['starphone'] 
		] )->one ();
		// $userinfo['gender'] = 'man';
		// $userinfo->save();
		$response = Yii::$app->response;
		$response->format = \yii\web\Response::FORMAT_JSON;
		
		$my = User::find ()->where ( [ 
				'phone' => $data ['myphone'] 
		] )->one ();
		$friend = User::find ()->where ( [ 
				'phone' => $data ['starphone'] 
		] )->one ();
		
	
                $result = array ();	
		
	if($friend->famous==1){
			$colinfo = Friend::find ()->where ( [
					'myid' => $my->id,
					'friendid' => $friend->id,
					'isfriend' => '0'
					] )->one ();
			
			if ($colinfo) {
				$result['flag']="1";
			}else{
				$result['flag']="0";
			}
		}else{
			$colinfo = Friend::find ()->where ( [
					'myid' => $my->id,
					'friendid' => $friend->id,
					'isfriend' => '1'
					] )->one ();
			
			if ($colinfo) {
				$result['flag']="1";
			}else{
				$result['flag']="0";
			}
		}	
		
		unset ( $userinfo->pwd );
		// unset ( $userinfo->accessKey );
		unset ( $userinfo->authKey );
		unset ( $userinfo->created_at );
		unset ( $userinfo->updated_at );
		$result['user']=$userinfo;
		return $result;
	}
	public function actionGetmsg(){
		$data=Yii::$app->request->post();
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$phone=User::findOne([
				'phone'=>$data['phone']
		]);
		//$data = Message::find ()->select ( 'msg.id' )->join ( 'INNER JOIN', 'friends', ' msg.userid =friends.friendid and msg.userid = :id ', [':id' => Yii::$app->user->id ]);
		$m=new Message();
		$data = $m->find()->where([
				'userid'=>$phone['id']
		]);
		$pages = new \yii\data\Pagination ( [
				'totalCount' => $data->count (),
				'pageSize' => '10'
		] );
		$models = $data->orderBy("msg.created_at desc")->offset ( $pages->offset )->limit ( $pages->limit )->all ();
		$result = array ();
		$result['item']=array ();
		foreach ( $models as $model ) {
			$info=array();
			$infi['basic']=array();
			$info['basic']=$model;
			$info['apps'] = (new \yii\db\Query())->
			select ( [
					'app.*'
			] )->from ( 'msg' )->join ( 'INNER JOIN', 'app', 'msg.appid = app.id and msg.id = :id',[':id'=>$model ['id']])->all();
			$info['replys'] = (new \yii\db\Query())
			->select(['reply.*','user1.nickname as fromnickname','user1.phone as fromphone','user2.nickname as tonickname','user2.phone as tophone'])
			->from ( 'reply' )
			->join('INNER JOIN','user user1','user1.id = reply.fromid and reply.msgid= :id',[':id'=>$model ['id'] ])
			->join('Left JOIN','user user2','user2.id = reply.toid')
			->orderBy("reply.created_at")
			->all();
			$info['zan']=(new \yii\db\Query())
			->select('u.phone,u.nickname')->from('zan z')
			->join('INNER JOIN','user u','u.id=z.myid and z.msgid=:id',[':id'=>$model ['id'] ])
			->all();
			$result['item'][]=$info;
		}
		$result ['_meta'] = array (
				'pageCount' => $pages->pageCount,
				'currentPage' => $pages->page + 1
		);
		return $result;
	}
	public function actionModify() {
		$data = Yii::$app->request->post ();
		$count = User::updateAll ( array (
				'nickname' => $data ['nickname'],
				'thumb' => $data ['thumb'],
				'gender' => $data ['gender'],
				'area' => $data ['area'],
				'job' => $data ['job'],
				'hobby' => $data ['hobby'],
				'signature' => $data ['signature'],
				'updated_at' => time () 
		), 'phone=:ph', array (
				':ph' => $data ['phone'] 
		) );
		if ($count === 0) {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Modify failed!' 
			)
			 );
		} else {
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Modify success!' 
			) );
		}
	}
	/*
	 * public function actionForgetpwd(){ $model=new User(); $data=Yii::$app->request->post(); $userinfo=$model->find()->where(['email'=>$data['email']])->one(); if(!$userinfo) { return json_encode(array( "flag" => 0, "msg" => "The email has not been registered!" )); exit(); }else{ $getpasstime=time(); $id=$userinfo['id']; $token=md5($id . $userinfo['email'] . $userinfo['pwd']); $url="http://localhost/v1/users/resetpwd?email=" . $userinfo['email'] . "&token=" . $token; $time=date('Y-m-d H:i'); $mail=Yii::$app->mailer->compose() ->setFrom(["zhou544028616@163.com" => \Yii::$app->name . ' robot']) ->setTo($userinfo['email']) ->setSubject('密码修改通知') ->setTextBody("亲爱的" . $userinfo['email'] . ":您在" . $time . "提交了找回密码请求。 请点击下面的链接重置密码： $url"); if((!$mail->send())){ return json_encode(array( "flag"=>0, "msg"=>"Failed to send mail!" )); }else{ return json_encode(array( "flag"=>1, "msg"=>"Send success!" )); } } } public function actionResetpwd($email,$token){ $model=new User(); $data=Yii::$app->request->post(); $userinfo=$model->find()->where(['email'=>$email])->one(); if($userinfo){ $mt=md5($userinfo['id'] . $userinfo['email'] . $userinfo['pwd']); if($mt==$token){ if(isset($data['pwd'])){ $userinfo['pwd']=md5($data['pwd']); $userinfo->save(); return json_encode(array( "flag"=>1, "msg"=>"修改成功，请重新登录" )); exit(); }else{ return json_encode(array( "flag"=>0, "msg"=>"false change pwd！" )); exit(); } }else{ return json_encode(array( "flag"=>0, "msg"=>"false token" )); exit(); } }else{ return json_encode(array( "flag"=>0, "msg"=>"false url" )); exit(); } }
	 */
	public function actionSend() {
		$ph = Yii::$app->request->post ();
		
		$model = new User ();
		if ($model->find ()->where ( [ 
				'phone' => $ph ['phone'] 
		] )->one () && $ph['find']==0) {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Phone has been registered!' 
			) );
			return;
		}
		$output = "";
		for($i = 0; $i < 4; $i ++) {
			$output .= mt_rand ( 0, 9 );
		}
		$rest = new REST ();
		$apikey = '7d4294b4e224bd57377c85873b3e8430';
		$mobile = $ph ['phone'];
		$tpl_id=0;
		$tpl_value="";
		if($ph['find']==0){
			$tpl_id = 5; // 对应默认模板 【#company#】您的验证码是#code#
			$tpl_value = "#company#=我的APP&#app#=我的APP&#code#=" . $output;
		}else{
			$tpl_id = 7; // 对应默认模板 【#company#】您的验证码是#code#
			$tpl_value = "#company#=我的APP&#code#=" . $output;
		}
		// $rest->send_sms($apikey,$text, $mobile);
		$data = $rest->tpl_send_sms ( $apikey, $tpl_id, $tpl_value, $mobile );
		$obj = json_decode ( $data );
		if ($obj->msg === 'OK') {
			$model = new Vercode ();
			$model->phone = $ph ['phone'];
			$model->num = $output;
			$model->created_at = time ();
			$model->save ();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Send success!' 
			) );
		} else {
			var_dump ( $data );
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Send failed!' 
			) );
		}
	}
	public function actionVerify() {
		$data = Yii::$app->request->post ();
		
		$info = Vercode::find ()->select ( '*' )->where ( [ 
				'phone' => $data ['phone'] 
		] )->one ();
		
		if ($info === false) {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Verify failed!' 
			) );
		} else {
			if ($info ['num'] == $data ['num'] && time () - $info ['created_at'] <= 300) {
				Vercode::deleteAll ( [ 
						'phone' => $data ['phone'] 
				] );
				$model = new User ();
				$model->phone = $data ['phone'];
				$model->created_at = time ();
				if(!$model->save ()){
					echo json_encode ( array (
							'flag' => 0,
							'msg' => 'write in database failed!'
					) );
					return;
				}
				echo json_encode ( array (
						'flag' => 1,
						'msg' => 'Verify success!' 
				) );
			} else if (time () - $info ['created_at'] > 300) {
				Vercode::deleteAll ( [ 
						'phone' => $data ['phone'] 
				] );
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Verify failed!' 
				) );
			} else {
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Verify failed!' 
				) );
			}
		}
	}
	public function actionSearch(){
		
		$data=Yii::$app->request->post();
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model=new User();
		$myid=$model->find()->select('id')->from('user')->where(['phone'=>$data['myphone']])->one();
		$fid=$model->find()->select('*')->from('user')->where(['phone'=>$data['fphone']])->one();
		$model=new Friend();
// 		$info=$model->find()->where([
// 				'myid'=>$myid['id'],
// 				'friendid'=>$fid['id']
// 		]);
		$info=Friend::findOne([
				'myid'=>$myid['id'],
				'friendid'=>$fid['id']
		]);
		$ans=array();
		if($fid){
		$ans['id']=$fid['id'];
		$ans['phone']=$fid['phone'];
		$ans['thumb']=$fid['thumb'];
		$ans['nickname']=$fid['nickname'];
		$ans['gender']=$fid['gender'];
		$ans['area']=$fid['area'];
		$ans['job']=$fid['job'];
		$ans['hobby']=$fid['hobby'];
		$ans['signature']=$fid['signature'];
		if($info&&$info->isfriend==1){
			$ans['isfriend']=1;
		}else{
			$ans['isfriend']=0;
		}
		}else{
			$ans['id']='';
			$ans['phone']='';
			$ans['thumb']='';
			$ans['nickname']='';
			$ans['gender']='';
			$ans['area']='';
			$ans['job']='';
			$ans['hobby']='';
			$ans['signature']='';
			$ans['isfriend']=0;
		}
		return $ans;
	}
	public function actionNotify(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$data=Yii::$app->request->post();
		$phone=User::findOne(['phone'=>$data['phone']]);
		if(!$phone){
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Phone does not exist!'
			) );
			return;
		}
		$ans=(new \yii\db\Query())
		->select('nickname,phone,thumb,n.kind,n.created_at,m.id as msg_id,m.content,n.isread')->from('notify n')
		->join('INNER JOIN','user u','u.id=n.from and n.to=:id',[':id'=>$phone ['id'] ])
		->join('INNER JOIN', 'msg m','m.id=n.msg_id')
		->all();
		$dels=Notify::findAll(['to'=>$phone['id']]);
		foreach ($dels as $del){
			$del->isread=1;
			$del->save();
		}
		return $ans;
		
	}
	public function actionChannel(){
		$data=Yii::$app->request->post();
		$phone=User::findOne(['phone'=>$data['phone']]);
		$del=Channel::find(['userid'=>$phone['id']])->one();
		if($del)
			$del->delete();
		$model=new Channel();
		$model->userid=$phone->id;
		$model->channel=$data['channel'];
		$model->platform=$data['platform'];
		$model->updated_at=time();
		if($model->save()){
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Upload success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Upload failed!'
			) );
		}
	}
	
	public function actionJudge(){
		$data=Yii::$app->request->post();
		$phone=User::findOne(['phone'=>$data['phone']]);
		$model=new Judge();
		if ($data!=false){
			$model->userid=$phone->id;
			$model->message=$data['message'];
			$model->created_at=time();
			if($model->save()){
				echo json_encode ( array (
						'flag' => 1,
						'msg' => 'Judge success!'
				) );
			}else{
				echo json_encode ( array (
						'flag' => 0,
						'msg' => 'Judge failed!'
				) );
			}
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Judge failed!'
			) );
		}
	}
	public function actionSearchStar(){
	
		$data=Yii::$app->request->post();
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model=new User();
		$ans=$model->find()->select('*')->from('user')->where('famous=1')
		->andWhere(['like','nickname',$data['name']])->all();
		return $ans;
	}
	public function actionToken() {
		$accessKey = '6dnAU0jREe7QO0nD1ujr6CizVZ87HGhivNS1W9hR';
		$secretKey = 'RYuzaeIJDvFb8KOa9OSlsmlVs7j9A6oFbzwjh9Z0';
		$auth = new Auth ( $accessKey, $secretKey );
		$bucket = 'customizelife';
		$token = $auth->uploadToken ( $bucket );
		echo json_encode(array(
				'token'=>$token
		));
	}
}
class REST {
	// 模板接口样例（不推荐。需要测试请将注释去掉。)
	/*
	 * 以下代码块已被注释 $apikey = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"; //请用自己的apikey代替 $mobile = "xxxxxxxxxxx"; //请用自己的手机号代替 $tpl_id = 1; //对应默认模板 【#company#】您的验证码是#code# $tpl_value = "#company#=云片网&#code#=1234"; echo tpl_send_sms($apikey,$tpl_id, $tpl_value, $mobile);
	 */
	
	/**
	 * 通用接口发短信
	 * apikey 为云片分配的apikey
	 * text 为短信内容
	 * mobile 为接受短信的手机号
	 */
	function send_sms($apikey, $text, $mobile) {
		$url = "http://yunpian.com/v1/sms/send.json";
		$encoded_text = urlencode ( "$text" );
		$post_string = "apikey=$apikey&text=$encoded_text&mobile=$mobile";
		return $this->sock_post ( $url, $post_string );
	}
	
	/**
	 * 模板接口发短信
	 * apikey 为云片分配的apikey
	 * tpl_id 为模板id
	 * tpl_value 为模板值
	 * mobile 为接受短信的手机号
	 */
	function tpl_send_sms($apikey, $tpl_id, $tpl_value, $mobile) {
		$url = "http://yunpian.com/v1/sms/tpl_send.json";
		$encoded_tpl_value = urlencode ( "$tpl_value" ); // tpl_value需整体转义
		$post_string = "apikey=$apikey&tpl_id=$tpl_id&tpl_value=$encoded_tpl_value&mobile=$mobile";
		return $this->sock_post ( $url, $post_string );
	}
	
	/**
	 * url 为服务的url地址
	 * query 为请求串
	 */
	function sock_post($url, $query) {
		$data = "";
		$info = parse_url ( $url );
		$fp = fsockopen ( $info ["host"], 80, $errno, $errstr, 30 );
		if (! $fp) {
			return $data;
		}
		$head = "POST " . $info ['path'] . " HTTP/1.0\r\n";
		$head .= "Host: " . $info ['host'] . "\r\n";
		$head .= "Referer: http://" . $info ['host'] . $info ['path'] . "\r\n";
		$head .= "Content-type: application/x-www-form-urlencoded\r\n";
		$head .= "Content-Length: " . strlen ( trim ( $query ) ) . "\r\n";
		$head .= "\r\n";
		$head .= trim ( $query );
		$write = fputs ( $fp, $head );
		$header = "";
		while ( $str = trim ( fgets ( $fp, 4096 ) ) ) {
			$header .= $str;
		}
		while ( ! feof ( $fp ) ) {
			$data .= fgets ( $fp, 4096 );
		}
		return $data;
	}
}