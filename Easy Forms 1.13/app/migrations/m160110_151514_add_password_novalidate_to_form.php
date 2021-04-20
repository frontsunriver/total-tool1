<?php

use yii\db\Schema;
use yii\db\Migration;

class m160110_151514_add_password_novalidate_to_form extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            '{{%form}}',
            'use_password',
            Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE AFTER status'
        );
        $this->addColumn(
            '{{%form}}',
            'password',
            Schema::TYPE_STRING . '(255) AFTER use_password'
        );
        $this->addColumn(
            '{{%form}}',
            'novalidate',
            Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE AFTER autocomplete'
        );
    }

    public function safeDown()
    {
        $this->dropColumn('{{%form}}', 'use_password');
        $this->dropColumn('{{%form}}', 'password');
        $this->dropColumn('{{%form}}', 'novalidate');
    }

}
