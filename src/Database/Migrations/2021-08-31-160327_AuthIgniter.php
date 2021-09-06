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
        $this->createRolesTable();
        $this->createUserRolesTable();
        $this->createEmailVerificationTokensTable();
        $this->createResetPasswordTokensTable();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') {
            $this->forge->dropForeignKey('authigniter_user_roles', 'user_id');
            $this->forge->dropForeignKey('authigniter_user_roles', 'role_id');
        }

        $this->forge->dropTable('users', true);
        $this->forge->dropTable('authigniter_roles', true);
        $this->forge->dropTable('authigniter_user_roles', true);
        $this->forge->dropTable('authigniter_email_verification_tokens', true);
        $this->forge->dropTable('authigniter_reset_password_tokens', true);
    }

    /**
     * Create users table
     */
    protected function createUsersTable()
    {
        $this->forge->addField([
            'id'                => ['type' => 'varchar', 'constraint' => 255],
            'email'             => ['type' => 'varchar', 'constraint' => 255],
            'username'          => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'password'          => ['type' => 'varchar', 'constraint' => 255],
            'active'            => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
            'email_is_verified' => ['type' => 'tinyint', 'constraint' => 1, 'null' => true],
            'created_at'        => ['type' => 'datetime'],
            'updated_at'        => ['type' => 'datetime'],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('username');

        $this->forge->createTable('users', true);
    }

    /**
     * Create authigniter_roles table
     */
    protected function createRolesTable()
    {
        $this->forge->addField([
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('name');
        
        $this->forge->createTable('authigniter_roles', true);
    }

    /**
     * Create authigniter_user_roles table
     */
    protected function createUserRolesTable()
    {
        $this->forge->addField([
            'id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'varchar', 'constraint' => 255],
            'role_id' => ['type' => 'int', 'constraint' => 11],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('user_id');
        $this->forge->addKey('role_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('role_id', 'authigniter_roles', 'id', '', 'CASCADE');

        $this->forge->createTable('authigniter_user_roles', true);
    }

    protected function createEmailVerificationTokensTable()
    {
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'      => ['type' => 'varchar', 'constraint' => 255],
            'token'      => ['type' => 'varchar', 'constraint' => 255],
            'created_at' => ['type' => 'datetime'],
            'updated_at' => ['type' => 'datetime'],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('token');

        $this->forge->createTable('authigniter_email_verification_tokens', true);
    }

    protected function createResetPasswordTokensTable()
    {
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'      => ['type' => 'varchar', 'constraint' => 255],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255],
            'token'      => ['type' => 'varchar', 'constraint' => 255],
            'created_at' => ['type' => 'datetime'],
            'updated_at' => ['type' => 'datetime'],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('token');

        $this->forge->createTable('authigniter_reset_password_tokens', true);
    }
}
