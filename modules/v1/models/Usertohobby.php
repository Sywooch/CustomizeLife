<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "usertohobby".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $hobbyid
 * @property integer $created_at
 *
 * @property Hobby $hobby
 * @property User $user
 */
class Usertohobby extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usertohobby';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'hobbyid'], 'required'],
            [['userid', 'hobbyid', 'created_at'], 'integer']
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
            'hobbyid' => 'Hobbyid',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHobby()
    {
        return $this->hasOne(Hobby::className(), ['id' => 'hobbyid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
}
