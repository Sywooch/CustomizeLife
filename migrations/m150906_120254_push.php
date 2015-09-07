<?php

use yii\db\Schema;
use yii\db\Migration;

class m150906_120254_push extends Migration
{
//     public function up()
//     {

//     }

//     public function down()
//     {
//         echo "m150906_120254_push cannot be reverted.\n";

//         return false;
//     }
    
    
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS push");
    	$this->createTable('push', [
    			'id' => Schema::TYPE_PK,
    			'title' => Schema::TYPE_STRING,
    			'message'=>Schema::TYPE_STRING,
    			'label'=>Schema::TYPE_STRING,
    			'created_at'=>Schema::TYPE_BIGINT,
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }
    
    public function safeDown()
    {
    	$this->dropForeignKey('push', 'push');
    	$this->dropTable('push');
    }
   
}
