<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_084634_reply extends Migration
{
    public function safeUp()
    {
    	$this->createTable('reply', [
    			'id' => Schema::TYPE_PK,
    			'msgid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'fromid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'toid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'isread' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    	]);
    	$this->createIndex('reply-msgid', 'reply', 'msgid');
    	$this->addForeignKey('msgidKey', 'reply', 'msgid', 'msg', 'id','RESTRICT','CASCADE');
    	$this->addForeignKey('fromidKey', 'reply', 'fromid', 'user', 'id','RESTRICT','CASCADE');
    	$this->addForeignKey('toid', 'reply', 'toid', 'user', 'id','RESTRICT','CASCADE');

    }

    public function safeDown()
    {
        $this->dropTable('reply');
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
