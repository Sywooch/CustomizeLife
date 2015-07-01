<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_133945_collect extends Migration
{
public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS collect_interact");
    	$this->createTable('collect_interact', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    			'msg' => Schema::TYPE_INTEGER . ' NOT NULL',
    			
    	],'ENGINE=InnoDB');
    	$this->addForeignKey('collectmsgKey', 'collect_interact', 'msg', 'msg', 'id','RESTRICT','CASCADE');
    	$this->addForeignKey('collectinteractKey', 'collect_interact', 'userid', 'user', 'id','RESTRICT','CASCADE');
    	$this->createTable('collect_person', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    			'app' => Schema::TYPE_INTEGER . ' NOT NULL',
    			 
    	],'ENGINE=InnoDB');
    	$this->addForeignKey('collectpersonKey', 'collect_person', 'userid', 'user', 'id','RESTRICT','CASCADE');
    	$this->addForeignKey('collectappKey', 'collect_person', 'app', 'app', 'id','RESTRICT','CASCADE');

    }

    public function safeDown()
    {
    	$this->dropForeignKey('collectappKey', 'collect_person');
    	$this->dropForeignKey('collectpersonKey', 'collect_person');
    	$this->dropForeignKey('collectmsgKey', 'collect_interact');
    	$this->dropForeignKey('collectinteractKey', 'collect_interact');
    	$this->dropTable('collect_person');
        $this->dropTable('collect_interact');
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
