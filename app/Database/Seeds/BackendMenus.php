<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BackendMenus extends Seeder
{
    public function run()
    {
        $menus = APPPATH . 'Config/features.json';
        $tb_menus = json_decode(file_get_contents($menus), true);

        $this->db->table('tb_menus')->truncate();
        $this->db->table('tb_menus')->insertBatch($tb_menus);
    }
}
