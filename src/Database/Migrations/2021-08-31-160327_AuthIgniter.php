<?php

namespace SweetScar\AuthIgniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class AuthIgniter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createUsersTable();
        $this->createAuthIgniterLoginsTable();
        $this->createAuthIgniterResetPasswordAttemptsTable();
        $this->createAuthIgniterActivationAttemptsTable();
        $this->createAuthIgniterRolesTable();
        $this->createAuthIgniterUserRolesTable();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('authigniter_logins', true);
        $this->forge->dropTable('authigniter_reset_password_attempts', true);
        $this->forge->dropTable('authigniter_activation_attempts', true);
        $this->forge->dropTable('authigniter_roles', true);
        $this->forge->dropTable('authigniter_user_roles', true);
    }

    /**
     * Create users table
     */
    protected function createUsersTable()
    {
        $this->forge->addField([
            'id'          => ['type' => 'varchar', 'constraint' => 255],
            'email'       => ['type' => 'varchar', 'constraint' => 255],
            'username'    => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'password'    => ['type' => 'varchar', 'constraint' => 255],
            'active'      => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
            'verified_at' => ['type' => 'datetime', 'null' => true],
            'created_at'  => ['type' => 'datetime', 'null' => true],
            'updated_at'  => ['type' => 'datetime', 'null' => true],
            'deleted_at'  => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('username');

        $this->forge->createTable('users', true);
    }

    /**
     * Create authigniter_logins table
     */
    protected function createAuthIgniterLoginsTable()
    {
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'user_id'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'login_at'   => ['type' => 'datetime'],
            'success'    => ['type' => 'tinyint', 'constraint' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('email');
        $this->forge->addKey('user_id');
        $this->forge->createTable('authigniter_logins', true);
    }

    /**
     * Create authigniter_reset_password_attempts table
     */
    protected function createAuthIgniterResetPasswordAttemptsTable()
    {
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'      => ['type' => 'varchar', 'constraint' => 255],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255],
            'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('email');
        $this->forge->createTable('authigniter_reset_password_attempts', true);
    }

    /**
     * Create authigniter_activation_attempts table
     */
    protected function createAuthIgniterActivationAttemptsTable()
    {
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255],
            'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('authigniter_activation_attempts', true);
    }

    /**
     * Create authigniter_roles table
     */
    protected function createAuthIgniterRolesTable()
    {
        $this->forge->addField([
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'varchar', 'constraint' => 255],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('name');
        $this->forge->createTable('authigniter_roles', true);
    }

    /**
     * Create authigniter_user_roles table
     */
    protected function createAuthIgniterUserRolesTable()
    {
        $this->forge->addField([
            'id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'varchar', 'constraint' => 255],
            'role_id' => ['type' => 'int', 'constraint' => 11],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('role_id');
        $this->forge->createTable('authigniter_user_roles', true);
    }
}
