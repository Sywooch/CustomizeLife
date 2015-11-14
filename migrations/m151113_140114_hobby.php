<?php

use yii\db\Schema;
use yii\db\Migration;

class m151113_140114_hobby extends Migration
{
    
 public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS hobby");
    	$this->createTable('hobby', [
    			'id' => Schema::TYPE_PK,
    			'hobby' => Schema::TYPE_STRING,
    			'created_at'=>Schema::TYPE_BIGINT,
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }
    
    public function safeDown()
    {
    	$this->dropTable('hobby');
    }
}
