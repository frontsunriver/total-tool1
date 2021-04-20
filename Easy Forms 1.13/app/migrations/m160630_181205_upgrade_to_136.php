<?php

use yii\db\Schema;
use yii\db\Migration;

class m160630_181205_upgrade_to_136 extends Migration
{
    public function up()
    {
        // Add File Management to Submission Manager
        $this->addColumn(
            '{{%form_submission_file}}',
            'field',
            Schema::TYPE_STRING . '(255) NOT NULL AFTER form_id'
        );
        $this->addColumn(
            '{{%form_submission_file}}',
            'label',
            Schema::TYPE_STRING . '(255) AFTER field'
        );
        // Add Opposite Actions to Rule Builder
        $this->addColumn(
            '{{%form_rule}}',
            'opposite',
            Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE AFTER status'
        );
        // Add authorized urls to Form
        $this->addColumn(
            '{{%form}}',
            'authorized_urls',
            Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE AFTER password'
        );
        $this->addColumn(
            '{{%form}}',
            'urls',
            Schema::TYPE_STRING . '(2555) AFTER authorized_urls'
        );
    }

    public function down()
    {
        $this->dropColumn('{{%form}}', 'urls');
        $this->dropColumn('{{%form}}', 'authorized_urls');
        $this->dropColumn('{{%form_submission_file}}', 'field');
        $this->dropColumn('{{%form_submission_file}}', 'label');
        $this->dropColumn('{{%form_rule}}', 'opposite');
    }
}
