<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_020444_usertoapp extends Migration
{
    public function safeUp()
    {
    	$this->createTable('usertoapp', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . 'NOT NULL',
    			'appid' => Schema::TYPE_INTEGER . ' NOT NULL',
    	],'ENGINE=InnoDB');
    	$this->createIndex('usertoapp', 'usertoapp', 'userid');

    }

    public function safeDown()
    {
        //echo "m150625_020444_usertoapp cannot be reverted.\n";
		$this->dropTable('usertoapp');
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
