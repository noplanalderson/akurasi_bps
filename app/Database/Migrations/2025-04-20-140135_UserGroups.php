<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserGroups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'group_id' => [
                'type'       => 'CHAR',
                'constraint' => '255',
            ],
            'group_name' => [
                'type'       => 'CHAR',
                'constraint' => '255',
                'unique' => true
            ],
            'index_page' => [
                'type'       => 'CHAR',
                'constraint' => '80',
                'null' => true
            ],
            'read_mode' => [
                'type' => 'ENUM',
                'constraint' => ['r', 'rw'],
            ],
            'roles' => [
                'type'    => 'JSON',
                'null'    => true,
            ],
            'fm_create' => [
                'type'    => 'TINYINT',
                'constraint' => '1',
                'null'    => true,
                'default' => 0
            ],
            'fm_rename' => [
                'type'    => 'TINYINT',
                'constraint' => '1',
                'null'    => true,
                'default' => 0
            ],
            'fm_delete' => [
                'type'    => 'TINYINT',
                'constraint' => '1',
                'null'    => true,
                'default' => 0
            ],
            'post_publish' => [
                'type'    => 'TINYINT',
                'constraint' => '1',
                'null'    => true,
                'default' => 0
            ],
        ]);

        $this->forge->addKey('group_id', true);
        $this->forge->createTable('tb_user_groups', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_user_groups', true);
    }
}
