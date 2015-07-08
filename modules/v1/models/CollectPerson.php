<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "collect_person".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $created_at
 * @property integer $app
 *
 * @property App $app0
 * @property User $user
 */
class CollectPerson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collect_person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'created_at', 'app'], 'required'],
            [['userid', 'created_at', 'app'], 'integer']
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
            'created_at' => 'Created At',
            'app' => 'App',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApp0()
    {
        return $this->hasOne(App::className(), ['id' => 'app']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
}
