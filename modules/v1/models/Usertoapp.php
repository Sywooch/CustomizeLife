<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "usertoapp".
 *
 * @property integer $id
 * @property string $userid
 * @property string $appid
 * @property string $created_at
 *
 * @property App $app
 * @property User $user
 */
class Usertoapp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usertoapp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'appid'], 'required'],
            [['appid', 'created_at'], 'string'],
            [['userid',],'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => '用户',
            'appid' => '应用',
            'created_at' => '下载时间',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
}
