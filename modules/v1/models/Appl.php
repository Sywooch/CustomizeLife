<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "app".
 *
 * @property integer $id
 * @property string $name
 * @property string $version
 * @property string $android_url
 * @property string $ios_url
 * @property integer $stars
 * @property integer $downloadcount
 * @property string $introduction
 * @property string $updated_at
 * @property string $size
 * @property string $icon
 * @property string $updated_log
 * @property Appcomments[] $appcomments
 * @property Appofkind[] $appofkinds
 * @property Apptopicture[] $apptopictures
 * @property CollectPerson[] $collectPeople
 * @property Usertoapp[] $usertoapps
 */
class Appl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'version', 'android_url','ios_url', 'updated_at', 'icon'], 'required'],
            [['stars', 'downloadcount'], 'integer'],
            [['updated_at'], 'safe'],
            [['name', 'version', 'android_url','ios_url', 'introduction', 'size', 'icon','updated_log'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'version' => 'Version',
            'android_url' => 'android_url',
        	'ios_url' => 'Ios_url',
            'stars' => 'Stars',
            'downloadcount' => 'Downloadcount',
            'introduction' => 'Introduction',
            'updated_at' => 'Updated At',
            'size' => 'Size',
            'icon' => 'Icon',
        	'updated_log' => 'Updated log'
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
