<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "zan".
 *
 * @property integer $id
 * @property integer $myid
 * @property integer $zanid
 *
 * @property User $my
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
            [['myid', 'zanid'], 'required'],
            [['myid', 'zanid'], 'integer']
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
            'zanid' => 'Zanid',
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
