<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            'user_id'       => Uuid::uuid4()->toString(),
            'group_id'      => '4cfb12f4-fb34-435b-b198-e56ac0bf5c81',
            'user_name'     => 'administrator',
            'user_realname' => 'Administrator',
            'user_password' => password_hash('@Admin123', PASSWORD_ARGON2ID, ['memory_cost' => 1 << 17, 'time_cost' => 16, 'threads' => 10]),
            'user_email'    => 'admin@somewhere.com',
            'user_picture'  => 'user.svg',
            'is_active'     => 1
        ];
        
        $this->db->table('tb_users')->insert($data);
    }
}
