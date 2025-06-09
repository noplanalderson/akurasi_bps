<?php

namespace App\Modules\Backend\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table            = 'tb_documents';
    protected $primaryKey       = 'document_id';
    protected $allowedFields    = [
        'document_id','user_id','category_id','document_classification','document_details','spj_date','document_viewers',
        'created_at', 'updated_at','deleted_at'
    ];

    protected $useSoftDeletes = true;

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    public function getDocuments(array $params)
    {
        return $this->select('tb_documents.*, b.user_realname, c.category_code, c.category_name, SUM(CASE WHEN d.deleted_at IS NULL THEN 1 ELSE 0 END) as file_count')
                    ->join('tb_users b', 'b.user_id = tb_documents.user_id', 'left')
                    ->join('tb_categories c', 'c.category_id = tb_documents.category_id', 'left')
                    ->join('tb_files d', 'd.document_id = tb_documents.document_id', 'left')
                    ->groupStart()
                        ->like('tb_documents.document_details', $params['search'], 'both')
                        ->orLike('b.user_realname', $params['search'], 'both')
                        ->orLike('c.category_name', $params['search'], 'both')
                    ->groupEnd()
                    ->where('spj_date >= ', $params['startDate'])
                    ->where('spj_date <= ', $params['endDate'])
                    ->where('tb_documents.document_classification',  $params['classification'])
                    ->where('tb_documents.deleted_at IS NULL')
                    ->where('d.deleted_at IS NULL')
                    ->groupBy('tb_documents.document_id')
                    ->orderBy($params['orderBy'], $params['orderDir'])
                    ->get($params['length'], $params['start'])->getResultArray();

    }
}
