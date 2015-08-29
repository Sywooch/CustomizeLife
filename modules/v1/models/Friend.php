<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "friends".
 *
 * @property integer $id
 * @property integer $myid
 * @property integer $friendid
 * @property integer $isfriend
 * @property string $friendnickname
 * @property string $friendicon
 *
 * @property User $friend
 * @property User $my
 */
class Friend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friends';
    }
	public $friendnickname;
	public $friendicon;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['myid', 'friendid'], 'required'],
            [['myid', 'friendid', 'isfriend'], 'integer'],
            [['friendnickname', 'friendicon'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'myid' => '用户',
            'friendid' => '对方用户',
            'isfriend' => '是否好友',
            'friendname' => '好友',
            'friendnickname'=>'对方昵称',
        ];
    }
    
    public function relations(){
    	return array(
    	'Users' => array(self::hasOne, 'User', 'friendid'),
    			);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFriend()
    {
        return $this->hasOne(User::className(), ['id' => 'friendid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMy()
    {
        return $this->hasOne(User::className(), ['id' => 'myid']);
    }
}
