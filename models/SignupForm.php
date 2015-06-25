<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * SignupForm is the model behind the login form.
 */
class SignupForm extends Model
{
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['user', 'pwd', 'email'], 'required'],
            [['user', 'nickname'], 'string', 'max' => 20],
            [['pwd', 'authKey', 'accessKey', 'thumb', 'email', 'gender', 'area', 'job', 'hobby', 'signature'], 'string', 'max' => 255],
            [['user'], 'unique'],
            [['email'], 'unique'],
        	[['email'],'email']
        ];
    }
    public function signup()
    {
    	if ($this->validate()) {
    		$user = new User();
    		$user->user = $this->user;
    		$user->setPassword($this->password);
    		$user->email=$this->email;
    		$user->created_at = time();
    		if ($user->save()) {
    			return $user;
    		}
    	}
    
    	return null;
    }
}