<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "reltag".
 *
 * @property integer $id
 * @property string $tag
 * @property integer $created_at
 */
class Reltag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reltag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['tag'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => '标签',
            'created_at' => '创建时间',
        ];
    }
}
