<?php

namespace App\Modules\Backend\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class UserGroupModel extends Model
{
    protected $table = 'tb_user_groups';
    protected $primaryKey = 'group_id';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'group_id',
        'group_name',
        'roles',
        'read_mode',
        'index_page',
        'fm_rename',
        'fm_create',
        'fm_delete',
        'post_publish'
    ];

    public function getGroups(int $start, int $length, string $orderby, string $dir, ?string $query)
    {
        return $this->select("group_id, group_name, index_page, 
                    JSON_UNQUOTE(JSON_EXTRACT(roles, '$.mainmenu[*].menu_slug')) AS mainmenu,
                    JSON_UNQUOTE(JSON_EXTRACT(roles, '$.submenu[*].menu_slug')) AS submenu,
                    JSON_UNQUOTE(JSON_EXTRACT(roles, '$.btnmenu[*].menu_slug')) AS btnmenu, read_mode")
                    ->like('group_name', $query, 'both')
                    ->groupBy('group_name')
                    ->orderBy($orderby, $dir)
                    ->get($length, $start)->getResultArray();
    }

    public function countFiltered($query)
    {
        return $this->select('group_id')
                    ->like('group_name', $query, 'both')
                    ->get()->getNumRows();
    }

    public function getIndexPage($mainmenu, $index_menu)
    {
        $options = "";
        foreach ($mainmenu as $slug)
        {
            if($slug !== '')
                $options .= '<option value="'.$slug.'" '.(($index_menu === $slug) ? 'selected=""' : "").'>'.slugToTitle($slug).'</option>';
        }

        return $options;
    }

    public function editGroup($post)
    {
        $features = [
            'mainmenu' => [],
            'submenu' => [],
            'btnmenu' => []
        ];

        for ($i = 0; $i < count($post['group_feature']); $i++)
        {
            $feature = explode('_', $post['group_feature'][$i]);

            $menuModel = new MenuModel();
            $menus = $menuModel->where('menu_group', $feature[0])
                                ->where('menu_mode', $feature[1])
                                ->orderBy('menu_sequence', 'asc')
                                ->findAll();

            foreach ($menus as $menu) {
                
                if($menu['menu_location'] == 'mainmenu') {
                    $features['mainmenu'][] = $menu;
                }
                if($menu['menu_location'] == 'submenu') {
                    $features['submenu'][] = $menu;
                }
                if($menu['menu_location'] == 'btnmenu') {
                    $features['btnmenu'][] = $menu;
                }
            }
        }

        return $this->update($post['group_id'], [
            'group_name' => $post['group_name'], 
            'read_mode' => $post['mode'],
            'roles' => json_encode($features)
        ]);
    }

    public function addGroup($post)
    {
        $features = [
            'mainmenu' => [],
            'submenu' => [],
            'btnmenu' => []
        ];

        for ($i = 0; $i < count($post['group_feature']); $i++)
        {
            $feature = explode('_', $post['group_feature'][$i]);
            $menuModel = new MenuModel();
            $menus = $menuModel->where('menu_group', $feature[0])
                                ->where('menu_mode', $feature[1])
                                ->orderBy('menu_sequence', 'asc')
                                ->findAll();

            foreach ($menus as $menu) {
                if($menu['menu_location'] == 'mainmenu') {
                    $features['mainmenu'][] = $menu;
                }
                if($menu['menu_location'] == 'submenu') {
                    $features['submenu'][] = $menu;
                }
                if($menu['menu_location'] == 'btnmenu') {
                    $features['btnmenu'][] = $menu;
                }
            }
        }

        return $this->insert([
            'group_id' => (string)Uuid::uuid4(),
            'group_name' => $post['group_name'],
            'read_mode' => $post['mode'],
            'roles' => json_encode($features)
        ], false);
    }
}