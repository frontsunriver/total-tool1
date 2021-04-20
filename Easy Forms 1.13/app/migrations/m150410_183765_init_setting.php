<?php

use yii\db\Schema;
use yii\db\Migration;

class m150410_183765_init_setting extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%setting}}', [
            'id' => Schema::TYPE_PK,
            'type' => Schema::TYPE_STRING . '(64) NOT NULL',
            'category' => Schema::TYPE_STRING . '(64) NOT NULL',
            'key' => Schema::TYPE_STRING . '(255) NOT NULL',
            'value' => Schema::TYPE_TEXT . ' NOT NULL',
            'status' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex("{{%setting_category_key}}", "{{%setting}}", ["category", "key"], true);

        // insert role data
        $columns = ['type', 'category', 'key', 'value', 'status', 'created_at', 'updated_at'];
        $this->batchInsert('{{%setting}}', $columns, [
            ['string', "app", "name", "Easy Forms", 1, time(), time()],
            ['string', "app", "description", '<p>Welcome to <span style="color: #c9d2db;"> the easiest way </span> to build, design and manage <span style="color: #e8ebef; font-weight: bold;"> your online forms</span>.</p>', 1, time(), time()],
            ['string', "app", "adminEmail", "admin@example.com", 1, time(), time()],
            ['string', "app", "supportEmail", "support@example.com", 1, time(), time()],
            ['string', "app", "noreplyEmail", "no-reply@example.com", 1, time(), time()],
            ['string', "app", "reCaptchaVersion", "2", 1, time(), time()],
            ['string', "app", "reCaptchaSecret", "your_secret", 1, time(), time()],
            ['string', "app", "reCaptchaSiteKey", "your_site_key", 1, time(), time()],
            ['string', "smtp", "host", "localhost", 1, time(), time()],
            ['string', "smtp", "port", "25", 1, time(), time()],
            ['string', "smtp", "encryption", "none", 1, time(), time()],
            ['string', "smtp", "username", "Username", 1, time(), time()],
            ['string', "smtp", "password", "Password", 1, time(), time()],
        ]);
    }

    public function safeDown()
    {
        // Builds and executes a SQL statement for dropping a DB table.
        $this->dropTable('{{%setting}}');
    }
}
