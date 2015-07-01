<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "usertoapp".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $appid
 * @property integer $created_at
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
            [['userid', 'appid', 'created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'appid' => 'Appid',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
}
