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
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'             => ['type' => 'varchar', 'constraint' => 255],
            'username'          => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'password'          => ['type' => 'varchar', 'constraint' => 255],
            'email_verified_at' => ['type' => 'datetime', 'null' => true],
            'remember_token'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('username');

        $this->forge->createTable('users', true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
