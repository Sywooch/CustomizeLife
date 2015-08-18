<?php

use yii\db\Schema;
use yii\db\Migration;

class m150818_111127_zan extends Migration
{
	public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS zan");
    	$this->createTable('zan', [
    			'id' => Schema::TYPE_PK,
    			'myid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'zanid' => Schema::TYPE_BIGINT . ' NOT NULL',
    			 
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('Zan', 'zan', 'myid', 'user', 'id','CASCADE','CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('My', 'zan');
        $this->dropTable('zan');
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
