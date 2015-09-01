<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "channel".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $channel
 * @property string $platform
 * @property integer $updated_at
 *
 * @property User $user
 */
class Channel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'updated_at'], 'integer'],
            [['channel', 'platform'], 'string', 'max' => 255]
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
            'channel' => 'Channel',
            'platform' => 'Platform',
            'updated_at' => 'Updated At',
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
