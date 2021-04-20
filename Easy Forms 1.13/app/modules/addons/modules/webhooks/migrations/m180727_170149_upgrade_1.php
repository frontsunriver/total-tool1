<?php

use yii\db\Migration;

/**
 * Class m180727_170149_upgrade_1
 */
class m180727_170149_upgrade_1 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%addon_webhooks}}', 'alias', $this->boolean()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%addon_webhooks}}', 'alias');
    }

}
