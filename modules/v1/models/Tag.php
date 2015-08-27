<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $first
 * @property string $second
 * @property integer $commend
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commend'], 'integer'],
            [['first'], 'string', 'max' => 50],
            [['second'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first' => 'First',
            'second' => 'Second',
            'commend' => 'Commend',
        ];
    }
}
