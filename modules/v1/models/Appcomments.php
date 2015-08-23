<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "appcomments".
 *
 * @property integer $id
 * @property integer $appid
 * @property integer $userid
 * @property string $usernickname
 * @property integer $commentstars
 * @property string $comments
 * @property integer $created_at
 * @property string $title
 *
 * @property App $app
 */
class Appcomments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'appcomments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appid', 'comments', 'created_at', 'title'], 'required'],
            [['appid', 'commentstars', 'created_at'], 'string'],
            [['comments', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appid' => '应用',
            'userid'=>'用户',
            'usernickname'=>'用户昵称',
            'commentstars' => '评星',
            'comments' => '评论',
            'created_at' => '评论时间',
            'title' => '主题',
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
