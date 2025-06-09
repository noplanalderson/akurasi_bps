<?php

namespace App\Modules\Backend\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'tb_users a';
    protected $primaryKey = 'user_id';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'user_id',
        'user_realname',
        'user_name',
        'user_password',
        'user_email',
        'user_picture',
        'is_active'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    public function getUser(string $user_name) 
    {
        return $this->select('a.*, b.*')
                    ->join('tb_user_groups b', 'a.group_id = b.group_id', 'inner')
                    ->groupStart()
                        ->where('a.user_name', $user_name)
                        ->orWhere('a.user_email', $user_name)
                    ->groupEnd()
                    ->where('a.is_active', 1)
                    ->where('a.deleted_at IS NULL')
                    ->get()->getRow();
    }
}
