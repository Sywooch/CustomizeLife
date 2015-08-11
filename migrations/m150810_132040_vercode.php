<?php

use yii\db\Schema;
use yii\db\Migration;

class m150810_132040_vercode extends Migration
{
    /* public function up()
    {

    }

    public function down()
    {
        
    }
     */
   
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS vercode");
    	$this->createTable('vercode', [
    			'id' => Schema::TYPE_PK,
    			'phone' => Schema::TYPE_STRING . '(20) NOT NULL',
    			'num' => Schema::TYPE_STRING . ' NOT NULL',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0'
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	//$this->createIndex('user', 'user', 'user',true);
    	$this->createIndex('phone', 'vercode', 'phone',true);
    }
    
    public function safeDown()
    {
    	$this->dropTable('vercode');
    }
   
}
