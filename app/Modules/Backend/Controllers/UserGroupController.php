<?php
namespace App\Modules\Backend\Controllers;

use App\Controllers\BackendController;
use App\Modules\Backend\Models\MenuModel;
use App\Modules\Backend\Models\UserGroupModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Message;
use Psr\Log\LoggerInterface;

class UserGroupController extends BackendController
{
    protected $userGroupModel;

    protected $menuModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->userGroupModel = new UserGroupModel();
        $this->menuModel = new MenuModel();
    }

    public function index()
    {
        if ($this->request->isAJAX()) {

            $status     = false;
            $message    = '';
            $post       = $this->request->getVar();

            if(!empty($post['group_id']))
            {
                $this->validation->setRules([
                    'group_id' => [
                        'label'  => 'Group ID',
                        'rules'  => 'required|is_uuid'
                    ]
                ]);

                if($this->validation->run($post) == true)
                {
                    $status = 1;
                    $data   = $this->userGroupModel->find($post['group_id']);
                    $msg    = empty($data) ? 'Group not found.' : '';
                }
                else
                {
                    $data       = [];
                    $message    = $this->validation->getError('group_id');
                }

                $result = [
                    'status' => $status,
                    'data' => $data,
                    'token' => csrf_hash(),
                    'message' => $message
                ];
                return $this->response->setStatusCode(200)->setJSON($result);
            }
            else
            {
                $draw       = $this->request->getVar('draw');
                $query      = $this->request->getVar('search[value]');
                $start      = $this->request->getVar('start');
                $length     = $this->request->getVar('length');
                $column     = $this->request->getVar('columns');
                $orderby    = $this->request->getVar('order[0][column]');
                $orderby    = empty($orderby) ? 'group_name' : preg_replace('/[^a-z0-9_]/', '', $column[$orderby]['name']);
                $dir        = $this->request->getVar('order[0][dir]') ?? 'asc';
                $dir        = preg_match('/(asc|desc)$/', $dir) ? $dir : 'asc';

                if($this->validation->run($this->request->getVar(), 'datatables') == true)
                {
                    $length = ($length < 0) ? false : $length;
                    $groups = $this->userGroupModel->getGroups($start, $length, $orderby, $dir, $query);
                    $ug     = [];
                    
                    foreach ($groups as $group) {
                        $features = preg_replace('/[^a-z0-9,\/\-]/', '', $group['mainmenu'].','.$group['submenu'].','.$group['btnmenu']);
                        $indexes  = explode(',',preg_replace('/[^a-z0-9,\/\-]/', '', $group['mainmenu'].','.$group['submenu']));
                        $ug[] = array(
                            'group_name' => $group['group_name'],
                            'group_id' => $group['group_id'],
                            'features' => $features,
                            'read_mode' => $group['read_mode'],
                            'index_page' => $this->userGroupModel->getIndexPage($indexes, $group['index_page'])
                        );
                    }

                    $recordsFiltered = count($groups);

                    $result = [
                        "draw" => $draw,
                        "recordsTotal" => $this->userGroupModel->countAllResults(),
                        "recordsFiltered" => $recordsFiltered,
                        'data' => $ug,
                        'token' => csrf_hash(),
                        'errors' => null
                    ];
                } 
                else 
                {
                    $result = [
                        "draw" => $draw,
                        "recordsTotal" => 0,
                        "recordsFiltered" => 0,
                        'data' => array(),
                        'token' => csrf_hash(),
                        'errors' => implode('<br/>', $this->validation->getErrors())
                    ];
                }

                return $this->response->setStatusCode(200)->setJSON($result);
            }
        }
        else
        {
            $data = array(
                'css' => BackendController::css([
                    PLUGINPATH . 'backend/datatables/datatables.min.css',
                    PLUGINPATH . 'backend/select2/select2.min.css'
                ]),
                'js' => BackendController::js([
                    PLUGINPATH . 'backend/datatables/datatables.min.js',
                    PLUGINPATH . 'backend/select2/select2.min.js',
                    JSPATH . 'backend/usergroups.js'
                ]),
                'title' => BackendController::$siteSettings['site_name_alt'] . ' - Grup Pengguna',
                'role' => $this->role
            );

            return BackendController::view([
                '_templates/backend/head',
                '_templates/backend/sidebar',
                '_templates/backend/navbar',
                'App\Modules\Backend\Views\groups_view',
                '_templates/backend/footer',
                '_templates/backend/script'
            ], $data);
        }
    }

    public function getFeatures()
    {
        if ($this->request->isAJAX())
        {
            $mode = $this->request->getGet('mode');
            $mode = ($mode == 'r') ? ['menu_mode' => 'r'] : 'menu_mode IS NOT NULL';

            $results = $this->menuModel->where($mode)
                            ->groupBy('menu_group')
                            ->groupBy('menu_mode')
                            ->orderBy('menu_label','asc')->findAll();
            
            return $this->response->setStatusCode(200)->setJSON($results);
        }
        else
        {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed.']);
        }
    }

    public function save()
    {
        if($this->request->isAJAX())
        {
            $status    = false;
            $message   = 'Gagal menyimpan grup pengguna.';
            $errors    = [
                'validations' => []
            ];
            $post      = $this->request->getVar();

            if($this->validation->run($post,'usergroup'))
            {
                switch ($post['action']) {
                    case 'edit':
                        $status     = $this->userGroupModel->editGroup($post);
                        $message    = ($status) ? 'Grup pengguna disimpan.' : "Gagal menyimpan grup pengguna.";
                        if($status) {
                            logging('user_group', 'User group '.$post['group_name'].' was changed by '.session()->get('user_name'));
                        }
                        break;
                    
                    default:
                        $status     = $this->userGroupModel->addGroup($post);
                        $message    = ($status) ? 'Grup pengguna disimpan.' : "Gagal menyimpan grup pengguna.";
                        if($status) {
                            logging('user_group', 'User group '.$post['group_name'].' was added by '.session()->get('user_name'));
                        }
                        break;
                }

            }
            else
            {
                $errors['validations'] = $this->validation->getErrors(); 
            }

            $data = array(
                'status' => $status, 
                'message' => $message, 
                'errors' => $errors,
                'token' => csrf_hash()
            );
            return $this->response->setJSON($data);
        }
        else
        {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed']);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {

            $status     = false;
            $errors     = [
                'validations' => []
            ];
            $message    = '';
            $post       = $this->request->getVar();

            $this->validation->setRules([
                'group_id' => [
                    'label' => 'Group ID',
                    'rules' => 'required|is_uuid'
                ],
                'group_name' => [
                    'label' => 'Grup',
                    'rules' => 'required|alpha_numeric_space'
                ]
            ]);

            if($this->validation->run($post) == true)
            {
                $status     = $this->userGroupModel->delete($post['group_id']);
                $message    = ($status) ? 'Grup pengguna dihapus.' : 'Gagal menghapus grup pengguna.';

                if($status) {
                    logging('user_group', 'User group '.$post['group_name'].' was deleted by '.session()->get('user_name'));
                }
            }
            else
            {
                $errors['validations'] = $this->validation->getErrors();
            }

            $data = array(
                'status' => $status, 
                'message' => $message, 
                'errors' => $errors,
                'token' => csrf_hash()
            );
            return $this->response->setJSON($data);
        }
        else
        {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed']);
        }
    }

    public function updateIndex()
    {
        if ($this->request->isAJAX()) 
        {
            $status     = false;
            $message    = 'Failed to change index.';
            $errors     = [
                'validations' => []
            ];
            $post       = $this->request->getVar();

            $this->validation->setRules([
                'group_id' => [
                    'label' => 'Group ID',
                    'rules' => 'required|is_uuid'
                ],
                'index_page' => [
                    'label' => 'Indeks',
                    'rules' => 'required|alpha_dash'
                ]
            ]);

            if($this->validation->run($post))
            {
                $status = $this->userGroupModel->update($post['group_id'], ['index_page' => $post['index_page']]);
                $message= ($status) ? 'Halaman indeks grup diubah.' : 'Gagal mengubah halaman indeks grup.';
            }
            else
            {
                $errors['validations'] = $this->validation->getErrors();
            }

            $data = array(
                'status' => $status, 
                'message' => $message, 
                'errors' => $errors,
                'token' => csrf_hash()
            );
            return $this->response->setJSON($data);
        }
        else
        {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed']);
        }
    }
}
