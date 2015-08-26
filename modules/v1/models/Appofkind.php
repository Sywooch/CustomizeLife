<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "appofkind".
 *
 * @property integer $id
 * @property integer $appid
 * @property string $kind
 * @property integer $status
 *
 * @property App $app
 */
class Appofkind extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'appofkind';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appid'], 'required'],
            [['appid','status'], 'integer'],
            [['kind'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appid' => 'Appid',
            'kind' => 'Kind',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApp()
    {
        return $this->hasOne(App::className(), ['id' => 'appid']);
    }
}
