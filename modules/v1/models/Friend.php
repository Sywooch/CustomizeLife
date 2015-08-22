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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['myid', 'friendid'], 'required'],
            [['myid', 'friendid', 'isfriend'], 'integer']
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
            'isfriend' => 'Isfriend',
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
