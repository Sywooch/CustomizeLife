<?php
use yii\db\Schema;
use yii\db\Migration;
class m150623_084658_app extends Migration {
	public function safeUp() {
		$this->execute ( "DROP TABLE IF EXISTS app" );
		$this->createTable ( 'app', [ 
				'id' => Schema::TYPE_PK,
				'name' => Schema::TYPE_STRING . ' NOT NULL',
				'version' => Schema::TYPE_STRING . ' NOT NULL',
				'profile' => Schema::TYPE_STRING,
				'android_url' => Schema::TYPE_STRING . ' NOT NULL',
				'ios_url' => Schema::TYPE_STRING . ' NOT NULL',
				'stars' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
				'downloadcount' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
				'commentscount' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
				'introduction' => Schema::TYPE_STRING . ' NOT NULL',
				'updated_at' => Schema::TYPE_DATE . ' NOT NULL',
				'size' => Schema::TYPE_STRING . ' NOT NULL',
				'icon' => Schema::TYPE_STRING . ' NOT NULL',
				'updated_log' => Schema::TYPE_STRING,
				'kind' => Schema::TYPE_STRING,
				'package' => Schema::TYPE_STRING,
		], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' );
	}
	public function safeDown() {
		// $this->dropTable('appofkind');
		// $this->dropTable('appcomments');
		// $this->dropTable('collect_person');
		$this->dropTable ( 'app' );
	}
	
	/*
	 * // Use safeUp/safeDown to run migration code within a transaction public function safeUp() { } public function safeDown() { }
	 */
}
