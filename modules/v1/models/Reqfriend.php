<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "reqfriend".
 *
 * @property integer $id
 * @property integer $myid
 * @property integer $friendid
 *
 * @property User $friend
 * @property User $my
 */
class Reqfriend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reqfriend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['myid', 'friendid'], 'required'],
            [['myid', 'friendid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'myid' => 'Myid',
            'friendid' => 'Friendid',
        ];
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
