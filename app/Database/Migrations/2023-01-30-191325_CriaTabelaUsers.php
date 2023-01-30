<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '240',
            ],
            'password_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '240',
            ],
            'reset_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '80',
                'null' => true,
                'default' => null
            ],
            'reset_expires_date' => [
                'type'       => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => '240',
                'null' => true,
                'default' => null
            ],
            'active' => [
                'type'       => 'BOOLEAN',
                'null' => false
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null' => true,
                'default' => null
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
