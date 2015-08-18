<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "follow".
 *
 * @property integer $id
 * @property integer $myid
 * @property integer $followid
 *
 * @property User $my
 */
class Follow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'follow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['myid', 'followid'], 'required'],
            [['myid', 'followid'], 'integer']
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
            'followid' => 'Followid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMy()
    {
        return $this->hasOne(User::className(), ['id' => 'myid']);
    }
}
