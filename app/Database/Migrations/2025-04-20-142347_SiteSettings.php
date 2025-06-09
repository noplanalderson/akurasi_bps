<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class SiteSettings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'site_id' => [
                'type'       => 'CHAR',
                'constraint' => '255',
            ],
            'site_name' => [
                'type' => 'CHAR',
                'constraint' => '255',
            ],
            'site_name_alt' => [
                'type' => 'CHAR',
                'constraint' => '100',
            ],
            'site_description' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
            ],
            'site_author' => [
                'type' => 'CHAR',
                'constraint' => '100',
            ],
            'site_logo' => [
                'type' => 'CHAR',
                'constraint' => '255',
            ],
            'info_adm' => [
                'type' => 'JSON',
                'null' => true
            ],
            'pedoman_adm_keuangan' => [
                'type' => 'JSON',
                'null' => true
            ],
            'updated_at' => [
                'type'   => 'DATETIME',
                'null'   => true,
                'default'=> new RawSql('CURRENT_TIMESTAMP')
            ],
        ]);

        $this->forge->addKey('site_id', true);
        $this->forge->createTable('tb_site_settings', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_site_settings', true);
    }
}
