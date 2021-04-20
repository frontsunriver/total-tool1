<?php

use yii\db\Migration;
use yii\db\Schema;

class m160813_213105_upgrade_to_139 extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        // Add Comment System to Submission Manager
        $this->createTable('{{%form_submission_comment}}', [
            'id' => Schema::TYPE_PK,
            'submission_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'form_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'content' => Schema::TYPE_TEXT,
            'status' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
            'created_by' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex("{{%form_submission_comment_submission_id}}", "{{%form_submission_comment}}", "submission_id");
        $this->createIndex("{{%form_submission_comment_form_id}}", "{{%form_submission_comment}}", "form_id");
    }

    public function down()
    {
        $this->dropTable('{{%form_submission_comment}}');
    }
}
