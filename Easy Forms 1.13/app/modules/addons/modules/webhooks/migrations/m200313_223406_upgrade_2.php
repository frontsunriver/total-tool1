<?php

use yii\db\Migration;

/**
 * Class m200313_223406_upgrade_2
 */
class m200313_223406_upgrade_2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%addon_webhooks}}', 'created_by', $this->integer(11));
        $this->addColumn('{{%addon_webhooks}}', 'updated_by', $this->integer(11));
        $this->addColumn('{{%addon_webhooks}}', 'created_at', $this->integer());
        $this->addColumn('{{%addon_webhooks}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%addon_webhooks}}', 'created_by');
        $this->dropColumn('{{%addon_webhooks}}', 'updated_by');
        $this->dropColumn('{{%addon_webhooks}}', 'created_at');
        $this->dropColumn('{{%addon_webhooks}}', 'updated_at');
    }
}
