<?php

use yii\db\Schema;
use yii\db\Migration;

class m150818_111110_follow extends Migration
{
    public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS follow");
    	$this->createTable('follow', [
    			'id' => Schema::TYPE_PK,
    			'myid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'followid' => Schema::TYPE_BIGINT . ' NOT NULL',
    			 
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('my', 'follow', 'myid', 'user', 'id','CASCADE','CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('my', 'follow');
        $this->dropTable('follow');
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
