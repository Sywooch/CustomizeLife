<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "systemuser".
 *
 * @property integer $id
 * @property string $user
 * @property string $pwd
 */
class Systemuser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'systemuser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'pwd'], 'required'],
            [['user'], 'string', 'max' => 20],
            [['pwd'], 'string', 'max' => 255],
            [['user'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'pwd' => 'Pwd',
        ];
    }
}
