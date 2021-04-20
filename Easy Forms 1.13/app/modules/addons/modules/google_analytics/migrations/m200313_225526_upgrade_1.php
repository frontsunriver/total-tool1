<?php

use yii\db\Migration;

/**
 * Class m200313_225526_upgrade_1
 */
class m200313_225526_upgrade_1 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%addon_google_analytics}}', 'created_by', $this->integer(11));
        $this->addColumn('{{%addon_google_analytics}}', 'updated_by', $this->integer(11));
        $this->addColumn('{{%addon_google_analytics}}', 'created_at', $this->integer());
        $this->addColumn('{{%addon_google_analytics}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%addon_google_analytics}}', 'created_by');
        $this->dropColumn('{{%addon_google_analytics}}', 'updated_by');
        $this->dropColumn('{{%addon_google_analytics}}', 'created_at');
        $this->dropColumn('{{%addon_google_analytics}}', 'updated_at');
    }
}
