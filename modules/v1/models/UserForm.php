<?php

namespace app\modules\v1\models;

use Yii;
use yii\base\Model;
use app\modules\v1\models\User;

class UserForm extends Model {
	public $email;
	public $pwd;
	public $verifyCode;
	private $_user = false;
	public function rules() {
		return [ 
				[ 
						[ 
								'email',
								'pwd' 
						],
						'required',
						'message' => '{attribute}不能为空！' 
				],
				[ 
						'email',
						'string',
						'max' => 50,
						'tooLong' => '{attribute}长度必需在100以内' 
				],
				[ 
						'pwd',
						'string',
						'max' => 32,
						'tooLong' => '{attribute}长度必需在32以内' 
				],
				[ 
						'pwd',
						'validatePassword',
						'message' => '账号或密码不正确！' 
				] 
		];
	}
	
	/**
	 * @
	 */
	public function attributeLabels() {
		return [ 
				'email' => '游戏',
				'pwd' => '密码',
				'verifyCode' => '验证' 
		];
	}
	
	/**
	 * @
	 */
	public function validatePassword($attribute, $params) {
		if (! $this->hasErrors ()) {
			$user = $this->getUser ();
			if (! $user) {
				$this->addError ( $attribute, '账号或密码不正确' );
			}
		}
	}
	
	/**YiiUser::find
	 * @根据用户名密码查询用户
	 */
	public function getUser() {
		if ($this->_user === false) {
			$this->_user = User::find ()->where ( [ 
					'email' => $this->email,
					'pwd' => md5 ( $this->pwd ) 
			] )->one ();
		}
		return $this->_user;
	}
	
	/**
	 * @用户登录
	 */
	public function login() {
		if ($this->validate ()) {
			return Yii::$app->user->login ( $this->getUser (), 3600 * 24 * 1 );
		} else {
			return false;
		}
	}
}
?>