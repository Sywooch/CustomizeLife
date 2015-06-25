<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_015151_apptopicture extends Migration
{
    public function safeUp()
    {
    	$this->createTable('apptopicture', [
    			'id' => Schema::TYPE_PK,
    			'appid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'picture' => Schema::TYPE_STRING . ' NOT NULL',
    	],'ENGINE=InnoDB');
    	$this->addForeignKey('apptopicture', 'apptopicture', 'appid', 'app', 'id','RESTRICT','CASCADE');

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
