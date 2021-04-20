<?php

use yii\db\Migration;

/**
 * Class m200618_202154_upgrade_to_1_12
 */
class m200618_202154_upgrade_to_1_12 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /**
         * Add access_token to User table
         */
        $this->addColumn('{{%user}}', 'access_token', $this->string(40)->unique()->after('password_hash'));

        /**
         * Form Settings
         */
        $this->addColumn('{{%form}}', 'is_private', $this->boolean()->defaultValue(0)->after('status'));
        $this->addColumn('{{%form}}', 'protected_files', $this->boolean()->defaultValue(0)->after('recaptcha'));
        $this->addColumn('{{%form}}', 'ip_tracking', $this->boolean()->defaultValue(1)->after('protected_files'));
        $this->addColumn('{{%form}}', 'browser_fingerprint', $this->boolean()->defaultValue(1)->after('ip_tracking'));
        $this->addColumn('{{%form}}', 'text_direction', $this->string(3)->defaultValue('ltr')->after('language'));

        $this->renameColumn('{{%form}}', 'total_limit_period', 'total_limit_time_unit');

        $this->renameColumn('{{%form}}', 'ip_limit', 'user_limit');
        $this->renameColumn('{{%form}}', 'ip_limit_number', 'user_limit_number');
        $this->renameColumn('{{%form}}', 'ip_limit_period', 'user_limit_time_unit');

        $this->addColumn('{{%form}}', 'user_limit_type', $this->tinyInteger(1)->after('user_limit'));

        $this->addColumn('{{%form}}', 'submission_scope', $this->tinyInteger(1)->defaultValue(0)->after('user_limit_type'));
        $this->addColumn('{{%form}}', 'submission_editable', $this->tinyInteger(1)->defaultValue(0)->after('submission_number_width'));
        $this->addColumn('{{%form}}', 'submission_editable_time_length', $this->integer(11)->after('submission_editable'));
        $this->addColumn('{{%form}}', 'submission_editable_time_unit', $this->string(1)->after('submission_editable_time_length'));
        $this->addColumn('{{%form}}', 'submission_editable_conditions', $this->text()->after('submission_editable_time_unit'));

        /**
         * Form Builder
         */
        $this->addColumn('{{%form_data}}', 'version', $this->string(10)->after('height'));

        /**
         * Form Submission
         */
        $this->addColumn('{{%form_submission}}', 'browser_fingerprint', $this->text()->after('ip'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /**
         * Remove access_token from User table
         */
        $this->dropColumn('{{%user}}', 'access_token');

        /**
         * Form Settings
         */
        $this->dropColumn('{{%form}}', 'is_private');
        $this->dropColumn('{{%form}}', 'protected_files');
        $this->dropColumn('{{%form}}', 'ip_tracking');
        $this->dropColumn('{{%form}}', 'browser_fingerprint');
        $this->dropColumn('{{%form}}', 'text_direction');

        $this->renameColumn('{{%form}}', 'total_limit_time_unit', 'total_limit_period');

        $this->renameColumn('{{%form}}', 'user_limit', 'ip_limit');
        $this->renameColumn('{{%form}}', 'user_limit_number', 'ip_limit_number');
        $this->renameColumn('{{%form}}', 'user_limit_time_unit', 'ip_limit_period');

        $this->dropColumn('{{%form}}', 'user_limit_type');

        $this->dropColumn('{{%form}}', 'submission_scope');
        $this->dropColumn('{{%form}}', 'submission_editable');
        $this->dropColumn('{{%form}}', 'submission_editable_time_length');
        $this->dropColumn('{{%form}}', 'submission_editable_time_unit');
        $this->dropColumn('{{%form}}', 'submission_editable_conditions');

        /**
         * Form Builder
         */
        $this->dropColumn('{{%form_data}}', 'version');

        /**
         * Form Submission
         */
        $this->dropColumn('{{%form_submission}}', 'browser_fingerprint');

    }
}
