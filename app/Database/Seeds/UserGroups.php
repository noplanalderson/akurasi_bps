<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserGroups extends Seeder
{
    public function run()
    {
        $getRoles = APPPATH . 'Config/features.json';
        $roles = file_get_contents($getRoles);
        $data = [
            'group_id'   => '4cfb12f4-fb34-435b-b198-e56ac0bf5c81',
            'group_name' => 'administrator',
            'index_page' => 'dashboard',
            'read_mode'  => 'rw',
            'roles'      => $roles,
            'fm_create'  => 1,
            'fm_rename'  => 1,
            'fm_delete'  => 1,
            'post_publish' => 1
        ];
        
        $this->db->table('tb_user_groups')->insert($data);
    }
}
