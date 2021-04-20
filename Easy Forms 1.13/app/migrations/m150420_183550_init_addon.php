<?php

use yii\db\Schema;
use yii\db\Migration;

class m150420_183550_init_addon extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%addon}}', [
            'id' => Schema::TYPE_STRING . '(255) NOT NULL',
            'class' => Schema::TYPE_STRING . '(255) NOT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'description' => Schema::TYPE_STRING . '(255)',
            'version' => Schema::TYPE_STRING . '(255)',
            'status' => Schema::TYPE_BOOLEAN . ' DEFAULT FALSE',
            'installed' => Schema::TYPE_BOOLEAN . ' DEFAULT FALSE',
        ], $tableOptions);

        $this->createIndex('id', '{{%addon}}', 'id', true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%addon}}');
    }
}
