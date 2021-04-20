<?php

use yii\db\Migration;
use yii\db\Schema;

class m160104_150526_add_slug_to_form extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%form}}', 'slug', Schema::TYPE_STRING . '(255) AFTER name');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%form}}', 'slug');
    }
}
