<?php
namespace App\Modules\Backend\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'tb_menus';
    protected $primaryKey = 'menu_id';

    protected $allowedFields = [
        'menu_id',
        'menu_label',
        'menu_slug',
        'menu_icon',
        'menu_sequence',
        'menu_group',
        'menu_mode',
        'menu_location'
    ];

    public function getFeatures($mode)
    {
        $select = $this->select('menu_group, menu_mode');

        if($mode === 'r') {
            $select = $select->where('menu_mode', 'r');
        }

        return $select->groupBy('menu_group')
                ->groupBy('menu_mode')
                ->orderBy('menu_label','asc')
                ->findAll();
    }
}