<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "follow".
 *
 * @property string $title
 * @property string $content
 * 
 *
 * @property User $my
 */
class Push extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'follow';
    }
	public $title;
	public $content;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['myid', 'followid'], 'required'],
            [['title', 'content'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
        ];
    }

}
