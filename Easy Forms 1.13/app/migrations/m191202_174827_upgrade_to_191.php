<?php

use yii\db\Migration;

/**
 * Class m191202_174827_upgrade_to_191
 */
class m191202_174827_upgrade_to_191 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        // Update Form Email
        $this->addColumn('{{%form_email}}', 'field_to', $this->string(2555)->after('form_id'));
        $this->addColumn('{{%form_email}}', 'event', $this->integer()->notNull()->defaultValue(1)->after('attach'));
        $this->addColumn('{{%form_email}}', 'conditions', $this->text()->after('event'));

        // Update Form Rule
        $this->addColumn('{{%form_rule}}', 'name', $this->string(255)->after('form_id'));

        // Update Form Confirmation
        $this->alterColumn('{{%form_confirmation}}', 'url', $this->string(2555));
        $this->alterColumn('{{%form_confirmation}}', 'mail_to', $this->string(2555));
        $this->alterColumn('{{%form_confirmation}}', 'mail_from', $this->string(2555));
        $this->alterColumn('{{%form_confirmation}}', 'mail_subject', $this->string(2555));
        $this->alterColumn('{{%form_confirmation}}', 'mail_from_name', $this->string(2555));

        $this->addColumn('{{%form_confirmation}}', 'append', $this->integer()->notNull()->defaultValue(0)->after('url'));
        $this->addColumn('{{%form_confirmation}}', 'alias', $this->integer()->notNull()->defaultValue(0)->after('append'));
        $this->addColumn('{{%form_confirmation}}', 'seconds', $this->integer()->after('alias'));
        $this->addColumn('{{%form_confirmation}}', 'mail_cc', $this->string(2555)->after('mail_from'));
        $this->addColumn('{{%form_confirmation}}', 'mail_bcc', $this->string(2555)->after('mail_cc'));
        $this->addColumn('{{%form_confirmation}}', 'mail_attach', $this->integer()->notNull()->defaultValue(1)->after('mail_receipt_copy'));
        $this->addColumn('{{%form_confirmation}}', 'mail_attachments', $this->text()->after('mail_attach'));
        $this->addColumn('{{%form_confirmation}}', 'opt_in', $this->integer()->after('mail_attachments'));
        $this->addColumn('{{%form_confirmation}}', 'opt_in_type', $this->integer()->defaultValue(0)->after('opt_in'));
        $this->addColumn('{{%form_confirmation}}', 'opt_in_message', $this->text()->after('opt_in_type'));
        $this->addColumn('{{%form_confirmation}}', 'opt_in_url', $this->string(2555)->after('opt_in_message'));
        $this->addColumn('{{%form_confirmation}}', 'opt_out', $this->integer()->after('opt_in_url'));
        $this->addColumn('{{%form_confirmation}}', 'opt_out_type', $this->integer()->defaultValue(0)->after('opt_out'));
        $this->addColumn('{{%form_confirmation}}', 'opt_out_message', $this->text()->after('opt_out_type'));
        $this->addColumn('{{%form_confirmation}}', 'opt_out_url', $this->string(255)->after('opt_out_message'));

        // Add Form Confirmation Rule
        $this->createTable('{{%form_confirmation_rule}}', [
            'id' => $this->primaryKey(),
            'form_id' => $this->integer(11)->notNull(),

            // Settings
            'name' => $this->string(255),
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'conditions' => $this->text(),
            'action' => $this->integer(1)->notNull()->defaultValue(0),
            'message' => $this->text(),
            'url' => $this->string(2555),
            'append' => $this->integer(1)->notNull()->defaultValue(0),
            'alias' => $this->integer(1)->notNull()->defaultValue(0),
            'seconds' => $this->integer(1),

            // Additional Settings
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%form_confirmation_rule}}');

        $this->dropColumn('{{%form_confirmation}}', 'opt_out_url');
        $this->dropColumn('{{%form_confirmation}}', 'opt_out_message');
        $this->dropColumn('{{%form_confirmation}}', 'opt_out');
        $this->dropColumn('{{%form_confirmation}}', 'opt_out_type');
        $this->dropColumn('{{%form_confirmation}}', 'opt_in_url');
        $this->dropColumn('{{%form_confirmation}}', 'opt_in_message');
        $this->dropColumn('{{%form_confirmation}}', 'opt_in_type');
        $this->dropColumn('{{%form_confirmation}}', 'opt_in');
        $this->dropColumn('{{%form_confirmation}}', 'mail_attachments');
        $this->dropColumn('{{%form_confirmation}}', 'mail_bcc');
        $this->dropColumn('{{%form_confirmation}}', 'mail_cc');
        $this->dropColumn('{{%form_confirmation}}', 'seconds');
        $this->dropColumn('{{%form_confirmation}}', 'alias');
        $this->dropColumn('{{%form_confirmation}}', 'append');

        $this->alterColumn('{{%form_confirmation}}', 'mail_from_name', $this->string(255));
        $this->alterColumn('{{%form_confirmation}}', 'mail_subject', $this->string(255));
        $this->alterColumn('{{%form_confirmation}}', 'mail_from', $this->string(255));
        $this->alterColumn('{{%form_confirmation}}', 'mail_to', $this->string(255));
        $this->alterColumn('{{%form_confirmation}}', 'url', $this->string(255));

        $this->dropColumn('{{%form_rule}}', 'name');

        $this->dropColumn('{{%form_email}}', 'conditions');
        $this->dropColumn('{{%form_email}}', 'event');
        $this->dropColumn('{{%form_email}}', 'field_to');
    }

}
