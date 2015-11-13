<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "hobby".
 *
 * @property integer $id
 * @property string $hobby
 */
class Hobby extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hobby';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hobby'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hobby' => '爱好',
        ];
    }
}
