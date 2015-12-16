<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "apptoreltag".
 *
 * @property integer $id
 * @property integer $appid
 * @property integer $tagid
 * @property integer $created_at
 *
 * @property App $app
 * @property Reltag $tag
 */
class Apptoreltag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apptoreltag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appid', 'tagid'], 'required'],
            [['appid', 'tagid', 'created_at'], 'integer']
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
            'tagid' => 'Tagid',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApp()
    {
        return $this->hasOne(App::className(), ['id' => 'appid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Reltag::className(), ['id' => 'tagid']);
    }
}
