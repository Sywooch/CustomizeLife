<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "profession".
 *
 * @property integer $id
 * @property string $profession
 * @property integer $created_at
 */
class Profession extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profession';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['profession'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profession' => ' 职业',
            'created_at' => 'Created At',
        ];
    }
}
