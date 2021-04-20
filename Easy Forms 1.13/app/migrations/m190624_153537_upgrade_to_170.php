<?php

use yii\db\Migration;

/**
 * Class m190624_153537_upgrade_to_170
 */
class m190624_153537_upgrade_to_170 extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%user}}', 'preferences', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%user}}', 'preferences');
    }
}
