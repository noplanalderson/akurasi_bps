<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'       => 'CHAR',
                'constraint' => '255',
            ],
            'group_id' => [
                'type'       => 'CHAR',
                'constraint' => '255',
            ],
            'user_realname' => [
                'type'       => 'CHAR',
                'constraint' => '100',
            ],
            'user_name' => [
                'type'       => 'CHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'user_password' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'user_email' => [
                'type'       => 'CHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'user_picture' => [
                'type'       => 'VARCHAR',
                'constraint' => '512',
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('user_id', true);
        $this->forge->addForeignKey('group_id', 'tb_user_groups', 'group_id', 'RESTRICT','RESTRICT');
        $this->forge->createTable('tb_users', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_users', true);
    }
}
