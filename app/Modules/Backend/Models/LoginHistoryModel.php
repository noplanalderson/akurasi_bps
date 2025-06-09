<?php

namespace App\Modules\Backend\Models;

use CodeIgniter\Model;

class LoginHistoryModel extends Model
{
    protected $table = 'tb_login_history';
    protected $primaryKey = '_id';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        '_id',
        'user_id',
        'ip_address',
        'timestamp',
        'browser',
        'platform'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    public function getUserLogin($request)
    {
        return $this->select("timestamp, browser, platform, ip_address")
                    ->where('timestamp >= ', $request['startDate'])
                    ->where('timestamp <= ', $request['endDate'])
                    ->groupStart()
                        ->like('browser', $request['query'], 'both')
                        ->orLike('platform', $request['query'], 'both')
                    ->groupEnd()
                    ->where('user_id', session()->get('uid'))
                    ->orderBy($request['orderby'], $request['dir'])
                    ->get((int)$request['length'], (int)$request['start'])->getResultArray();
    }

    public function countUserLogin($request)
    {
        return $this->select('_id')
                    ->where('user_id', session()->get('uid'))
                    ->get()->getNumRows();
    }

    public function countLoginFiltered($request)
    {
        return $this->select('_id')
                    ->groupStart()
                        ->like('browser', $request['query'], 'both')
                        ->orLike('platform', $request['query'], 'both')
                    ->groupEnd()
                    ->where('user_id', session()->get('uid'))
                    ->where('timestamp >= ', $request['startDate'])
                    ->where('timestamp <= ', $request['endDate'])
                    ->get()->getNumRows();
    }
}