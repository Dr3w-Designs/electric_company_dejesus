<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'first_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'last_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'email' => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'address' => ['type' => 'TEXT', 'null' => true],
            'city' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'state' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'zip_code' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'user_type' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'customer'],
            'is_active' => ['type' => 'BOOLEAN', 'default' => true],
            'email_verified' => ['type' => 'BOOLEAN', 'default' => false],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_accounts');
    }

    public function down()
    {
        $this->forge->dropTable('user_accounts', true);
    }
}
