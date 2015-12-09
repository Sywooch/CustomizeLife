<?php

use yii\db\Schema;
use yii\db\Migration;

class m151209_121716_profession extends Migration
{
public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS profession");
    	$this->createTable('profession', [
    			'id' => Schema::TYPE_PK,
    			'profession' => Schema::TYPE_STRING,
    			'created_at'=>Schema::TYPE_BIGINT,
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }
    
    public function safeDown()
    {
    	$this->dropTable('profession');
    }
}
