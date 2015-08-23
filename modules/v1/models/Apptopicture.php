<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "apptopicture".
 *
 * @property integer $id
 * @property integer $appid
 * @property string $picture
 *
 * @property App $app
 */
class Apptopicture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apptopicture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appid', 'picture'], 'required'],
            [['appid'], 'integer'],
            [['picture'], 'string', 'max' => 255]
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
            'picture' => 'Picture',
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
