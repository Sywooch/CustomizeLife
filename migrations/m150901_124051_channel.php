<?php

use yii\db\Schema;
use yii\db\Migration;

class m150901_124051_channel extends Migration
{
	public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS channel");
    	$this->createTable('channel', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER,
    			'channel'=> Schema::TYPE_STRING,
    			'platform' => Schema::TYPE_STRING,
    			'updated_at'=>Schema::TYPE_BIGINT,
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('channelid', 'channel', 'userid', 'user', 'id','CASCADE','CASCADE');
    }

    public function safeDown()
    {
        //echo "m150623_125822_appofkind cannot be reverted.\n";
        $this->dropForeignKey('channelid', 'channel'); 
		$this->dropTable('channel');
        //return false;
    }
}
