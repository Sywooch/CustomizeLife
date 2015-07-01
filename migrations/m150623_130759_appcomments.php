<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_130759_appcomments extends Migration
{
    public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS appcomments");
    	$this->createTable('appcomments', [
    			'id' => Schema::TYPE_PK,
    			'appid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'commentstars' => Schema::TYPE_INTEGER . ' DEFAULT 0',//0-5
    			'comments' => Schema::TYPE_STRING . ' NOT NULL',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    			'title' => Schema::TYPE_STRING . ' NOT NULL',
    	],'ENGINE=InnoDB');
    	$this->addForeignKey('appcommentsKey', 'appcomments', 'appid', 'app', 'id','RESTRICT','CASCADE');

    }

    public function safeDown()
    {
        //echo "m150623_130759_appcomments cannot be reverted.\n";
        $this->dropForeignKey('appcommentsKey', 'appcomments');
		$this->dropTable('appcomments');
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
