<?php

namespace App\Modules\Backend\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'tb_categories';
    protected $primaryKey       = 'category_id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'category_id', 'category_code', 'category_name', 'category_slug', 'category_viewers', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getCategories(int $start, int $length, ?string $query)
    {
        return $this->select("tb_categories.*")
                    ->groupStart()
                        ->like('tb_categories.category_name', $query, 'both')
                        ->orLike('tb_categories.category_code', $query, 'both')
                    ->groupEnd()
                    ->orderBy('category_name', 'asc')
                    ->get($length, $start)->getResultArray();
    }
}
