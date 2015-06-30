<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $email
 * @property string $pwd
 */
class YiiUser extends ActiveRecord implements IdentityInterface
{
	
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($this->isNewRecord) {
				$this->authKey = \Yii::$app->security->generateRandomString();
			}
			return true;
		}
		return false;
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @
     */
    public static function findIdentity($id)
    {
        //自动登陆时会调用
        $temp = parent::find()->where(['id'=>$id])->one();
        return isset($temp)?new static($temp):null;
    }

    /**
     * @
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * @
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *@
     */

    public  function  getUser(){
        return $this->user;
    }

    /**
     * @
     */
    public function getAuthKey()
    {
    	echo "getAuthKey";
        return $this->authKey;
    }

    /**
     * @
     */
    public function validateAuthKey($authKey)
    {
    	echo "validateAuthKey";
        return $this->authKey === $authKey;
    }

    /**
     * @
     */
    public function validatePassword($password)
    {
        return $this->pwd === $password;
    }




}
