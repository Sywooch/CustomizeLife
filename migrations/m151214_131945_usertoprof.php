<?php

use yii\db\Schema;
use yii\db\Migration;

class m151214_131945_usertoprof extends Migration
{
public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS usertoprof");
    	$this->createTable('usertoprof', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'profid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'created_at' =>Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->createIndex('usertoprof', 'usertoprof', 'userid');
    	$this->addForeignKey('usertoprofuserid', 'usertoprof', 'userid', 'user', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('usertoprofid', 'usertoprof', 'profid', 'profession', 'id','CASCADE','CASCADE');
    	 
    }

    public function down()
    {
        $this->dropForeignKey('usertoprofuserid', 'usertoprof');
        $this->dropForeignKey('usertoprofid', 'usertoprof');
		$this->dropTable('usertoprof');
    }
}
