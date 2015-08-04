<?php

use yii\db\Schema;
use yii\db\Migration;

class m150711_053830_reqfriend extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS reqfriend");
    	$this->createTable('reqfriend', [
    			'id' => Schema::TYPE_PK,
    			'myid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'friendid' => Schema::TYPE_INTEGER . ' NOT NULL',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->createIndex('reqfriend', 'reqfriend', 'myid');
    	$this->addForeignKey('reqmyidKey', 'reqfriend', 'myid', 'user', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('reqfriendidKey', 'reqfriend', 'friendid', 'user', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        	$this->dropForeignKey('myidKey', 'reqfriend');
    	$this->dropForeignKey('friendidKey', 'reqfriend');
        $this->dropTable('reqfriend');
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
