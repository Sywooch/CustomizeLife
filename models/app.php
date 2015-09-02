<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app".
 *
 * @property integer $id
 * @property string $name
 * @property string $version
 * @property string $profile
 * @property string $android_url
 * @property string $ios_url
 * @property integer $stars
 * @property integer $downloadcount
 * @property integer $commentscount
 * @property string $introduction
 * @property string $updated_at
 * @property string $size
 * @property string $icon
 * @property string $updated_log
 * @property string $kind
 * @property string $package
 *
 * @property Appcomments[] $appcomments
 * @property Appofkind[] $appofkinds
 * @property Apptopicture[] $apptopictures
 * @property CollectPerson[] $collectPeople
 * @property Usertoapp[] $usertoapps
 */
class app extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app';
    }
	public $kind1array;
	public $kind2array;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'version', 'android_url', 'ios_url', 'introduction', 'updated_at', 'size', 'icon'], 'required'],
            [['stars', 'downloadcount', 'commentscount'], 'integer'],
            [['updated_at'], 'safe'],
            [['name', 'version', 'profile', 'android_url', 'ios_url', 'introduction', 'size', 'icon', 'updated_log', 'kind','package'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'version' => '版本',
            'profile' => '简介',
            'android_url' => 'Android应用地址',
            'ios_url' => 'Ios应用地址',
            'stars' => '评星',
            'downloadcount' => '下载次数',
            'commentscount' => '评论数量',
            'introduction' => '介绍',
            'updated_at' => '更新时间',
            'size' => '大小',
            'icon' => '图标',
            'updated_log' => '更新日志',
            'kind' => '标签',
        	'package'=>'包名',
        	'kind1array'=>'种类',
        	'kind2array'=>'标签',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppcomments()
    {
        return $this->hasMany(Appcomments::className(), ['appid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppofkinds()
    {
        return $this->hasMany(Appofkind::className(), ['appid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApptopictures()
    {
        return $this->hasMany(Apptopicture::className(), ['appid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectPeople()
    {
        return $this->hasMany(CollectPerson::className(), ['app' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsertoapps()
    {
        return $this->hasMany(Usertoapp::className(), ['appid' => 'id']);
    }
}
