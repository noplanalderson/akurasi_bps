<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BackendMenus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'menu_id' => [
                'type'       => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'menu_label' => [
                'type'       => 'CHAR',
                'constraint' => '100',
            ],
            'menu_slug' => [
                'type'       => 'CHAR',
                'constraint' => '255',
            ],
            'menu_icon' => [
                'type' => 'CHAR',
                'constraint' => '100',
            ],
            'menu_group' => [
                'type'       => 'CHAR',
                'constraint' => '50',
            ],
            'menu_mode' => [
                'type'       => 'ENUM',
                'constraint' => ['r','w'],
            ],
            'menu_sequence' => [
                'type'       => 'TINYINT',
                'constraint' => '4',
                'null'      => true,
            ],
            'menu_location' => [
                'type'    => 'ENUM',
                'constraint' => ['mainmenu', 'submenu', 'btnmenu'],
            ]
        ]);

        $this->forge->addKey('menu_id', true);
        $this->forge->createTable('tb_menus', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_menus', true);
    }
}
