<?php

namespace app\models;

use Yii;

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
 * @property CollectInteract[] $collectInteracts
 * @property CollectPerson[] $collectPeople
 * @property Friends[] $friends
 * @property Friends[] $friends0
 * @property Msg[] $msgs
 * @property Reply[] $replies
 * @property Reply[] $replies0
 * @property Usertoapp[] $usertoapps
 */
class User extends \yii\db\ActiveRecord
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
            [['user', 'pwd', 'authKey', 'accessKey', 'email'], 'required'],
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
     * @return \yii\db\ActiveQuery
     */
    public function getCollectInteracts()
    {
        return $this->hasMany(CollectInteract::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectPeople()
    {
        return $this->hasMany(CollectPerson::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFriends()
    {
        return $this->hasMany(Friends::className(), ['friendid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFriends0()
    {
        return $this->hasMany(Friends::className(), ['myid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMsgs()
    {
        return $this->hasMany(Msg::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::className(), ['fromid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplies0()
    {
        return $this->hasMany(Reply::className(), ['toid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsertoapps()
    {
        return $this->hasMany(Usertoapp::className(), ['userid' => 'id']);
    }
}
