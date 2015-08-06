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
    			'userid' =>Schema::TYPE_INTEGER . ' NOT NULL',
    			'userthumb'=>Schema::TYPE_STRING,
    			'usernickname'=>Schema::TYPE_STRING,
    			'commentstars' => Schema::TYPE_INTEGER . ' DEFAULT 0',//0-5
    			'comments' => Schema::TYPE_STRING . ' NOT NULL',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    			'title' => Schema::TYPE_STRING . ' NOT NULL',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('appcommentsKey', 'appcomments', 'appid', 'app', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('appcommentssKey', 'appcomments', 'userid', 'user', 'id','CASCADE','CASCADE');

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
