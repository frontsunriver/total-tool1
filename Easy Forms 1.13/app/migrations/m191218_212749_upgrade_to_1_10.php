<?php

use app\components\rbac\rules\AuthorRule;
use app\components\rbac\rules\NotAuthorRule;
use app\components\rbac\rules\SharedRule;
use app\models\User;
use yii\db\Expression;
use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

/**
 * Class m191218_212749_upgrade_to_1_10
 */
class m191218_212749_upgrade_to_1_10 extends Migration
{
    public $column = 'user_id';
    public $index = 'auth_assignment_user_id_idx';

    public $currentUsers = [];

    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }

    /**
     * @return bool
     */
    protected function isMSSQL()
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }

    protected function isOracle()
    {
        return $this->db->driverName === 'oci';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->currentUsers = User::find()->asArray()->all();

        /**
         * Migrate database structure for RBAC system
         */

        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;
        $schema = $this->db->getSchema()->defaultSchema;
        $restrict = $this->isMSSQL() ? 'NO ACTION' : 'RESTRICT';

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        /**
         * m140506_102106_rbac_init
         */

        $this->createTable($authManager->ruleTable, [
            'name' => $this->string(64)->notNull(),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY ([[name]])',
        ], $tableOptions);

        $this->createTable($authManager->itemTable, [
            'name' => $this->string(64)->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY ([[name]])',
            'FOREIGN KEY ([[rule_name]]) REFERENCES ' . $authManager->ruleTable . ' ([[name]])' .
            $this->buildFkClause('ON DELETE SET NULL', 'ON UPDATE CASCADE'),
        ], $tableOptions);
        $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');

        $this->createTable($authManager->itemChildTable, [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
            'PRIMARY KEY ([[parent]], [[child]])',
            'FOREIGN KEY ([[parent]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[child]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable($authManager->assignmentTable, [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY ([[item_name]], [[user_id]])',
            'FOREIGN KEY ([[item_name]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        /**
         * m170907_052038_rbac_add_index_on_auth_assignment_user_id
         */

        $this->createIndex($this->index, $authManager->assignmentTable, $this->column);

        /**
         * m180523_151638_rbac_updates_indexes_without_prefix
         */

        $this->dropIndex('auth_assignment_user_id_idx', $authManager->assignmentTable);
        $this->createIndex('{{%idx-auth_assignment-user_id}}', $authManager->assignmentTable, 'user_id');

        $this->dropIndex('idx-auth_item-type', $authManager->itemTable);
        $this->createIndex('{{%idx-auth_item-type}}', $authManager->itemTable, 'type');

        /**
         * Init RBAC System
         */
        $this->initRbacSettings();

        /**
         * Migrate database structure for new user system
         */

        /**
         * User
         */

        // password => password_hash
        $this->renameColumn('{{%user}}', 'password', 'password_hash');
        $this->alterColumn('{{%user}}', 'password_hash', $this->string(60)->notNull());
        // created_ip => registration_ip
        $this->renameColumn('{{%user}}', 'created_ip', 'registration_ip');
        $this->alterColumn('{{%user}}', 'registration_ip', $this->string(45));
        // logged_in_ip => last_login_ip
        $this->renameColumn('{{%user}}', 'logged_in_ip', 'last_login_ip');
        $this->alterColumn('{{%user}}', 'last_login_ip', $this->string(45));
        // banned_at => blocked_at
        $this->renameColumn('{{%user}}', 'banned_at', 'blocked_at');
        $this->alterColumn('{{%user}}', 'blocked_at', $this->integer());
        $this->addColumn('{{%user}}', 'unconfirmed_email', $this->string(255));
        $this->addColumn('{{%user}}', 'flags', $this->integer()->notNull()->defaultValue('0'));
        $this->addColumn('{{%user}}', 'confirmed_at', $this->integer());
        $this->addColumn('{{%user}}', 'auth_tf_key', $this->string(16));
        $this->addColumn(
            '{{%user}}',
            'auth_tf_enabled',
            $this->boolean()->defaultValue(0)
        );
        $this->addColumn('{{%user}}', 'password_changed_at', $this->integer()->null());
        $this->addColumn('{{%user}}', 'gdpr_consent', $this->boolean()->defaultValue(0));
        $this->addColumn('{{%user}}', 'gdpr_consent_date', $this->integer(11)->null());
        $this->addColumn('{{%user}}', 'gdpr_deleted', $this->boolean()->defaultValue(0));
        // auth_key
        $this->dropColumn('{{%user}}', 'auth_key');
        $this->addColumn('{{%user}}', 'auth_key', $this->string(32)->notNull());
        // logged_in_at => last_login_at
        $this->addColumn('{{%user}}', 'last_login_at_i', $this->integer());
        $this->update('{{%user}}', ['last_login_at_i' => new Expression('UNIX_TIMESTAMP(logged_in_at)')]);
        $this->dropColumn('{{%user}}', 'logged_in_at');
        $this->renameColumn('{{%user}}', 'last_login_at_i', 'last_login_at');
        // created_at
        $this->addColumn('{{%user}}', 'created_at_i', $this->integer());
        $this->update('{{%user}}', ['created_at_i' => new Expression('UNIX_TIMESTAMP(created_at)')]);
        $this->dropColumn('{{%user}}', 'created_at');
        $this->renameColumn('{{%user}}', 'created_at_i', 'created_at');
        // updated_at
        $this->addColumn('{{%user}}', 'updated_at_i', $this->integer());
        $this->update('{{%user}}', ['updated_at_i' => new Expression('UNIX_TIMESTAMP(updated_at)')]);
        $this->dropColumn('{{%user}}', 'updated_at');
        $this->renameColumn('{{%user}}', 'updated_at_i', 'updated_at');
        $this->dropForeignKey("{{%user_role_id}}", "{{%user}}");
        $this->dropColumn('{{%user}}', 'role_id');
        $this->dropColumn('{{%user}}', 'status');
        $this->dropColumn('{{%user}}', 'access_token');
        $this->dropColumn('{{%user}}', 'banned_reason');

        /**
         * Profile
         */

        $this->dropColumn('{{%profile}}', 'id');
        $this->renameColumn('{{%profile}}', 'full_name', 'name');
        $this->addColumn('{{%profile}}', 'public_email', $this->string(255));
        $this->addColumn('{{%profile}}', 'gravatar_email', $this->string(255));
        $this->addColumn('{{%profile}}', 'gravatar_id', $this->string(32));
        $this->addColumn('{{%profile}}', 'location', $this->string(255));
        $this->addColumn('{{%profile}}', 'website', $this->string(255));
        $this->addColumn('{{%profile}}', 'bio', $this->text());
        $this->dropColumn('{{%profile}}', 'company');
        $this->dropColumn('{{%profile}}', 'avatar');
        $this->dropColumn('{{%profile}}', 'created_at');
        $this->dropColumn('{{%profile}}', 'updated_at');

        $this->addPrimaryKey('{{%profile_pk}}', '{{%profile}}', 'user_id');
        $this->dropForeignKey('{{%profile_user_id}}', '{{%profile}}');
        $this->addForeignKey('{{%profile_user_id}}', '{{%profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', $restrict);

        /**
         * Social account
         */

        $this->createTable(
            '{{%social_account}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(),
                'provider' => $this->string(255)->notNull(),
                'client_id' => $this->string(255)->notNull(),
                'code' => $this->string(32),
                'email' => $this->string(255),
                'username' => $this->string(255),
                'data' => $this->text(),
                'created_at' => $this->integer(),
            ],
            $tableOptions
        );
        $this->createIndex(
            'idx_social_account_provider_client_id',
            '{{%social_account}}',
            ['provider', 'client_id'],
            true
        );
        $this->createIndex('idx_social_account_code', '{{%social_account}}', 'code', true);
        $this->addForeignKey(
            'fk_social_account_user',
            '{{%social_account}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            $restrict
        );

        /**
         * Token
         */

        $this->createTable(
            '{{%token}}',
            [
                'user_id' => $this->integer(),
                'code' => $this->string(32)->notNull(),
                'type' => $this->smallInteger(6)->notNull(),
                'created_at' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('idx_token_user_id_code_type', '{{%token}}', ['user_id', 'code', 'type'], true);
        $this->addForeignKey('fk_token_user', '{{%token}}', 'user_id', '{{%user}}', 'id', 'CASCADE', $restrict);

        /**
         * Drop tables
         */

        $this->dropTable('{{%user_auth}}');
        $this->dropTable('{{%user_token}}');
        $this->dropTable('{{%role}}');

        /**
         * Shared objects
         */
        $this->addColumn('{{%form}}', 'shared', $this->integer()->defaultValue(0)->after('recaptcha'));
        $this->addColumn('{{%template}}', 'shared', $this->integer()->defaultValue(0)->after('promoted'));
        $this->addColumn('{{%theme}}', 'shared', $this->integer()->defaultValue(0)->after('css'));

        /**
         * Add tables to share objects between specific users: Themes and Templates
         */
        $this->createTable(
            '{{%theme_user}}',
            [
                'theme_id' => $this->integer(11)->notNull(),
                'user_id' => $this->integer(11)->notNull(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ],
            $tableOptions
        );

        $this->createIndex("{{%theme_user_theme_id}}", "{{%theme_user}}", "theme_id");
        $this->createIndex("{{%theme_user_user_id}}", "{{%theme_user}}", "user_id");
        $this->createIndex("{{%theme_user_theme_id_user_id}}", "{{%theme_user}}", ["theme_id", "user_id"], true);

        $this->createTable(
            '{{%template_user}}',
            [
                'template_id' => $this->integer(11)->notNull(),
                'user_id' => $this->integer(11)->notNull(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ],
            $tableOptions
        );

        $this->createIndex("{{%template_user_template_id}}", "{{%template_user}}", "template_id");
        $this->createIndex("{{%template_user_user_id}}", "{{%template_user}}", "user_id");
        $this->createIndex("{{%template_user_template_id_user_id}}", "{{%template_user}}", ["template_id", "user_id"], true);

        /**
         * Add-Ons
         */
        $this->addColumn('{{%addon}}', 'shared', $this->integer()->defaultValue(0)->after('installed'));
        $this->addColumn('{{%addon}}', 'created_by', $this->integer(11)->after('shared'));
        $this->addColumn('{{%addon}}', 'updated_by', $this->integer(11)->after('created_by'));
        $this->addColumn('{{%addon}}', 'created_at', $this->integer()->after('updated_by'));
        $this->addColumn('{{%addon}}', 'updated_at', $this->integer()->after('created_at'));

        $this->createTable(
            '{{%addon_user}}',
            [
                'addon_id' => $this->string(255)->notNull(),
                'user_id' => $this->integer(11)->notNull(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ],
            $tableOptions
        );

        $this->createIndex("{{%addon_user_addon_id}}", "{{%addon_user}}", "addon_id");
        $this->createIndex("{{%addon_user_user_id}}", "{{%addon_user}}", "user_id");
        $this->createIndex("{{%addon_user_addon_id_user_id}}", "{{%addon_user}}", ["addon_id", "user_id"], true);

        $this->createTable(
            '{{%addon_user_role}}',
            [
                'addon_id' => $this->string(255)->notNull(),
                'role_id' => $this->string(255)->notNull(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ],
            $tableOptions
        );

        $this->createIndex("{{%addon_user_role_addon_id}}", "{{%addon_user_role}}", "addon_id");
        $this->createIndex("{{%addon_user_role_role_id}}", "{{%addon_user_role}}", "role_id");
        $this->createIndex("{{%addon_user_role_addon_id_role_id}}", "{{%addon_user_role}}", ["addon_id", "role_id"], true);

        /**
         * Add foreign keys
         */
        $this->addForeignKey('fk_form_user', '{{%form_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE', $restrict);
        $this->addForeignKey('fk_theme_user', '{{%theme_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE', $restrict);
        $this->addForeignKey('fk_template_user', '{{%template_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE', $restrict);
        $this->addForeignKey('fk_addon_user', '{{%addon_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE', $restrict);

        /**
         * Form Email
         */
        $this->addColumn('{{%form_email}}', 'from_name', $this->string(2555)->after('from'));
        $this->addColumn('{{%form_email}}', 'receipt_copy', $this->integer()->notNull()->defaultValue(0)->after('attach'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        /**
         * Form Email
         */
        $this->dropColumn('{{%form_email}}', 'from_name');
        $this->dropColumn('{{%form_email}}', 'receipt_copy');

        /**
         * Drop foreign keys
         */
        $this->dropForeignKey('fk_form_user', '{{%form_user}}');
        $this->dropForeignKey('fk_theme_user', '{{%theme_user}}');
        $this->dropForeignKey('fk_template_user', '{{%template_user}}');
        $this->dropForeignKey('fk_addon_user', '{{%addon_user}}');

        /**
         * Drop columns to Addon
         */
        $this->dropColumn('{{%addon}}', 'shared');
        $this->dropColumn('{{%addon}}', 'created_by');
        $this->dropColumn('{{%addon}}', 'updated_by');
        $this->dropColumn('{{%addon}}', 'created_at');
        $this->dropColumn('{{%addon}}', 'updated_at');

        /**
         * Drop tables to share object between users
         */
        $this->dropTable('{{%theme_user}}');
        $this->dropTable('{{%template_user}}');
        $this->dropTable('{{%addon_user}}');
        $this->dropTable('{{%addon_user_role}}');

        /**
         * Drop columns to share objects
         */
        $this->dropColumn('{{%form}}', 'shared');
        $this->dropColumn('{{%template}}', 'shared');
        $this->dropColumn('{{%theme}}', 'shared');

        /**
         * Revert migration of RBAC system
         */

        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;
        $schema = $this->db->getSchema()->defaultSchema;

        /**
         * m180523_151638_rbac_updates_indexes_without_prefix
         */

        $this->dropIndex('{{%idx-auth_assignment-user_id}}', $authManager->assignmentTable);
        $this->createIndex('auth_assignment_user_id_idx', $authManager->assignmentTable, 'user_id');

        $this->dropIndex('{{%idx-auth_item-type}}', $authManager->itemTable);
        $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');

        /**
         * m170907_052038_rbac_add_index_on_auth_assignment_user_id
         */

        $this->dropIndex($this->index, $authManager->assignmentTable);

        /**
         * m140506_102106_rbac_init
         */

        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);

        /**
         * Revert migration from new User system
         *
         * Note: Only database structure. User data cannot be recovered.
         */

        /**
         * Recreate tables
         */

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->execute("SET foreign_key_checks = 0;");

        $this->createTable('{{%user_auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'provider' => $this->string(255)->notNull(),
            'provider_id' => $this->string(255)->notNull(),
            'provider_attributes' => $this->text()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('{{%user_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'type' => $this->smallInteger()->notNull(),
            'token' => $this->string(255)->notNull(),
            'data' => $this->string(255),
            'created_at' => $this->timestamp(),
            'expired_at' => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'can_admin' => $this->smallInteger()->notNull()->defaultValue(0),
            'can_edit_own_content' => $this->smallInteger()->notNull()->defaultValue(0),
        ], $tableOptions);

        /**
         * Social account
         */

        $this->dropTable('{{%social_account}}');

        /**
         * Token
         */

        $this->dropTable('{{%token}}');

        /**
         * Profile
         */

        $this->dropColumn('{{%profile}}', 'public_email');
        $this->dropColumn('{{%profile}}', 'gravatar_email');
        $this->dropColumn('{{%profile}}', 'gravatar_id');
        $this->dropColumn('{{%profile}}', 'location');
        $this->dropColumn('{{%profile}}', 'website');
        $this->dropColumn('{{%profile}}', 'bio');

        $this->renameColumn('{{%profile}}', 'name', 'full_name');

        $this->addColumn('{{%profile}}', 'created_at', $this->integer());
        $this->addColumn('{{%profile}}', 'updated_at', $this->integer());
        $this->addColumn('{{%profile}}', 'avatar', $this->string());
        $this->addColumn('{{%profile}}', 'company', $this->string());
        $this->addColumn('{{%profile}}', 'id', $this->integer());

        /**
         * User
         */

        $this->renameColumn('{{%user}}', 'password_hash', 'password');
        $this->renameColumn('{{%user}}', 'registration_ip', 'created_ip');
        $this->renameColumn('{{%user}}', 'last_login_ip', 'logged_in_ip');
        $this->dropColumn('{{%user}}', 'unconfirmed_email');
        $this->dropColumn('{{%user}}', 'flags');
        $this->dropColumn('{{%user}}', 'confirmed_at');
        $this->dropColumn('{{%user}}', 'auth_tf_key');
        $this->dropColumn('{{%user}}', 'auth_tf_enabled');
        $this->dropColumn('{{%user}}', 'password_changed_at');
        $this->dropColumn('{{%user}}', 'gdpr_consent');
        $this->dropColumn('{{%user}}', 'gdpr_consent_date');
        $this->dropColumn('{{%user}}', 'gdpr_deleted');

        $this->alterColumn('{{%user}}', 'auth_key', $this->string(255));
        // last_login_at => logged_in_at
        $this->addColumn('{{%user}}', 'logged_in_at_ts', $this->timestamp());
        $this->update('{{%user}}', ['logged_in_at_ts' => new Expression('FROM_UNIXTIME(last_login_at)')]);
        $this->dropColumn('{{%user}}', 'last_login_at');
        $this->renameColumn('{{%user}}', 'logged_in_at_ts', 'logged_in_at');
        // created_at
        $this->addColumn('{{%user}}', 'created_at_ts', $this->timestamp());
        $this->update('{{%user}}', ['created_at_ts' => new Expression('FROM_UNIXTIME(created_at)')]);
        $this->dropColumn('{{%user}}', 'created_at');
        $this->renameColumn('{{%user}}', 'created_at_ts', 'created_at');
        // updated_at
        $this->addColumn('{{%user}}', 'updated_at_ts', $this->timestamp());
        $this->update('{{%user}}', ['updated_at_ts' => new Expression('FROM_UNIXTIME(updated_at)')]);
        $this->dropColumn('{{%user}}', 'updated_at');
        $this->renameColumn('{{%user}}', 'updated_at_ts', 'updated_at');

        $this->addColumn('{{%user}}', 'role_id', $this->integer()->notNull()->after('id'));
        $this->addColumn('{{%user}}', 'status', $this->smallInteger()->notNull()->after('role_id'));
        $this->addColumn('{{%user}}', 'access_token', $this->string()->after('auth_key'));
        $this->addForeignKey('{{%user_role_id}}', '{{%user}}', 'role_id', '{{%role}}', 'id');

        // insert role data
        $columns = ['name', 'can_admin', 'can_edit_own_content', 'created_at'];
        $this->batchInsert('{{%role}}', $columns, [
            ['Admin', 1, 1, date('Y-m-d H:i:s')],
            ['Basic User', 0, 0, date('Y-m-d H:i:s')],
            ['Advanced User', 0, 1, date('Y-m-d H:i:s')],
        ]);

        $this->execute("SET foreign_key_checks = 1;");
    }

    protected function buildFkClause($delete = '', $update = '')
    {
        if ($this->isMSSQL()) {
            return '';
        }

        if ($this->isOracle()) {
            return ' ' . $delete;
        }

        return implode(' ', ['', $delete, $update]);
    }

    protected function initRbacSettings()
    {
        $authManager = $this->getAuthManager();


        /**
         * Rules / Constrains
         */

        // This rule is applied by default
        // Users only can manage their own objects
        $authorRule = new AuthorRule();
        $authManager->add($authorRule);

        $sharedRule = new SharedRule();
        $authManager->add($sharedRule);

        $notAuthorRule = new NotAuthorRule();
        $authManager->add($notAuthorRule);

        /**
         * Permissions
         */

        $permissionList = [
            [
                'name' => 'manageSite',
                'description' => 'Manage Site',
                'nested' => [
                    [
                        'name' => 'configureSite',
                        'description' => 'Configure Site',
                    ],
                    [
                        'name' => 'configureMailServer',
                        'description' => 'Configure Mail Server',
                    ],
                    [
                        'name' => 'accessPerformanceTools',
                        'description' => 'Access Performance Tools',
                    ],
                    [
                        'name' => 'migrateData',
                        'description' => 'Migrate Data (Import / Export Forms)'
                    ],
                    [
                        'name' => 'performUpdates',
                        'description' => 'Perform Application Updates'
                    ]
                ]
            ],
            [
                'name' => 'manageUsers',
                'description' => 'Manage Users',
                'nested' => [
                    [
                        'name' => 'createUsers',
                        'description' => 'Create Users',
                    ],
                    [
                        'name' => 'viewUsers',
                        'description' => 'View Users',
                    ],
                    [
                        'name' => 'updateUsers',
                        'description' => 'Update Users',
                    ],
                    [
                        'name' => 'deleteUsers',
                        'description' => 'Delete Users',
                    ],
                    [
                        'name' => 'impersonateUsers',
                        'description' => 'Impersonate Users',
                    ],
                    [
                        'name' => 'confirmUsers',
                        'description' => 'Confirm Users',
                    ],
                    [
                        'name' => 'blockUsers',
                        'description' => 'Block Users',
                    ],
                    [
                        'name' => 'assignUserPermissions',
                        'description' => 'Assign User Permissions',
                    ],
                    [
                        'name' => 'resetUserPasswords',
                        'description' => 'Reset User Password',
                    ],
                    [
                        'name' => 'forcePasswordChange',
                        'description' => 'Force Password Change',
                    ],
                    [
                        'name' => 'manageRoles',
                        'description' => 'Manage Roles',
                    ],
                    [
                        'name' => 'managePermissions',
                        'description' => 'Manage Permissions',
                    ],
                    [
                        'name' => 'manageRules',
                        'description' => 'Manage Rules',
                    ],
                    [
                        'name' => 'selectUsers',
                        'description' => 'Select Users',
                    ],
                    [
                        'name' => 'viewBulkActionsInUsers',
                        'description' => 'View Bulk Actions In Users',
                    ],
                ]
            ],
            [
                'name' => 'manageForms',
                'description' => 'Manage Forms',
                'nested' => [
                    [
                        'name' => 'manageOwnForms',
                        'description' => 'Manage Own Forms',
                        'nested' => [
                            [
                                'name' => 'viewOwnForms',
                                'description' => 'View Own Forms',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'updateOwnForms',
                                'description' => 'Update Own Forms',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'deleteOwnForms',
                                'description' => 'Delete Own Forms',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'configureOwnForms',
                                'description' => 'Config Own Forms',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'configureOwnFormsWithAddons',
                                'description' => 'Config Own Forms With Addons',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'copyOwnForms',
                                'description' => 'Copy Own Forms',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'shareOwnForms',
                                'description' => 'Share Own Forms with Other Users',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'publishOwnForms',
                                'description' => 'Publish Own Forms',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'accessOwnFormReports',
                                'description' => 'Access Own Form Reports',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'accessOwnFormStats',
                                'description' => 'Access Own Form Stats',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'resetOwnFormStats',
                                'description' => 'Reset Own Form Stats',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'changeOwnFormsOwner',
                                'description' => 'Change Own Forms Owner',
                                'rules' => [$authorRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'manageSharedForms',
                        'description' => "Manage Shared Forms",
                        'nested' => [
                            [
                                'name' => 'viewSharedForms',
                                'description' => 'View Shared Forms',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'updateSharedForms',
                                'description' => 'Update Shared Forms',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'deleteSharedForms',
                                'description' => 'Delete Shared Forms',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'configureSharedForms',
                                'description' => 'Config Shared Forms',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'configureSharedFormsWithAddons',
                                'description' => 'Config Shared Forms With Addons',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'copySharedForms',
                                'description' => 'Copy Shared Forms',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'shareSharedForms',
                                'description' => 'Share Shared Forms with Other Users',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'publishSharedForms',
                                'description' => 'Publish Shared Forms',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'accessSharedFormReports',
                                'description' => 'Access Shared Form Reports',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'accessSharedFormStats',
                                'description' => 'Access Shared Form Stats',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'resetSharedFormStats',
                                'description' => 'Reset Shared Form Stats',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'changeSharedFormsOwner',
                                'description' => 'Change Shared Forms Owner',
                                'rules' => [$sharedRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'manageOtherForms',
                        'description' => 'Manage Other Authors\' Forms',
                        'nested' => [
                            [
                                'name' => 'viewOtherForms',
                                'description' => 'View Other Authors\' Forms',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'updateOtherForms',
                                'description' => 'Update Other Authors\' Forms',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'deleteOtherForms',
                                'description' => 'Delete Other Authors\' Forms',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'configureOtherForms',
                                'description' => 'Configure Other Authors\' Forms',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'configureOtherFormsWithAddons',
                                'description' => 'Configure Other Authors\' Forms With Add-Ons',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'copyOtherForms',
                                'description' => 'Copy Other Authors\' Forms',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'shareOtherForms',
                                'description' => 'Share Other Forms with Other Users',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'publishOtherForms',
                                'description' => 'Publish Other Authors\' Forms',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'accessOtherFormReports',
                                'description' => 'Access Other Authors\' Form Reports',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'accessOtherFormStats',
                                'description' => 'Access Other Authors\' Form Stats',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'resetOtherFormStats',
                                'description' => 'Reset Other Authors\' Form Stats',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'changeOtherFormsOwner',
                                'description' => 'Change Other Authors\' Forms Owner',
                                'rules' => [$notAuthorRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'createForms',
                        'description' => 'Create Forms',
                        'parents' => [
                            'manageOwnForms'
                        ],
                    ],
                    [
                        'name' => 'viewForms',
                        'description' => 'View Forms',
                        'parents' => [
                            'viewOwnForms', 'viewSharedForms', 'viewOtherForms'
                        ],
                    ],
                    [
                        'name' => 'updateForms',
                        'description' => 'Update Forms',
                        'parents' => [
                            'updateOwnForms', 'updateSharedForms', 'updateOtherForms'
                        ],
                    ],
                    [
                        'name' => 'deleteForms',
                        'description' => 'Delete Forms',
                        'parents' => [
                            'deleteOwnForms', 'deleteSharedForms', 'deleteOtherForms'
                        ],
                    ],
                    [
                        'name' => 'configureForms',
                        'description' => 'Configure Forms',
                        'parents' => [
                            'configureOwnForms', 'configureSharedForms', 'configureOtherForms'
                        ],
                    ],
                    [
                        'name' => 'configureFormsWithAddons',
                        'description' => 'Configure Forms With Add-Ons',
                        'parents' => [
                            'configureOwnFormsWithAddons', 'configureSharedFormsWithAddons', 'configureOtherFormsWithAddons'
                        ],
                    ],
                    [
                        'name' => 'copyForms',
                        'description' => 'Copy Forms',
                        'parents' => [
                            'copyOwnForms', 'copySharedForms', 'copyOtherForms'
                        ],
                    ],
                    [
                        'name' => 'shareForms',
                        'description' => 'Share Forms with Other Users',
                        'parents' => [
                            'shareOwnForms', 'shareSharedForms', 'shareOtherForms'
                        ],
                    ],
                    [
                        'name' => 'publishForms',
                        'description' => 'Publish Forms',
                        'parents' => [
                            'publishOwnForms', 'publishSharedForms', 'publishOtherForms'
                        ],
                    ],
                    [
                        'name' => 'accessFormReports',
                        'description' => 'Access Form Reports',
                        'parents' => [
                            'accessOwnFormReports', 'accessSharedFormReports', 'accessOtherFormReports'
                        ],
                    ],
                    [
                        'name' => 'accessFormStats',
                        'description' => 'Access Form Stats',
                        'parents' => [
                            'accessOwnFormStats', 'accessSharedFormStats', 'accessOtherFormStats'
                        ],
                    ],
                    [
                        'name' => 'resetFormStats',
                        'description' => 'Reset Form Stats',
                        'parents' => [
                            'resetOwnFormStats', 'resetSharedFormStats', 'resetOtherFormStats'
                        ],
                    ],
                    [
                        'name' => 'changeFormsOwner',
                        'description' => 'Change Forms Owner',
                        'parents' => [
                            'changeOwnFormsOwner', 'changeSharedFormsOwner', 'changeOtherFormsOwner'
                        ],
                    ],
                    [
                        'name' => 'viewBulkActionsInForms',
                        'description' => 'View Bulk Actions In Forms',
                    ],
                ]
            ],
            [
                'name' => 'manageTemplates',
                'description' => 'Manage Templates',
                'nested' => [
                    [
                        'name' => 'manageOwnTemplates',
                        'description' => 'Manage Own Templates',
                        'nested' => [
                            [
                                'name' => 'viewOwnTemplates',
                                'description' => 'View Own Templates',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'updateOwnTemplates',
                                'description' => 'Update Own Templates',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'deleteOwnTemplates',
                                'description' => 'Delete Own Templates',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'copyOwnTemplates',
                                'description' => 'Copy Own Templates',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'shareOwnTemplates',
                                'description' => 'Share Own Templates',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'changeOwnTemplatesOwner',
                                'description' => 'Change Own Templates Owner',
                                'rules' => [$authorRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'manageSharedTemplates',
                        'description' => "Manage Shared Templates",
                        'nested' => [
                            [
                                'name' => 'viewSharedTemplates',
                                'description' => 'View Shared Templates',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'updateSharedTemplates',
                                'description' => 'Update Shared Templates',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'deleteSharedTemplates',
                                'description' => 'Delete Shared Templates',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'copySharedTemplates',
                                'description' => 'Copy Shared Templates',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'shareSharedTemplates',
                                'description' => 'Share Shared Templates',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'changeSharedTemplatesOwner',
                                'description' => 'Change Shared Templates Owner',
                                'rules' => [$sharedRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'manageOtherTemplates',
                        'description' => 'Manage Other Authors\' Templates',
                        'nested' => [
                            [
                                'name' => 'viewOtherTemplates',
                                'description' => 'View Other Authors\' Templates',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'updateOtherTemplates',
                                'description' => 'Update Other Authors\' Templates',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'deleteOtherTemplates',
                                'description' => 'Delete Other Authors\' Templates',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'copyOtherTemplates',
                                'description' => 'Copy Other Authors\' Templates',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'shareOtherTemplates',
                                'description' => 'Share Other Authors\' Templates',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'changeOtherTemplatesOwner',
                                'description' => 'Change Other Authors\' Templates Owner',
                                'rules' => [$notAuthorRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'createTemplates',
                        'description' => 'Create Templates',
                        'parents' => [
                            'manageOwnTemplates'
                        ],
                    ],
                    [
                        'name' => 'viewTemplates',
                        'description' => 'View Templates',
                        'parents' => [
                            'viewOwnTemplates', 'viewSharedTemplates', 'viewOtherTemplates'
                        ],
                    ],
                    [
                        'name' => 'updateTemplates',
                        'description' => 'Update Templates',
                        'parents' => [
                            'updateOwnTemplates', 'updateSharedTemplates', 'updateOtherTemplates'
                        ],
                    ],
                    [
                        'name' => 'deleteTemplates',
                        'description' => 'Delete Templates',
                        'parents' => [
                            'deleteOwnTemplates', 'deleteSharedTemplates', 'deleteOtherTemplates'
                        ],
                    ],
                    [
                        'name' => 'copyTemplates',
                        'description' => 'Copy Templates',
                        'parents' => [
                            'copyOwnTemplates', 'copySharedTemplates', 'copyOtherTemplates'
                        ],
                    ],
                    [
                        'name' => 'shareTemplates',
                        'description' => 'Share Templates with Other Users',
                        'parents' => [
                            'shareOwnTemplates', 'shareSharedTemplates', 'shareOtherTemplates'
                        ],
                    ],
                    [
                        'name' => 'changeTemplatesOwner',
                        'description' => 'Change Templates Owner',
                        'parents' => [
                            'changeOwnTemplatesOwner', 'changeSharedTemplatesOwner', 'changeOtherTemplatesOwner'
                        ],
                    ],
                    [
                        'name' => 'manageTemplateCategories',
                        'description' => 'Manage Template Categories',
                    ],
                    [
                        'name' => 'viewBulkActionsInTemplates',
                        'description' => 'View Bulk Actions In Templates',
                    ],
                ]
            ],
            [
                'name' => 'manageThemes',
                'description' => 'Manage Themes',
                'nested' => [
                    [
                        'name' => 'manageOwnThemes',
                        'description' => 'Manage Own Themes',
                        'nested' => [
                            [
                                'name' => 'viewOwnThemes',
                                'description' => 'View Own Themes',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'updateOwnThemes',
                                'description' => 'Update Own Themes',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'deleteOwnThemes',
                                'description' => 'Delete Own Themes',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'copyOwnThemes',
                                'description' => 'Copy Own Themes',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'shareOwnThemes',
                                'description' => 'Share Own Themes',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'changeOwnThemesOwner',
                                'description' => 'Change Own Themes Owner',
                                'rules' => [$authorRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'manageSharedThemes',
                        'description' => "Manage Shared Themes",
                        'nested' => [
                            [
                                'name' => 'viewSharedThemes',
                                'description' => 'View Shared Themes',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'updateSharedThemes',
                                'description' => 'Update Shared Themes',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'deleteSharedThemes',
                                'description' => 'Delete Shared Themes',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'copySharedThemes',
                                'description' => 'Copy Shared Themes',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'shareSharedThemes',
                                'description' => 'Share Shared Themes',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'changeSharedThemesOwner',
                                'description' => 'Change Shared Themes Owner',
                                'rules' => [$sharedRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'manageOtherThemes',
                        'description' => 'Manage Other Authors\' Themes',
                        'nested' => [
                            [
                                'name' => 'viewOtherThemes',
                                'description' => 'View Other Authors\' Themes',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'updateOtherThemes',
                                'description' => 'Update Other Authors\' Themes',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'deleteOtherThemes',
                                'description' => 'Delete Other Authors\' Themes',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'copyOtherThemes',
                                'description' => 'Copy Other Authors\' Themes',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'shareOtherThemes',
                                'description' => 'Share Other Authors\' Themes',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'changeOtherThemesOwner',
                                'description' => 'Change Other Authors\' Themes Owner',
                                'rules' => [$notAuthorRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'createThemes',
                        'description' => 'Create Themes',
                        'parents' => [
                            'manageOwnThemes'
                        ],
                    ],
                    [
                        'name' => 'viewThemes',
                        'description' => 'View Themes',
                        'parents' => [
                            'viewOwnThemes', 'viewSharedThemes', 'viewOtherThemes'
                        ],
                    ],
                    [
                        'name' => 'updateThemes',
                        'description' => 'Update Themes',
                        'parents' => [
                            'updateOwnThemes', 'updateSharedThemes', 'updateOtherThemes'
                        ],
                    ],
                    [
                        'name' => 'deleteThemes',
                        'description' => 'Delete Themes',
                        'parents' => [
                            'deleteOwnThemes', 'deleteSharedThemes', 'deleteOtherThemes'
                        ],
                    ],
                    [
                        'name' => 'copyThemes',
                        'description' => 'Copy Themes',
                        'parents' => [
                            'copyOwnThemes', 'copySharedThemes', 'copyOtherThemes'
                        ],
                    ],
                    [
                        'name' => 'shareThemes',
                        'description' => 'Share Themes with Other Users',
                        'parents' => [
                            'shareOwnThemes', 'shareSharedThemes', 'shareOtherThemes'
                        ],
                    ],
                    [
                        'name' => 'changeThemesOwner',
                        'description' => 'Change Themes Owner',
                        'parents' => [
                            'changeOwnThemesOwner', 'changeSharedThemesOwner', 'changeOtherThemesOwner'
                        ],
                    ],
                    [
                        'name' => 'viewBulkActionsInThemes',
                        'description' => 'View Bulk Actions In Themes',
                    ],
                ]
            ],
            [
                'name' => 'manageFormSubmissions',
                'description' => 'Manage Submissions',
                'nested' => [
                    [
                        'name' => 'manageOwnFormsSubmissions',
                        'description' => 'Manage Own Forms\' Submissions',
                        'nested' => [
                            [
                                'name' => 'viewOwnFormsSubmissions',
                                'description' => 'View Own Forms\' Submissions',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'updateOwnFormsSubmissions',
                                'description' => 'Update Own Forms\' Submissions',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'deleteOwnFormsSubmissions',
                                'description' => 'Delete Own Forms\' Submissions',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'exportOwnFormsSubmissions',
                                'description' => 'Export Own Forms\' Submissions',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'viewOwnFormsSubmissionsFiles',
                                'description' => 'View Own Forms\' Submissions\' Files',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'deleteOwnFormsSubmissionsFiles',
                                'description' => 'Delete Own Forms\' Submissions\' Files',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'viewOwnFormsSubmissionsComments',
                                'description' => 'View Own Forms\' Submissions\' Comments',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'createOwnFormsSubmissionsComments',
                                'description' => 'Create Own Forms\' Submissions\' Comments',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'deleteOwnFormsSubmissionsComments',
                                'description' => 'Delete Own Forms\' Submissions\' Comments',
                                'rules' => [$authorRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'manageSharedFormsSubmissions',
                        'description' => 'Manage Shared Forms\' Submissions',
                        'nested' => [
                            [
                                'name' => 'viewSharedFormsSubmissions',
                                'description' => 'View Shared Forms\' Submissions',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'updateSharedFormsSubmissions',
                                'description' => 'Update Shared Forms\' Submissions',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'deleteSharedFormsSubmissions',
                                'description' => 'Delete Shared Forms\' Submissions',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'exportSharedFormsSubmissions',
                                'description' => 'Export Shared Forms\' Submissions',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'viewSharedFormsSubmissionsFiles',
                                'description' => 'View Shared Forms\' Submissions\' Files',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'deleteSharedFormsSubmissionsFiles',
                                'description' => 'Delete Shared Forms\' Submissions\' Files',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'viewSharedFormsSubmissionsComments',
                                'description' => 'View Shared Forms\' Submissions\' Comments',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'createSharedFormsSubmissionsComments',
                                'description' => 'Create Shared Forms\' Submissions\' Comments',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'deleteSharedFormsSubmissionsComments',
                                'description' => 'Delete Shared Forms\' Submissions\' Comments',
                                'rules' => [$sharedRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'manageOtherFormsSubmissions',
                        'description' => 'Manage Other Authors\' Forms\' Submissions',
                        'nested' => [
                            [
                                'name' => 'viewOtherFormsSubmissions',
                                'description' => 'View Other Authors\' Forms\' Submissions',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'updateOtherFormsSubmissions',
                                'description' => 'Update Other Authors\' Forms\' Submissions',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'deleteOtherFormsSubmissions',
                                'description' => 'Delete Other Authors\' Forms\' Submissions',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'exportOtherFormsSubmissions',
                                'description' => 'Export Other Authors\' Forms\' Submissions',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'viewOtherFormsSubmissionsFiles',
                                'description' => 'View Other Authors\' Forms\' Submissions\' Files',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'deleteOtherFormsSubmissionsFiles',
                                'description' => 'Delete Other Authors\' Forms\' Submissions\' Files',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'viewOtherFormsSubmissionsComments',
                                'description' => 'View Other Authors\' Forms\' Submissions\' Comments',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'createOtherFormsSubmissionsComments',
                                'description' => 'Create Other Authors\' Forms\' Submissions\' Comments',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'deleteOtherFormsSubmissionsComments',
                                'description' => 'Delete Other Authors\' Forms\' Submissions\' Comments',
                                'rules' => [$notAuthorRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'createFormSubmissions',
                        'description' => 'Create Form Submissions',
                        'parents' => [
                            'manageOwnFormsSubmissions'
                        ],
                    ],
                    [
                        'name' => 'viewFormSubmissions',
                        'description' => 'View Form Submissions',
                        'parents' => [
                            'viewOwnFormsSubmissions', 'viewSharedFormsSubmissions', 'viewOtherFormsSubmissions'
                        ],
                    ],
                    [
                        'name' => 'updateFormSubmissions',
                        'description' => 'Update Form Submissions',
                        'parents' => [
                            'updateOwnFormsSubmissions', 'updateSharedFormsSubmissions', 'updateOtherFormsSubmissions'
                        ],
                    ],
                    [
                        'name' => 'deleteFormSubmissions',
                        'description' => 'Delete Form Submissions',
                        'parents' => [
                            'deleteOwnFormsSubmissions', 'deleteSharedFormsSubmissions', 'deleteOtherFormsSubmissions'
                        ],
                    ],
                    [
                        'name' => 'exportFormSubmissions',
                        'description' => 'Export Form Submissions',
                        'parents' => [
                            'exportOwnFormsSubmissions', 'exportSharedFormsSubmissions', 'exportOtherFormsSubmissions'
                        ],
                    ],
                    [
                        'name' => 'viewFormSubmissionFiles',
                        'description' => 'View Form Submission Files',
                        'parents' => [
                            'viewOwnFormsSubmissionsFiles', 'viewSharedFormsSubmissionsFiles', 'viewOtherFormsSubmissionsFiles'
                        ],
                    ],
                    [
                        'name' => 'deleteFormSubmissionFiles',
                        'description' => 'Delete Form Submission Files',
                        'parents' => [
                            'deleteOwnFormsSubmissionsFiles', 'deleteSharedFormsSubmissionsFiles', 'deleteOtherFormsSubmissionsFiles'
                        ],
                    ],
                    [
                        'name' => 'viewFormSubmissionComments',
                        'description' => 'View Form Submission Comments',
                        'parents' => [
                            'viewOwnFormsSubmissionsComments', 'viewSharedFormsSubmissionsComments', 'viewOtherFormsSubmissionsComments'
                        ],
                    ],
                    [
                        'name' => 'createFormSubmissionComments',
                        'description' => 'Create Form Submission Comments',
                        'parents' => [
                            'createOwnFormsSubmissionsComments', 'createSharedFormsSubmissionsComments', 'createOtherFormsSubmissionsComments'
                        ],
                    ],
                    [
                        'name' => 'deleteFormSubmissionComments',
                        'description' => 'Delete Form Submission Comments',
                        'parents' => [
                            'deleteOwnFormsSubmissionsComments', 'deleteSharedFormsSubmissionsComments', 'deleteOtherFormsSubmissionsComments'
                        ],
                    ],
                    [
                        'name' => 'viewBulkActionsInFormSubmissions',
                        'description' => 'View Bulk Actions In Form Submissions',
                    ],
                ]
            ],
            [
                'name' => 'manageAddons',
                'description' => 'Manage Addons',
                'nested' => [
                    [
                        'name' => 'manageOwnAddons',
                        'description' => 'Manage Own Addons',
                        'nested' => [
                            [
                                'name' => 'viewOwnAddons',
                                'description' => 'View Own Addons',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'updateOwnAddons',
                                'description' => 'Update Own Addons',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'installOwnAddons',
                                'description' => 'Install Own Addons',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'uninstallOwnAddons',
                                'description' => 'Uninstall Own Addons',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'refreshOwnAddons',
                                'description' => 'Refresh Own Addons',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'configureOwnAddons',
                                'description' => 'Configure Own Addons',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'shareOwnAddons',
                                'description' => 'Share Own Addons',
                                'rules' => [$authorRule->name],
                            ],
                            [
                                'name' => 'changeOwnAddonsOwner',
                                'description' => 'Change Own Addons Owner',
                                'rules' => [$authorRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'manageSharedAddons',
                        'description' => "Manage Shared Addons",
                        'nested' => [
                            [
                                'name' => 'viewSharedAddons',
                                'description' => 'View Shared Addons',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'updateSharedAddons',
                                'description' => 'Update Shared Addons',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'installSharedAddons',
                                'description' => 'Install Shared Addons',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'uninstallSharedAddons',
                                'description' => 'Uninstall Shared Addons',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'refreshSharedAddons',
                                'description' => 'Refresh Shared Addons',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'configureSharedAddons',
                                'description' => 'Configure Shared Addons',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'shareSharedAddons',
                                'description' => 'Share Shared Addons',
                                'rules' => [$sharedRule->name],
                            ],
                            [
                                'name' => 'changeSharedAddonsOwner',
                                'description' => 'Change Shared Addons Owner',
                                'rules' => [$sharedRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'manageOtherAddons',
                        'description' => 'Manage Other Authors\' Addons',
                        'nested' => [
                            [
                                'name' => 'viewOtherAddons',
                                'description' => 'View Other Authors\' Addons',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'updateOtherAddons',
                                'description' => 'Update Other Authors\' Addons',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'installOtherAddons',
                                'description' => 'Install Other Authors\' Addons',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'uninstallOtherAddons',
                                'description' => 'Uninstall Other Authors\' Addons',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'refreshOtherAddons',
                                'description' => 'Refresh Other Authors\' Addons',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'configureOtherAddons',
                                'description' => 'Configure Other Addons',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'shareOtherAddons',
                                'description' => 'Share Other Authors\' Addons',
                                'rules' => [$notAuthorRule->name],
                            ],
                            [
                                'name' => 'changeOtherAddonsOwner',
                                'description' => 'Change Other Authors\' Addons Owner',
                                'rules' => [$notAuthorRule->name],
                            ],
                        ]
                    ],
                    [
                        'name' => 'viewAddons',
                        'description' => 'View Addons',
                        'parents' => [
                            'viewOwnAddons', 'viewSharedAddons', 'viewOtherAddons'
                        ],
                    ],
                    [
                        'name' => 'updateAddons',
                        'description' => 'Update Addons',
                        'parents' => [
                            'updateOwnAddons', 'updateSharedAddons', 'updateOtherAddons'
                        ],
                    ],
                    [
                        'name' => 'installAddons',
                        'description' => 'Install Addons',
                        'parents' => [
                            'installOwnAddons', 'installSharedAddons', 'installOtherAddons'
                        ],
                    ],
                    [
                        'name' => 'uninstallAddons',
                        'description' => 'Uninstall Addons',
                        'parents' => [
                            'uninstallOwnAddons', 'uninstallSharedAddons', 'uninstallOtherAddons'
                        ],
                    ],
                    [
                        'name' => 'refreshAddons',
                        'description' => 'Refresh Addons',
                        'parents' => [
                            'refreshOwnAddons', 'refreshSharedAddons', 'refreshOtherAddons'
                        ],
                    ],
                    [
                        'name' => 'configureAddons',
                        'description' => 'Configure Addons',
                        'parents' => [
                            'configureOwnAddons', 'configureSharedAddons', 'configureOtherAddons'
                        ],
                    ],
                    [
                        'name' => 'shareAddons',
                        'description' => 'Share Addons with Other Users',
                        'parents' => [
                            'shareOwnAddons', 'shareSharedAddons', 'shareOtherAddons'
                        ],
                    ],
                    [
                        'name' => 'changeAddonsOwner',
                        'description' => 'Change Addons Owner',
                        'parents' => [
                            'changeOwnAddonsOwner', 'changeSharedAddonsOwner', 'changeOtherAddonsOwner'
                        ],
                    ],
                    [
                        'name' => 'viewBulkActionsInAddons',
                        'description' => 'View Bulk Actions In Addons',
                    ],
                ]
            ],
        ];

        // First level
        $permissions = [];
        foreach ($permissionList as $p) {
            $permissions[$p['name']] = $authManager->createPermission($p['name']);
            $permissions[$p['name']]->description = $p['description'];
            if (!empty($p['rules'])) {
                foreach ($p['rules'] as $rule) {
                    $permissions[$p['name']]->ruleName = $rule;
                }
            }
            $authManager->add($permissions[$p['name']]);
            if (!empty($p['parents'])) {
                foreach ($p['parents'] as $parentPermission) {
                    $authManager->addChild($permissions[$parentPermission], $permissions[$p['name']]);
                }
            }

            // Second level
            if (!empty($p['nested'])) {
                foreach ($p['nested'] as $c) {
                    $permissions[$c['name']] = $authManager->createPermission($c['name']);
                    $permissions[$c['name']]->description = $c['description'];
                    if (!empty($c['rules'])) {
                        foreach ($c['rules'] as $rule) {
                            $permissions[$c['name']]->ruleName = $rule;
                        }
                    }
                    $authManager->add($permissions[$c['name']]);
                    if (!empty($c['parents'])) {
                        foreach ($c['parents'] as $parentPermission) {
                            $authManager->addChild($permissions[$parentPermission], $permissions[$c['name']]);
                        }
                    }
                    $authManager->addChild($permissions[$p['name']], $permissions[$c['name']]);

                    // Last level
                    if (!empty($c['nested'])) {
                        foreach ($c['nested'] as $l) {
                            $permissions[$l['name']] = $authManager->createPermission($l['name']);
                            $permissions[$l['name']]->description = $l['description'];
                            if (!empty($l['rules'])) {
                                foreach ($l['rules'] as $rule) {
                                    $permissions[$l['name']]->ruleName = $rule;
                                }
                            }
                            $authManager->add($permissions[$l['name']]);
                            if (!empty($l['parents'])) {
                                foreach ($l['parents'] as $parentPermission) {
                                    $authManager->addChild($permissions[$parentPermission], $permissions[$l['name']]);
                                }
                            }
                            $authManager->addChild($permissions[$c['name']], $permissions[$l['name']]);
                        }
                    }
                }
            }
        }

        /**
         * Roles
         */

        $adminRole = $authManager->createRole('administrator');
        $adminRole->description = 'Role: Administrator';
        $authManager->add($adminRole);

        $adminPermissions = [
            'manageSite',
            'manageUsers',
            'manageForms',
            'manageFormSubmissions',
            'manageTemplates',
            'manageThemes',
            'manageAddons',
        ];

        foreach ($adminPermissions as $permission) {
            $authManager->addChild($adminRole, $permissions[$permission]);
        }

        $userRole = $authManager->createRole('user');
        $userRole->description = 'Role: User';
        $authManager->add($userRole);

        $userPermissions = [
            'manageOwnForms', 'viewSharedForms', 'updateSharedForms', 'publishSharedForms', 'configureSharedForms', 'configureSharedFormsWithAddons',
            'manageOwnFormsSubmissions', 'manageSharedFormsSubmissions',
            'manageOwnThemes', 'viewSharedThemes',
            'manageOwnTemplates', 'viewSharedTemplates',
            'viewSharedAddons',
        ];

        foreach ($userPermissions as $permission) {
            $authManager->addChild($userRole, $permissions[$permission]);
        }

        /**
         * Assignments
         */

        foreach ($this->currentUsers as $user) {
            if (!empty($user['id']) && !empty($user['role_id'])) {
                $role = (int) $user['role_id'] === 1 ? $adminRole : $userRole;
                $authManager->assign($role, $user['id']);
            }
        }

    }

}
