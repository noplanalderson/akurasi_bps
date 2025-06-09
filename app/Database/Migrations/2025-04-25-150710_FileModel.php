<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class FileModel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'file_id' => [
                'type' => 'CHAR',
                'constraint' => '255',
            ],
            'document_id' => [
                'type' => 'CHAR',
                'constraint' => '255',
            ],
            'file_name' => [
                'type'       => 'CHAR',
                'constraint' => '255',
            ],
            'file_mime' => [
                'type'       => 'CHAR',
                'constraint' => '100',
            ],
            'file_classification' => [
                'type'       => 'ENUM',
                'constraint' => ['kak', 'form_permintaan', 'sk_kpa', 'surat_tugas', 'mon_kegiatan', 'dok_kegiatan', 'adm_kegiatan'],
            ],
            'file_type' => [
                'type'       => 'ENUM',
                'constraint' => ['jpg', 'jpeg', 'png', 'webp', 'pdf', 'docx', 'doc', 'xlsx', 'xls', 'pptx', 'ppt'],
            ],
            'file_size' => [
                'type'       => 'FLOAT'
            ],
            'file_viewers' => [
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
            'deleted_at' => [
                'type'   => 'DATETIME',
                'null'   => true
            ],
        ]);

        $this->forge->addKey('file_id', true);
        $this->forge->addForeignKey('document_id', 'tb_documents', 'user_id', 'CASCADE','CASCADE');
        $this->forge->createTable('tb_files', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_files', true);
    }
}
