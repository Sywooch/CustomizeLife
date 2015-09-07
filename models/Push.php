<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "push".
 *
 * @property integer $id
 * @property string $title
 * @property string $message
 * @property string $label
 * @property integer $created_at
 */
class Push extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'push';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['title', 'message', 'label'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'message' => '消息',
            'label' => '标签',
            'created_at' => '推送时间',
        ];
    }
}
