<?php

namespace App\Modules\Frontend\Models;

use CodeIgniter\Model;

class NavigationModel extends Model
{
    protected $table            = 'tb_navigations';
    protected $primaryKey       = 'nav_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nav_id', 'user_id', 'nav_name', 'nav_slug', 'nav_sequence', 'nav_position', 'custom_link', 'open_newtab', 'nav_parent'];
    protected $useAutoIncrement = true;

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
