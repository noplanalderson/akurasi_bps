<?php

namespace App\Modules\Frontend\Models;

use CodeIgniter\Model;

class SiteModel extends Model
{
    protected $table            = 'tb_site_settings';
    protected $primaryKey       = 'site_id';
    protected $allowedFields    = [
        'site_id', 'site_name', 'site_name_alt', 'site_description', 'site_author', 'site_keywords', 'site_logo', 'updated_at', 'info_adm', 'pedoman_adm_keuangan'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $updatedField  = 'updated_at';
}