<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $pwd
 * @property integer $authKey
 * @property integer $famous
 * @property integer $shared
 * @property integer $follower
 * @property integer $favour
 * @property string $nickname
 * @property string $thumb
 * @property string $phone
 * @property string $gender
 * @property string $area
 * @property string $job
 * @property string $hobby
 * @property string $signature
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Appcomments[] $appcomments
 * @property CollectInteract[] $collectInteracts
 * @property CollectPerson[] $collectPeople
 * @property Follow[] $follows
 * @property Friends[] $friends
 * @property Friends[] $friends0
 * @property Msg[] $msgs
 * @property Reply[] $replies
 * @property Reqfriend[] $reqfriends
 * @property Reqfriend[] $reqfriends0
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
            [['phone'], 'required'],
            [['famous','authKey','shared', 'follower', 'favour', 'created_at', 'updated_at'], 'integer'],
            [['pwd',  'thumb', 'phone', 'gender', 'area', 'job', 'hobby', 'signature'], 'string', 'max' => 255],
            [['nickname'], 'string', 'max' => 20],
            [['phone'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pwd' => '密码',
            'authKey' => '是否推荐',
            'famous' => '是否明星',
            'shared' => '应用被分享次数',
            'follower' => '关注者数',
            'favour' => '被赞次数',
            'nickname' => '昵称',
            'thumb' => '头像',
            'phone' => '电话',
            'gender' => '性别',
            'area' => '地区',
            'job' => '工作',
            'hobby' => '爱好',
            'signature' => '签名',
            'created_at' => '注册时间',
            'updated_at' => '更新时间',
        ];
    }
    
    public function relations(){
    	return array(
    			'Friends' => array(self::HAS_ONE, 'Friend', 'friendid'),
    	);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppcomments()
    {
        return $this->hasMany(Appcomments::className(), ['userid' => 'id']);
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
    public function getFollows()
    {
        return $this->hasMany(Follow::className(), ['myid' => 'id']);
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
    public function getReqfriends()
    {
        return $this->hasMany(Reqfriend::className(), ['friendid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReqfriends0()
    {
        return $this->hasMany(Reqfriend::className(), ['myid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsertoapps()
    {
        return $this->hasMany(Usertoapp::className(), ['userid' => 'id']);
    }
}
