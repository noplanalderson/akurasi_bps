<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class OrgSettings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'org_id' => [
                'type' => 'CHAR',
                'constraint' => '255',
            ],
            'org_name' => [
                'type' => 'CHAR',
                'constraint' => '255',
            ],
            'org_profile' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'org_slogan' => [
                'type' => 'text',
                'null' => true
            ],
            'org_vision' => [
                'type' => 'VARCHAR',
                'constraint' => '300',
                'null' => true
            ],
            'org_missions' => [
                'type' => 'text',
                'null' => true
            ],
            'org_phone' => [
                'type' => 'CHAR',
                'constraint' => '16',
                'null' => true
            ],
            'org_address' => [
                'type' => 'CHAR',
                'constraint' => '255',
                'null' => true
            ],
            'org_social_media' => [
                'type' => 'JSON',
                'null' => true
            ],
            'org_map' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'updated_at' => [
                'type'   => 'DATETIME',
                'null'   => true,
                'default'=> new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('org_id', true);
        $this->forge->createTable('tb_org_settings', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_org_settings', true);
    }
}
