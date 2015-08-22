<?php

use yii\db\Schema;
use yii\db\Migration;

class m150822_112405_tag extends Migration
{
 	public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS tag");
    	$this->createTable('tag', [
    			'id' => Schema::TYPE_PK,
    			'appid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'tag' => Schema::TYPE_STRING,
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('appoftagKey', 'tag', 'appid', 'app', 'id','CASCADE','CASCADE');
    }

    public function safeDown()
    {
        //echo "m150623_125822_appofkind cannot be reverted.\n";
        $this->dropForeignKey('appoftagKey', 'tag');
		$this->dropTable('tag');
        //return false;
    }
}
