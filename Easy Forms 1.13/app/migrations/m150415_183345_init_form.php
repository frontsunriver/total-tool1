<?php

use yii\db\Schema;
use yii\db\Migration;

class m150415_183345_init_form extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%form}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'status' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'schedule' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
            'schedule_start_date' => Schema::TYPE_INTEGER . '(11)',
            'schedule_end_date' => Schema::TYPE_INTEGER . '(11)',
            'total_limit' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
            'total_limit_number' => Schema::TYPE_INTEGER . '(11)',
            'total_limit_period' => Schema::TYPE_STRING . '(1)',
            'ip_limit' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
            'ip_limit_number' => Schema::TYPE_INTEGER . '(11)',
            'ip_limit_period' => Schema::TYPE_STRING . '(1)',
            'save' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'resume' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
            'autocomplete' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'analytics' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'honeypot' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'recaptcha' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
            'language' => Schema::TYPE_STRING . '(5) NOT NULL DEFAULT "en-US"',
            'message' => Schema::TYPE_TEXT,
            'created_by' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createTable('{{%form_data}}', [
            'id' => Schema::TYPE_PK,
            'form_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'builder' => 'mediumtext', // MySql type
            'fields' => 'mediumtext', // MySql type
            'html' => 'mediumtext', // MySql type
            'height' => Schema::TYPE_INTEGER . '(5) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex("{{%form_data_form_id}}", "{{%form_data}}", "form_id");

        $this->createTable('{{%form_ui}}', [
            'id' => Schema::TYPE_PK,
            'form_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'theme_id' => Schema::TYPE_INTEGER . '(11)',
            'js_file' => Schema::TYPE_STRING . '(255)',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex("{{%form_ui_form_id}}", "{{%form_ui}}", "form_id");

        $this->createTable('{{%form_email}}', [
            'id' => Schema::TYPE_PK,
            'form_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'to' => Schema::TYPE_STRING . '(255)',
            'from' => Schema::TYPE_STRING . '(255)',
            'cc' => Schema::TYPE_STRING . '(255)',
            'bcc' => Schema::TYPE_STRING . '(255)',
            'subject' => Schema::TYPE_STRING . '(255)',
            'type' => Schema::TYPE_INTEGER . '(1) NOT NULL DEFAULT 0',
            'message' => Schema::TYPE_TEXT,
            'plain_text' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
            'attach' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex("{{%form_email_form_id}}", "{{%form_email}}", "form_id");

        $this->createTable('{{%form_confirmation}}', [
            'id' => Schema::TYPE_PK,
            'form_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'type' => Schema::TYPE_INTEGER . '(1) NOT NULL DEFAULT 0',
            'message' => Schema::TYPE_TEXT,
            'url' => Schema::TYPE_STRING . '(255)',
            'send_email' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
            'mail_to' => Schema::TYPE_STRING . '(255)',
            'mail_from' => Schema::TYPE_STRING . '(255)',
            'mail_subject' => Schema::TYPE_STRING . '(255)',
            'mail_message' => Schema::TYPE_TEXT,
            'mail_from_name' => Schema::TYPE_STRING . '(255)',
            'mail_receipt_copy' => Schema::TYPE_BOOLEAN . ' DEFAULT FALSE',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex("{{%form_confirmation_form_id}}", "{{%form_confirmation}}", "form_id");

        $this->createTable('{{%form_rule}}', [
            'id' => Schema::TYPE_PK,
            'form_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'status' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'conditions' => 'mediumtext', // MySql type
            'actions' => 'mediumtext', // MySql type
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex("{{%form_rule_form_id}}", "{{%form_rule}}", "form_id");

        $this->createTable('{{%form_submission}}', [
            'id' => Schema::TYPE_PK,
            'form_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'status' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'new' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'important' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
            'sender' => Schema::TYPE_TEXT,
            'data' => Schema::TYPE_TEXT,
            'ip' => Schema::TYPE_TEXT . ' (45)',
            'created_by' => Schema::TYPE_INTEGER . '(11)',
            'updated_by' => Schema::TYPE_INTEGER . '(11)',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex("{{%form_submission_form_id}}", "{{%form_submission}}", "form_id");

        $this->createTable('{{%form_submission_file}}', [
            'id' => Schema::TYPE_PK,
            'submission_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'form_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'extension' => Schema::TYPE_STRING . ' NOT NULL',
            'size' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex("{{%form_submission_file_submission_id}}", "{{%form_submission_file}}", "submission_id");
        $this->createIndex("{{%form_submission_file_form_id}}", "{{%form_submission_file}}", "form_id");

        $this->createTable('{{%form_chart}}', [
            'form_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'label' => Schema::TYPE_STRING . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'type' => Schema::TYPE_STRING . ' NOT NULL',
            'width' => Schema::TYPE_INTEGER,
            'height' => Schema::TYPE_INTEGER,
            'gsX' => Schema::TYPE_INTEGER,
            'gsY' => Schema::TYPE_INTEGER,
            'gsW' => Schema::TYPE_INTEGER,
            'gsH' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex("{{%form_chart_form_id}}", "{{%form_chart}}", "form_id");
        $this->createIndex("{{%form_chart_form_id_name}}", "{{%form_chart}}", ["form_id", "name"], true);

        $this->createTable('{{%form_user}}', [
            'form_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex("{{%form_user_form_id}}", "{{%form_user}}", "form_id");
        $this->createIndex("{{%form_user_user_id}}", "{{%form_user}}", "user_id");
        $this->createIndex("{{%form_user_form_id_user_id}}", "{{%form_user}}", ["form_id", "user_id"], true);

    }

    public function safeDown()
    {

        // Builds and executes a SQL statement for dropping a DB table.
        $this->dropTable('{{%form_user}}');
        $this->dropTable('{{%form_chart}}');
        $this->dropTable('{{%form_submission_file}}');
        $this->dropTable('{{%form_submission}}');
        $this->dropTable('{{%form_confirmation}}');
        $this->dropTable('{{%form_email}}');
        $this->dropTable('{{%form_data}}');
        $this->dropTable('{{%form_ui}}');
        $this->dropTable('{{%form_rule}}');
        $this->dropTable('{{%form}}');

    }

}
