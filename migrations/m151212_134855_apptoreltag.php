<?php

use yii\db\Schema;
use yii\db\Migration;

class m151212_134855_apptoreltag extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS apptoreltag");
    	$this->createTable('apptoreltag', [
    			'id' => Schema::TYPE_PK,
    			'appid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'tagid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'created_at' =>Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->createIndex('apptoreltag', 'apptoreltag', 'appid');
    	$this->addForeignKey('apptoreltagappid', 'apptoreltag', 'appid', 'app', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('apptoreltagid', 'apptoreltag', 'tagid', 'reltag', 'id','CASCADE','CASCADE');
    	 
    }

    public function down()
    {
        $this->dropForeignKey('apptoreltagappid', 'apptoreltag');
        $this->dropForeignKey('apptoreltagid', 'apptoreltag');
		$this->dropTable('apptoreltag');
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
