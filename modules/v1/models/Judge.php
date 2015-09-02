<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "judge".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $message
 * @property integer $created_at
 *
 * @property User $user
 */
class Judge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'judge';
    }

    public $usernickname;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'created_at'], 'integer'],
            [['message'], 'string', 'max' => 255]
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
            'message' => '评价',
            'usernickname'=>'用户昵称',
            'created_at' => '评价时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
}
