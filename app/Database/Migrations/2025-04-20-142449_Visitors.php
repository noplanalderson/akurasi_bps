<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Visitors extends Migration
{
    public function up()
    {
        $this->forge->addField([
            '_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'last_counter' => [
                'type' => 'DATE',
                'null' => true,
                'default' => new RawSql('CURRENT_DATE')
            ],
            'referred' => [
                'type'       => 'TEXT',
                'null' => true
            ],
            'agent' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'platform' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'UAString' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'ip' => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ],
            'location' => [
                'type'       => 'CHAR',
                'constraint' => '10'
            ]
        ]);

        $this->forge->addKey('_id', true);
        $this->forge->createTable('tb_visitors', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_visitors', true);
    }
}
