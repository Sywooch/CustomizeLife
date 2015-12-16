<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "usertoprof".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $profid
 * @property integer $created_at
 *
 * @property Profession $prof
 * @property User $user
 */
class Usertoprof extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usertoprof';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'profid'], 'required'],
            [['userid', 'profid', 'created_at'], 'integer']
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
            'profid' => 'Profid',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProf()
    {
        return $this->hasOne(Profession::className(), ['id' => 'profid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
}
