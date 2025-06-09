<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class DocumentModel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'document_id' => [
                'type' => 'CHAR',
                'constraint' => '255',
            ],
            'user_id' => [
                'type' => 'CHAR',
                'constraint' => '255',
            ],
            'category_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'document_classification' => [
                'type'       => 'ENUM',
                'constraint' => ['subbagumum', 'statsos', 'statprod', 'statdist', 'nerwilis', 'ipds'],
            ],
            'document_details' => [
                'type'       => 'VARCHAR',
                'constraint' => '2000',
            ],
            'spj_date' => [
                'type'       => 'DATE'
            ],
            'document_viewers' => [
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

        $this->forge->addKey('document_id', true);
        $this->forge->addForeignKey('user_id', 'tb_users', 'user_id', 'RESTRICT','RESTRICT');
        $this->forge->addForeignKey('category_id', 'tb_categories', 'category_id', 'RESTRICT','RESTRICT');
        $this->forge->createTable('tb_documents', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_documents', true);
    }
}
