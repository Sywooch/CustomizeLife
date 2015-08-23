<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "msg".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $content
 * @property string $kind
 * @property string $area
 * @property integer $created_at
 *
 * @property CollectInteract[] $collectInteracts
 * @property User $user
 * @property Msgtoapp[] $msgtoapps
 * @property Reply[] $replies
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'content', 'created_at'], 'required'],
            [['userid', 'created_at'], 'integer'],
            [['content', 'area'], 'string', 'max' => 255],
            [['kind'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '消息ID',
            'userid' => '用户',
            'content' => '消息内容',
            'kind' => '种类',
            'area' => '可见范围',
            'created_at' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectInteracts()
    {
        return $this->hasMany(CollectInteract::className(), ['msg' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMsgtoapps()
    {
        return $this->hasMany(Msgtoapp::className(), ['msgid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::className(), ['msgid' => 'id']);
    }
}
