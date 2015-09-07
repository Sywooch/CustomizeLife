<?php

use yii\db\Schema;
use yii\db\Migration;

class m150902_012840_judge extends Migration
{
//     public function up()
//     {

//     }

//     public function down()
//     {
//         echo "m150902_012840_judge cannot be reverted.\n";

//         return false;
//     }
    
    
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS judge");
    	$this->createTable('judge', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER,
    			'message'=>Schema::TYPE_STRING,
    			'created_at'=>Schema::TYPE_BIGINT,
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	//$this->addForeignKey('judge', 'judge', 'userid', 'user', 'id','CASCADE','CASCADE');
    }
    
    public function safeDown()
    {
    	//$this->dropForeignKey('judge', 'judge');
    	$this->dropTable('judge');
    }
   
}
