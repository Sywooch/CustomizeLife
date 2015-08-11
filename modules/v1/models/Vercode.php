<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "vercode".
 *
 * @property integer $id
 * @property string $phone
 * @property string $num
 * @property integer $created_at
 */
class Vercode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vercode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'num'], 'required'],
            [['created_at'], 'integer'],
            [['phone'], 'string', 'max' => 20],
            [['num'], 'string', 'max' => 255],
            [['phone'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'num' => 'Num',
            'created_at' => 'Created At',
        ];
    }
}
