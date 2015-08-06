<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_015151_apptopicture extends Migration
{
    public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS apptopicture");
    	$this->createTable('apptopicture', [
    			'id' => Schema::TYPE_PK,
    			'appid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'picture' => Schema::TYPE_STRING . ' NOT NULL',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('apptopicture', 'apptopicture', 'appid', 'app', 'id','CASCADE','CASCADE');

    }

    public function safeDown()
    {
        //echo "m150625_015151_apptopicture cannot be reverted.\n";
		$this->dropForeignKey('apptopicture', 'apptopicture');
		$this->dropTable('apptopicture');
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
