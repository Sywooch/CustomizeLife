<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "reply".
 *
 * @property integer $id
 * @property integer $msgid
 * @property string $content
 * @property integer $fromid
 * @property integer $toid
 * @property integer $isread
 * @property integer $created_at
 *
 * @property User $from
 * @property Msg $msg
 * @property User $to
 */
class Reply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msgid', 'content', 'fromid', 'toid'], 'required'],
            [['msgid', 'fromid', 'toid', 'isread', 'created_at'], 'integer'],
            [['content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'msgid' => 'Msgid',
            'content' => 'Content',
            'fromid' => 'Fromid',
            'toid' => 'Toid',
            'isread' => 'Isread',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'fromid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMsg()
    {
        return $this->hasOne(Msg::className(), ['id' => 'msgid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
        return $this->hasOne(User::className(), ['id' => 'toid']);
    }
}
