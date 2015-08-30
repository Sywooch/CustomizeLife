<?php

use yii\db\Schema;
use yii\db\Migration;

class m150827_135630_notify extends Migration
{
	public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS notify");
    	$this->createTable('notify', [
    			'id' => Schema::TYPE_PK,
    			'from' => Schema::TYPE_INTEGER,
    			'to' => Schema::TYPE_INTEGER,
    			'message'=>Schema::TYPE_STRING,
    			'created_at'=>Schema::TYPE_BIGINT,
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('fromsdf', 'notify', 'from', 'user', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('tosdf', 'notify', 'to', 'user', 'id','CASCADE','CASCADE');
    }

    public function safeDown()
    {
        //echo "m150623_125822_appofkind cannot be reverted.\n";
        $this->dropForeignKey('fromsdf', 'notify');
        $this->dropForeignKey('tosdf', 'notify');
		$this->dropTable('notify');
        //return false;
    }
}
