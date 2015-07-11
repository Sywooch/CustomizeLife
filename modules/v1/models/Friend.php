<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "friends".
 *
 * @property string $id
 * @property integer $myid
 * @property integer $friendid
 */
class Friend extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'friends';
	}


}
