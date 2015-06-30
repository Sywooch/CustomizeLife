<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $user
 * @property string $pwd
 * @property string $authKey
 * @property string $accessKey
 * @property string $nickname
 * @property string $thumb
 * @property string $email
 * @property string $gender
 * @property string $area
 * @property string $job
 * @property string $hobby
 * @property string $signature
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Friends[] $friends
 * @property Friends[] $friends0
 * @property Msg[] $msgs
 * @property Reply[] $replies
 * @property Reply[] $replies0
 */

class User extends Model implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
    	return 'user';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
    	return [
    	[['pwd', 'authKey', 'accessKey', 'email'], 'required'],
    	[['created_at', 'updated_at'], 'integer'],
    	[['user', 'nickname'], 'string', 'max' => 20],
    	[['pwd', 'authKey', 'accessKey', 'thumb', 'email', 'gender', 'area', 'job', 'hobby', 'signature'], 'string', 'max' => 255],
    	[['user'], 'unique'],
    	[['email'], 'unique']
    	];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    	return [
    	'id' => 'ID',
    	'user' => 'User',
    	'pwd' => 'Pwd',
    	'authKey' => 'Auth Key',
    	'accessKey' => 'Access Key',
    	'nickname' => 'Nickname',
    	'thumb' => 'Thumb',
    	'email' => 'Email',
    	'gender' => 'Gender',
    	'area' => 'Area',
    	'job' => 'Job',
    	'hobby' => 'Hobby',
    	'signature' => 'Signature',
    	'created_at' => 'Created At',
    	'updated_at' => 'Updated At',
    	];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
