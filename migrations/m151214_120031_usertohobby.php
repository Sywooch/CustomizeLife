<?php

use yii\db\Schema;
use yii\db\Migration;

class m151214_120031_usertohobby extends Migration
{
public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS usertohobby");
    	$this->createTable('usertohobby', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'hobbyid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'created_at' =>Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->createIndex('usertohobby', 'usertohobby', 'userid');
    	$this->addForeignKey('usertohobbyuserid', 'usertohobby', 'userid', 'user', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('usertohobbyid', 'usertohobby', 'hobbyid', 'hobby', 'id','CASCADE','CASCADE');
    	 
    }

    public function down()
    {
        $this->dropForeignKey('usertohobbyuserid', 'usertohobby');
        $this->dropForeignKey('usertohobbyid', 'usertohobby');
		$this->dropTable('usertohobbyid');
    }
}
