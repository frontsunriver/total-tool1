<?php

use yii\db\Schema;
use yii\db\Migration;

class m150420_183548_init_mailqueue extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%mail_queue}}', [
            'id' => Schema::TYPE_PK,
            'from' => Schema::TYPE_TEXT,
            'to' => Schema::TYPE_TEXT,
            'cc' => Schema::TYPE_TEXT,
            'bcc' => Schema::TYPE_TEXT,
            'subject' => Schema::TYPE_STRING,
            'html_body' => Schema::TYPE_TEXT,
            'text_body' => Schema::TYPE_TEXT,
            'reply_to' => Schema::TYPE_TEXT,
            'charset' => Schema::TYPE_STRING,
            'attachments' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'attempts' => Schema::TYPE_INTEGER,
            'last_attempt_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'sent_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%mail_queue}}');
    }
}
