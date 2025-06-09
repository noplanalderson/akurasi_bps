<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class LoginHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            '_id' => [
                'type'  => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type'       => 'UUID'
            ],
            'timestamp' => [
                'type'       => 'DATETIME',
                'null' => true,
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'browser' => [
                'type' => 'CHAR',
                'constraint' => '100',
            ],
            'platform' => [
                'type' => 'CHAR',
                'constraint' => '100',
            ],
            'ip_address' => [
                'type' => 'CHAR',
                'constraint' => '100',
            ],
        ]);

        $this->forge->addKey('_id', true);
        $this->forge->addForeignKey('user_id', 'tb_users', 'user_id', 'CASCADE','CASCADE');
        $this->forge->createTable('tb_login_history');
    }

    public function down()
    {
        $this->forge->dropTable('tb_login_history');
    }
}
