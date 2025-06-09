<?php

namespace App\Modules\Backend\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table            = 'tb_logs';
    protected $primaryKey       = 'log_id';
    protected $allowedFields    = [
        'log_id', 'log_type', 'log_content', 'datetime', 'log_level'
    ];

    public function getLogs($request)
    {
        return $this->select("*")
                    ->where('datetime >= ', $request['startDate'])
                    ->where('datetime <= ', $request['endDate'])
                    ->groupStart()
                        ->like('log_content', $request['query'], 'both')
                    ->groupEnd()
                    ->orderBy($request['orderby'], $request['dir'])
                    ->get((int)$request['length'], (int)$request['start'])->getResultArray();
    }

    public function countLogs($request)
    {
        return $this->select('log_id')->get()->getNumRows();
    }

    public function countLogFiltered($request)
    {
        return $this->select('log_id')
                    ->groupStart()
                        ->like('log_content', $request['query'], 'both')
                    ->groupEnd()
                    ->where('datetime >= ', $request['startDate'])
                    ->where('datetime <= ', $request['endDate'])
                    ->get()->getNumRows();
    }
}
