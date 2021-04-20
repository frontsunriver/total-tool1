<?php

use yii\db\Migration;

/**
 * Class m190811_215815_upgrade_to_172
 */
class m190811_215815_upgrade_to_172 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%form}}', 'submission_number', $this->integer()->after('ip_limit_period')->defaultValue(1));
        $this->addColumn('{{%form}}', 'submission_number_prefix', $this->string(100)->after('submission_number'));
        $this->addColumn('{{%form}}', 'submission_number_suffix', $this->string(100)->after('submission_number_prefix'));
        $this->addColumn('{{%form}}', 'submission_number_width', $this->integer()->after('submission_number_suffix'));
        $this->addColumn('{{%form_submission}}', 'number', $this->string(255)->after('form_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%form_submission}}', 'number');
        $this->dropColumn('{{%form}}', 'submission_number_width');
        $this->dropColumn('{{%form}}', 'submission_number_suffix');
        $this->dropColumn('{{%form}}', 'submission_number_prefix');
        $this->dropColumn('{{%form}}', 'submission_number');
    }
}
