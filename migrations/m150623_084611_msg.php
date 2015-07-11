<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_084611_msg extends Migration
{
    public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS msg");
    	$this->createTable('msg', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'content' => Schema::TYPE_STRING . ' NOT NULL',
    			'status' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',//0 share; 1 collect; 2 download.
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    	],"ENGINE=InnoDB");
    	$this->createIndex('userid', 'msg', 'userid');
    	$this->addForeignKey('msguserid', 'msg', 'userid', 'user', 'id','CASCADE','CASCADE');
    	$this->createTable('msgtoapp', [
    			'id' => Schema::TYPE_PK,
    			'msgid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'appid' => Schema::TYPE_INTEGER . ' NOT NULL',
    	],'ENGINE=InnoDB');
    	$this->addForeignKey('appid', 'msgtoapp', 'msgid', 'msg', 'id','CASCADE','CASCADE');
    	$this->createIndex('msgid', 'msgtoapp', 'msgid');
    }

    public function safeDown()
    {
    	$this->dropForeignKey('appid', 'msgtoapp');
    	$this->dropForeignKey('msguserid', 'msg');
    	$this->dropTable('msgtoapp');
        $this->dropTable('msg');
        
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
