<?php

use yii\db\Migration;
use yii\db\Schema;

class m160813_213103_upgrade_to_137 extends Migration
{
    public function up()
    {
        // Add Ordinal Position to Rule Builder
        $this->addColumn(
            '{{%form_rule}}',
            'ordinal',
            Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0 AFTER opposite'
        );
    }

    public function down()
    {
        $this->dropColumn('{{%form_rule}}', 'ordinal');
    }
}
