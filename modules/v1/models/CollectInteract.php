<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "collect_interact".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $created_at
 * @property integer $msg
 *
 * @property User $user
 * @property Msg $msg0
 */
class CollectInteract extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collect_interact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'created_at', 'msg'], 'required'],
            [['userid', 'created_at', 'msg'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'created_at' => 'Created At',
            'msg' => 'Msg',
        ];
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
    public function getMsg0()
    {
        return $this->hasOne(Msg::className(), ['id' => 'msg']);
    }
}
