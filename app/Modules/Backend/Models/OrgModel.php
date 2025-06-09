<?php

namespace App\Modules\Backend\Models;

use CodeIgniter\Model;

class OrgModel extends Model
{
    protected $table            = 'tb_org_settings';
    protected $primaryKey       = 'org_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'org_id', 'org_name', 'org_profile', 'org_slogan', 'org_vision', 'org_missions', 
        'org_phone', 'org_address', 'org_social_media',  'org_map', 'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
