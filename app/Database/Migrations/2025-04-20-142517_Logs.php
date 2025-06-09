<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Logs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'log_id' => [
                'type'  => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'log_type' => [
                'type' => 'CHAR',
                'constraint' => '100',
            ],
            'log_content' => [
                'type' => 'CHAR',
                'constraint' => '255',
            ],
            'datetime' => [
                'type'   => 'DATETIME',
                'null'   => true,
                'default'=> new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'log_level' => [
                'type'   => 'TINYINT',
                'contstraint' => '1'
            ],
        ]);

        $this->forge->addKey('log_id', true);
        $this->forge->createTable('tb_logs', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_logs', true);
    }
}
