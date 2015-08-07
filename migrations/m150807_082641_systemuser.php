<?php

use yii\db\Schema;
use yii\db\Migration;

class m150807_082641_systemuser extends Migration
{
  /*  public function up()
    {

    }

    public function down()
    {
       
    }
    
     */
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS systemuser");
    	$this->createTable('systemuser', [
    			'id' => Schema::TYPE_PK,
    			'name' => Schema::TYPE_STRING . '(20) NOT NULL',
    			'pwd' => Schema::TYPE_STRING . ' NOT NULL',
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	//$this->createIndex('user', 'user', 'user',true);
    	$this->createIndex('name', 'systemuser', 'name',true);
    }
    
    
    public function safeDown()
    {
    	$this->dropTable('systemuser');
    }
   
}
