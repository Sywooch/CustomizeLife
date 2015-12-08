<?php

use yii\db\Schema;
use yii\db\Migration;

class m151208_124044_reltag extends Migration
{
public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS reltag");
    	$this->createTable('reltag', [
    			'id' => Schema::TYPE_PK,
    			'tag' => Schema::TYPE_STRING,
    			'created_at'=>Schema::TYPE_BIGINT,
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }
    
    public function safeDown()
    {
    	$this->dropTable('reltag');
    }
}
