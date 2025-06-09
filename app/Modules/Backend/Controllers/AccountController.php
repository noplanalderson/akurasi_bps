<?php
namespace App\Modules\Backend\Controllers;

use App\Controllers\BackendController;
use App\Modules\Backend\Models\AccountModel;
use App\Modules\Backend\Models\UserGroupModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

class AccountController extends BackendController
{
    protected $accountModel;

    protected $userGroupModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->accountModel = new AccountModel();
        $this->userGroupModel = new UserGroupModel();
    }

    public function index()
    {
        if ($this->request->isAJAX()) {

            $status     = false;
            $message    = '';
            $post       = $this->request->getVar();

            if(!empty($post['user_id']))
            {
                $this->validation->setRules([
                    'user_id' => [
                        'label'  => 'Account ID',
                        'rules'  => 'required|is_uuid'
                    ]
                ]);

                if($this->validation->run($post) == true)
                {
                    $data = $this->accountModel->getWhere(['user_id' => $post['user_id']])->getRowArray();
                    if(!empty($data)) {
                        $status = true;
                    }
                    else {
                        $message = 'Account not found.';
                    }
                }
                else
                {
                    $data       = [];
                    $message    = $this->validation->getError('user_id');
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
                $orderby    = empty($orderby) ? 'user_name' : preg_replace('/[^a-z0-9._]/', '', $column[$orderby]['name']);
                $dir        = $this->request->getVar('order[0][dir]') ?? 'asc';
                $dir        = preg_match('/(asc|desc)$/', $dir) ? $dir : 'asc';

                if($this->validation->run($this->request->getVar(), 'datatables') == true)
                {
                    $length     = ($length < 0) ? false : $length;
                    $accounts   = $this->accountModel->getAccounts($start, $length, $orderby, $dir, $query);

                    $result = [
                        "draw" => $draw,
                        "recordsTotal" => $this->accountModel->countAll(),
                        "recordsFiltered" => $this->accountModel->countAllResults(),
                        'data' => $accounts,
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
                    JSPATH . 'backend/accounts.js'
                ]),
                'title' => BackendController::$siteSettings['site_name_alt'] . ' - Akun',
                'usergroups' => $this->userGroupModel->findAll(),
                'role' => $this->role
            );

            return BackendController::view([
                '_templates/backend/head',
                '_templates/backend/sidebar',
                '_templates/backend/navbar',
                'App\Modules\Backend\Views\accounts_view',
                '_templates/backend/footer',
                '_templates/backend/script'
            ], $data);
        }
    }

    public function save()
    {
        if($this->request->isAJAX())
        {
            $status    = false;
            $message   = 'Gagal menyimpan akun.';
            $errors    = [
                'validations' => []
            ];
            $post      = $this->request->getVar();

            if($this->validation->run($post,'account'))
            {

                $data = [
                    'group_id'      => $post['group_id'],
                    'user_realname' => strtoupper($post['user_realname']),
                    'user_name'     => strtolower($post['user_name']),
                    'user_email'    => strtolower($post['user_email']),
                    'user_password' => $post['user_password'],
                    'user_picture'  => 'user.png',
                    'is_active'     => $post['is_active']
                ];
                switch ($post['action']) {
                    case 'edit':
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $status     = $this->accountModel->update($post['user_id'], $data);
                        $message    = ($status) ? 'Akun disimpan.' : "Gagal menyimpan akun.";
                        if($status) {
                            logging('account', 'User account '.$post['user_name'].' was modified by '.self::$udata['user_name']);
                        }
                        break;
                    
                    default:
                        $user_id = (string)Uuid::uuid4();
                        $data = array_merge($data, ['user_id' => $user_id]);
                        $status     = $this->accountModel->insert($data, false);
                        $message    = ($status) ? 'Akun disimpan.' : "Gagal menyimpan akun.";
                        if($status) {
                            logging('account', 'User account '.$post['user_name'].' was created by '.self::$udata['user_name']);
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
                'csrf_token' => csrf_hash()
            );
            return $this->response->setJSON($data);
        }
        else
        {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed.']);
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
                'user_id' => [
                    'label' => 'ID Akun',
                    'rules' => 'required|is_uuid'
                ],
                'user_name' => [
                    'label' => 'Username',
                    'rules' => 'required|regex_match[/^[a-z0-9@._]+$/]'
                ]
            ]);

            if($this->validation->run($post) == true)
            {
                $status     = $this->accountModel->delete($post['user_id']);
                $message    = ($status) ? 'Akun dihapus.' : 'Gagal menghapus akun.';

                if($status) {
                    logging('account', 'Account '.$post['user_name'].' was deleted by '.self::$udata['user_name']);
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
                'csrf_token' => csrf_hash()
            );
            return $this->response->setJSON($data);
        }
        else
        {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed.']);
        }
    }
}