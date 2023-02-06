<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaGroups extends Migration
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
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => '240',
            ],
            'show' => [
                'type'       => 'BOOLEAN',
                'null' => false,
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
        $this->forge->addUniqueKey('name');
        $this->forge->createTable('groups');
    }

    public function down()
    {
        $this->forge->dropTable('groups');
    }
}
