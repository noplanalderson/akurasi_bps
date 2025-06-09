<?php

namespace App\Modules\Backend\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'tb_users';
    protected $primaryKey = 'user_id';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'user_id', 'group_id', 'user_realname', 'user_name', 'user_email', 'user_password', 'user_picture', 'is_active', 'created_at', 'updated_at', 'deleted_at'
    ];
    
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['user_password'])) {
            return $data;
        }

        $data['data']['user_password'] = password_hash($data['data']['user_password'], PASSWORD_ARGON2ID, [
            'memory_cost ' => 6836,
            'time_cost' => 8,
            'threads' => 10
        ]);

        return $data;
    }

    public function getAccounts(int $start, int $length, string $orderby, string $dir, ?string $query)
    {
        return $this->select("tb_users.*, b.group_name")
                    ->join('tb_user_groups b', 'tb_users.group_id = b.group_id', 'inner')
                    ->groupStart()
                        ->like('tb_users.user_name', $query, 'both')
                        ->orLike('tb_users.user_realname', $query, 'both')
                        ->orLike('b.group_name', $query, 'both')
                    ->groupEnd()
                    ->where('tb_users.deleted_at IS NULL')
                    ->orderBy($orderby, $dir)
                    ->get($length, $start)->getResultArray();
    }
}