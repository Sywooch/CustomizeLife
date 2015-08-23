<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "zan".
 *
 * @property integer $id
 * @property integer $myid
 * @property integer $msgid
 *
 * @property Msg $msg
 */
class Zan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['myid', 'msgid'], 'required'],
            [['myid', 'msgid'], 'integer']
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
            'msgid' => '消息ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMsg()
    {
        return $this->hasOne(Msg::className(), ['id' => 'msgid']);
    }
}
