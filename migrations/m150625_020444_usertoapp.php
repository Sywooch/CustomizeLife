<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_020444_usertoapp extends Migration
{
    public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS usertoapp");
    	$this->createTable('usertoapp', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'appid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'created_at' =>Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->createIndex('usertoapp', 'usertoapp', 'userid');
    	$this->addForeignKey('usertoappuserid', 'usertoapp', 'userid', 'user', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('usertoappappid', 'usertoapp', 'appid', 'app', 'id','CASCADE','CASCADE');

    }

    public function safeDown()
    {
        //echo "m150625_020444_usertoapp cannot be reverted.\n";
        $this->dropForeignKey('usertoappuserid', 'usertoapp');
        $this->dropForeignKey('usertoappappid', 'usertoapp');
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
