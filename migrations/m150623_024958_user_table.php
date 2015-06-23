<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_024958_user_table extends Migration
{
    public function safeUp()
    {
    	$this->createTable('user', [
    		'id' => Schema::TYPE_PK,
    		'user' => Schema::TYPE_STRING . '(20) NOT NULL',
    		'pwd' => Schema::TYPE_STRING . ' NOT NULL',
    		'authKey' => Schema::TYPE_STRING . ' NOT NULL',
    		'accessKey' => Schema::TYPE_STRING . ' NOT NULL',
    		'nickname' => Schema::TYPE_STRING . '(20) ',
    		'thumb' => Schema::TYPE_STRING,
    		'email' => Schema::TYPE_STRING . ' NOT NULL',
    		'gender' => Schema::TYPE_STRING,
    		'area' => Schema::TYPE_STRING,
    		'job' => Schema::TYPE_STRING,
    		'hobby' => Schema::TYPE_STRING,
    		'signature' => Schema::TYPE_STRING,
    		'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    		'updated_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0'
    	],'ENGINE=InnoDB');
    	$this->createIndex('user', 'user', 'user',true);
    	$this->createIndex('email', 'user', 'email',true);

    }

    public function safeDown()
    {
        //echo "m150623_024958_user_table cannot be reverted.\n";
		$this->dropTable('user');
        //return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
