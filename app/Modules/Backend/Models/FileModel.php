<?php

namespace App\Modules\Backend\Models;

use CodeIgniter\Model;

class FileModel extends Model
{
    protected $table            = 'tb_files';
    protected $primaryKey       = 'file_id';
    protected $allowedFields    = [
        'file_id', 'document_id', 'file_name', 'file_mime', 'file_classification', 'file_type', 'file_size',
        'file_viewers', 'created_at', 'updated_at','deleted_at'
    ];

    protected $useSoftDeletes = true;

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}