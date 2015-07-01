<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "app".
 *
 * @property integer $id
 * @property string $name
 * @property string $version
 * @property string $url
 * @property integer $stars
 * @property integer $downloadcount
 * @property string $introduction
 * @property string $updated_at
 * @property string $size
 * @property string $icon
 *
 * @property Appcomments[] $appcomments
 * @property Appofkind[] $appofkinds
 * @property Apptopicture[] $apptopictures
 * @property CollectPerson[] $collectPeople
 * @property Usertoapp[] $usertoapps
 */
class App extends \yii\db\ActiveRecord
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
            [['name', 'version', 'url', 'introduction', 'updated_at', 'size', 'icon'], 'required'],
            [['stars', 'downloadcount'], 'integer'],
            [['updated_at'], 'safe'],
            [['name', 'version', 'url', 'introduction', 'size', 'icon'], 'string', 'max' => 255]
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
            'url' => 'Url',
            'stars' => 'Stars',
            'downloadcount' => 'Downloadcount',
            'introduction' => 'Introduction',
            'updated_at' => 'Updated At',
            'size' => 'Size',
            'icon' => 'Icon',
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
