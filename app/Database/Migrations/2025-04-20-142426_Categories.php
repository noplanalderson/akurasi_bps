<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Categories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'category_id' => [
                'type'  => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'category_code' => [
                'type' => 'CHAR',
                'constraint' => '50',
                'unique' => true
            ],
            'category_slug' => [
                'type' => 'CHAR',
                'constraint' => '100',
            ],
            'category_name' => [
                'type' => 'CHAR',
                'constraint' => '255',
            ],
            'category_viewers' => [
                'type'   => 'INT',
                'unsigned' => true,
                'null' => true,
                'default' => 0
            ],
            'created_at' => [
                'type'   => 'DATETIME',
                'null'   => true,
                'default'=> NEW RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type'   => 'DATETIME',
                'null'   => true
            ],
        ]);

        $this->forge->addKey('category_id', true);
        $this->forge->createTable('tb_categories', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_categories', true);
    }
}
