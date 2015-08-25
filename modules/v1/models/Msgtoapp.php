<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "msgtoapp".
 *
 * @property integer $id
 * @property integer $msgid
 * @property integer $appid
 */
class Msgtoapp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msgtoapp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msgid', 'appid'], 'required'],
            [['msgid', 'appid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'msgid' => '消息ID',
            'appid' => '应用',
        ];
    }
}
