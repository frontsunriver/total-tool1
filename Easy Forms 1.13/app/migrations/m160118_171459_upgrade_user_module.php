<?php

use yii\db\Schema;
use yii\db\Migration;

class m160118_171459_upgrade_user_module extends Migration
{
    public function safeUp()
    {
        $this->renameColumn("{{%role}}", "create_time", "created_at");
        $this->renameColumn("{{%role}}", "update_time", "updated_at");
        $this->renameColumn("{{%profile}}", "create_time", "created_at");
        $this->renameColumn("{{%profile}}", "update_time", "updated_at");
        $this->renameColumn("{{%user_auth}}", "create_time", "created_at");
        $this->renameColumn("{{%user_auth}}", "update_time", "updated_at");

        $this->renameColumn("{{%user}}", "create_time", "created_at");
        $this->renameColumn("{{%user}}", "update_time", "updated_at");
        $this->renameColumn("{{%user}}", "api_key", "access_token");
        $this->renameColumn("{{%user}}", "login_ip", "logged_in_ip");
        $this->renameColumn("{{%user}}", "login_time", "logged_in_at");
        $this->renameColumn("{{%user}}", "create_ip", "created_ip");
        $this->renameColumn("{{%user}}", "ban_time", "banned_at");
        $this->renameColumn("{{%user}}", "ban_reason", "banned_reason");
        $this->dropColumn("{{%user}}", "new_email");

        $this->renameTable("{{%user_key}}", "{{%user_token}}");
        $this->renameColumn("{{%user_token}}", "key_value", "token"); // may be "key" if <3.0.0
        $this->renameColumn("{{%user_token}}", "create_time", "created_at");
        $this->renameColumn("{{%user_token}}", "expire_time", "expired_at");
        $this->dropColumn("{{%user_token}}", "consume_time");
        $this->addColumn("{{%user_token}}", "data", Schema::TYPE_STRING . " null after token");
        $this->alterColumn("{{%user_token}}", "user_id", Schema::TYPE_INTEGER . " null");

        $this->addColumn(
            '{{%role}}',
            'can_edit_own_content',
            Schema::TYPE_SMALLINT . ' not null default 0 after can_admin'
        );
        // Update role 'Admin' 'can_edit_own_content'
        $this->update('{{%role}}', ['can_edit_own_content' => 1], ['id' => 1]);
        // Insert role 'Advanced User' 'can_edit_own_content
        $columns = ['name', 'can_admin', 'can_edit_own_content', 'created_at'];
        $this->batchInsert('{{%role}}', $columns, [
            ['Advanced User', 0, 1, date('Y-m-d H:i:s')],
        ]);
        // Update name of role 'User' to 'Basic User'
        $this->update('{{%role}}', ['name' => 'Basic User'], ['id' => 2]);

        // insert settings data
        $columns = ['type', 'category', 'key', 'value', 'status', 'created_at', 'updated_at'];
        $this->batchInsert('{{%setting}}', $columns, [
            ['integer', "app", "anyoneCanRegister", 0, 1, time(), time()],
            ['integer', "app", "loginWithoutPassword", 0, 1, time(), time()],
            ['integer', "app", "useCaptcha", 0, 1, time(), time()],
            ['integer', "app", "defaultUserRole", 2, 1, time(), time()],
        ]);

    }

    public function safeDown()
    {
        // delete null values in user_token.user_id and then make column not null
        // note that the foreign key name is user_key, NOT user_token
        $this->execute("delete from {{%user_token}} where user_id is null");
        $this->alterColumn("{{%user_token}}", "user_id", Schema::TYPE_INTEGER . " not null");

        $this->renameColumn("{{%user_token}}", "token", "key_value"); // may be "key" if <3.0.0
        $this->renameColumn("{{%user_token}}", "created_at", "create_time");
        $this->renameColumn("{{%user_token}}", "expired_at", "expire_time");
        $this->addColumn("{{%user_token}}", "consume_time", Schema::TYPE_STRING . " null");
        $this->dropColumn("{{%user_token}}", "data");
        $this->renameTable("{{%user_token}}", "{{%user_key}}");

        $this->renameColumn("{{%role}}", "created_at", "create_time");
        $this->renameColumn("{{%role}}", "updated_at", "update_time");
        $this->renameColumn("{{%profile}}", "created_at", "create_time");
        $this->renameColumn("{{%profile}}", "updated_at", "update_time");
        $this->renameColumn("{{%user_auth}}", "created_at", "create_time");
        $this->renameColumn("{{%user_auth}}", "updated_at", "update_time");

        $this->renameColumn("{{%user}}", "created_at", "create_time");
        $this->renameColumn("{{%user}}", "updated_at", "update_time");
        $this->renameColumn("{{%user}}", "access_token", "api_key");
        $this->renameColumn("{{%user}}", "logged_in_ip", "login_ip");
        $this->renameColumn("{{%user}}", "logged_in_at", "login_time");
        $this->renameColumn("{{%user}}", "created_ip", "create_ip");
        $this->renameColumn("{{%user}}", "banned_at", "ban_time");
        $this->renameColumn("{{%user}}", "banned_reason", "ban_reason");
        $this->addColumn("{{%user}}", "new_email", Schema::TYPE_STRING . " null after email");

        $this->dropColumn('{{%role}}', 'can_edit_own_content');
        $this->update('{{%role}}', ['name' => 'User'], ['id' => 2]);
        $this->update('{{%user}}', ['role_id' => 2], ['role_id' => 3]);
        $this->delete('{{%role}}', ['id' => 3]);
        $this->delete('{{%setting}}', ['key' => "anyoneCanRegister"]);
        $this->delete('{{%setting}}', ['key' => "loginWithoutPassword"]);
        $this->delete('{{%setting}}', ['key' => "defaultUserRole"]);
        $this->delete('{{%setting}}', ['key' => "useCaptcha"]);
    }
}
