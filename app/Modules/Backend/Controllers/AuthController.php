<?php
namespace App\Modules\Backend\Controllers;

use App\Controllers\BackendController;
use App\Modules\Backend\Models\LoginHistoryModel;
use App\Modules\Backend\Models\AuthModel;
use App\Modules\Backend\Models\UserGroupModel;
use App\Modules\Backend\Models\AccountModel;
use Ramsey\Uuid\Nonstandard\Uuid;

class AuthController extends BackendController
{
    public function index()
    {
        if(session()->get('uid') && session()->get('gid')) {
            return redirect('blackhole/'.session()->get('index_page'));
        }

        $data = array(
            'js' => BackendController::js([
                'https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js',
                JSPATH . 'backend/login.js'
            ]),
            'css' => BackendController::css([
                CSSPATH . 'backend/login.css'
            ]),
            'title' => BackendController::$siteSettings['site_name_alt'] . ' - Auth',
        );

        return BackendController::view([
            '_templates/backend/head',
            'App\Modules\Backend\Views\login_view',
            '_templates/backend/script'
        ], $data, true);
    }

    public function roles()
    {
        $db = db_connect();
        $menu = $db->table('tb_menus')->get()->getResultArray();
        foreach ($menu as $res) {
            if($res['menu_location'] == 'mainmenu') {
                $mainmenu[] = $res;
            }
            if($res['menu_location'] == 'submenu') {
                $submenu[] = $res;
            }
            if($res['menu_location'] == 'btnmenu') {
                $btnmenu[] = $res;
            }
        }

        $object = array(
            'mainmenu' => $mainmenu,
            'submenu' => $submenu,
            'btnmenu' => $btnmenu
        );
        return json_encode($object, JSON_UNESCAPED_SLASHES);
    }
    
    public function login()
    {
        if ($this->request->isAJAX()) {

            $status     = false;
            $rule_msg   = '';
            $index_page = '';
            $user_name  = $this->request->getVar('user_name');
            $user_pwd   = $this->request->getVar('user_password');

            $this->validation->setRules([
                    'user_name' => [
                        'label'  => 'Username',
                        'rules'  => 'required|regex_match[/^[a-zA-Z0-9@_]+$/]'
                    ],
                    'user_password' => [
                        'label'  => 'Password',
                        'rules'  => 'required|min_length[8]'
                    ]
                ]
            );

            if($this->validation->run((array)$this->request->getVar()) == true)
            {
                $loginModel = new AuthModel;
                $user = $loginModel->getUser($user_name);

                if(!empty($user)) {
                    if(password_verify($user_pwd, $user->user_password)) {

                        $now = new \DateTime();
                        $now->setTimezone(new \DateTimeZone('Asia/Jakarta'));

                        $index_page = $user->index_page;

                        $userData = array(  
                            'uid'   => $user->user_id,
                            'gid'   => $user->group_id,
                            'user_name' => $user->user_name,
                            'user_email' => $user->user_email,
                            'user_realname' => $user->user_realname,
                            'user_picture' => $user->user_picture,
                            'group_name' => $user->group_name,
                            'read_mode' => $user->read_mode,
                            'time'  => strtotime($now->format('Y-m-d H:i:s')),
                            'file_manager' => [
                                'logged' => true,
                                'fm_create' => $user->fm_create,
                                'fm_rename' => $user->fm_rename,
                                'fm_delete' => $user->fm_delete,
                                'publisher' => $user->post_publish
                            ],
                            'index_page' => $user->index_page
                        );
                        
                        $sessionLogin = array_merge($userData, $this->__setRoles($user->group_id));
                        session()->set($sessionLogin);

                        $this->__loginHistory($user_name);

                        $status  = true;
                        $message = 'Login success. Please wait...';
                    } else {
                        $message = 'Wrong username or password.';
                    }
                } else {
                    $message = 'Wrong username or password.';
                }
            }
            else
            {
                $rule_msg = $this->validation->getErrors();
                $message = 'Login failed.';
            }

            $data = array(
                'status' => $status, 
                'message' => $message, 
                'rule_msg' => $rule_msg,
                'index_page' => $index_page,
                'csrf_token' => csrf_hash()
            );
            return $this->response->setJSON($data);
        }
        else
        {
            $result = array(
                'status' => 400,
                'message' => 'Bad Request'
            );
            return $this->response->setStatusCode(400)->setJSON($result);
        }        
    }

    public function logout()
    {
        $request    = \Config\Services::request();
        $ipaddress  = $request->getIPAddress();

        logging('access', 'User '.session()->get('user_realname').' was logout from IP '.$ipaddress);
        session()->destroy();
        return redirect()->to(base_url('auth'));
    }

    public function settings()
    {
        $status = false;
        $code   = 405;
        $message= '';
        $message= 'Method not Allowed.';

        if($this->request->isAJAX())
        {
            $code   = 200;
            $post   = $this->request->getVar();

            $this->validation->setRules([
                'user_email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email'
                ],
                'user_password' => [
                    'label'  => 'Password',
                    'rules'  => 'permit_empty|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,32}$/]',
                    'errors' => [
                        'regex_match' => '{field} must contains alphanumeric and at least one symbol (8-32) characters.'
                    ]
                ],
                'repeat_password' => [
                    'label'  => 'Password',
                    'rules'  => 'permit_empty|matches[user_password]'
                ],
                'user_picture' => [
                    'label' => 'User Picture',
                    'rules' => [
                        'max_size[user_picture,3000]',
                        'mime_in[user_picture,image/png,image/jpg,image/jpeg,image/webp]',
                        'ext_in[user_picture,jpg,jpeg,webp,png]'
                    ]
                ]
            ]);
            if($this->validation->run($post))
            {
                $data       = [
                    'user_email' => strtolower($post['user_email'])
                ];
                if(!empty($post['user_password'])) {
                    $data['user_password'] = $post['user_password'];
                }

                $image = $this->request->getFile('user_picture');
                if (($image->isValid() && ! $image->hasMoved())) 
                {
                    $dir = FCPATH . 'uploads/pp/' . session()->get('uid') . '/';
                    if(!is_dir($dir)) mkdir($dir, 0755, true);

                    $user_picture = $image->getRandomName();
                    $image->move($dir, $user_picture, true);

                    $data['user_picture'] = $user_picture;
                }
                else
                {
                    $data['user_picture'] = 'user.png';
                    $message = $image->getErrorString();
                }

                $account    = new AccountModel();
                $status     = $account->update(session()->get('uid'), $data);
                $message    = $status ? 'Account settings saved.' : 'Failed to save account settings.';

                if($status) {
                    session()->remove(['user_email', 'user_picture']);
                    session()->set([
                        'user_email' => $post['user_email'],
                        'user_picture' => $data['user_picture']
                    ]);
                }
            }
            else
            {
                $message .= implode('<br/>', $this->validation->getErrors());
            }
        }
        
        return $this->response->setStatusCode($code)->setJSON([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'user_picture' => UPLOAD_PATH . 'pp/' . session()->get('uid') . '/' . $data['user_picture'],
            'csrf_token' => csrf_hash()
        ]);
    }

    public function loginHistory()
    {
        if($this->request->isAJAX()) {
            $draw       = $this->request->getVar('draw');
            $query      = $this->request->getVar('search[value]');
            $start      = $this->request->getVar('start');
            $length     = $this->request->getVar('length');
            $column     = $this->request->getVar('columns');
            $orderby    = $this->request->getVar('order[0][column]');
            $orderby    = empty($orderby) ? 'timestamp' : preg_replace('/[^a-z0-9._]/', '', $column[$orderby]['name']);
            $dir        = $this->request->getVar('order[0][dir]') ?? 'desc';
            $dir        = preg_match('/(asc|desc)$/', $dir) ? $dir : 'desc';
            $endDate    = $this->request->getVar('endDate');
            $startDate  = $this->request->getVar('startDate');

            $request    = array(
                'start'       => $start,
                'length'      => $length,
                'startDate'   => $startDate,
                'endDate'     => $endDate,
                'orderby'     => $orderby,
                'dir'         => $dir,
                'query'       => $query
            );

            if($this->validation->run($this->request->getVar(), 'datatables') == true)
            {
                $length = ($length < 0) ? null : $length;

                $loginHistory = new LoginHistoryModel();
                $data   = $loginHistory->getUserLogin($request);
                $result = [
                    "draw" => $draw,
                    "recordsTotal" => $loginHistory->countUserLogin($request),
                    "recordsFiltered" => $loginHistory->countLoginFiltered($request),
                    'data' => $data,
                    'token' => csrf_hash(),
                    'error' => null
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
                    'error' => $this->validation->getErrors()
                ];
            }
            return $this->response->setStatusCode(200)->setJSON($result);
        }
        else
        {
            $data = array(
                'css' => BackendController::css([
                    PLUGINPATH . 'backend/datatables/datatables.min.css',
                    PLUGINPATH . 'backend/daterangepicker-master/daterangepicker.css'
                ]),
                'js' => BackendController::js([
                    PLUGINPATH . 'backend/datatables/datatables.min.js',
                    PLUGINPATH . 'backend/momentjs/moment.min.js',
                    PLUGINPATH . 'backend/momentjs/moment-timezone.js',
                    PLUGINPATH . 'backend/momentjs/moment-timezone-with-data.js',
                    PLUGINPATH . 'backend/momentjs/datetime-moment.js',
                    PLUGINPATH . 'backend/daterangepicker-master/daterangepicker.js',
                    JSPATH . 'backend/login-history.js'
                ]),
                'title' => BackendController::$siteSettings['site_name_alt'] . ' - Login History',
                'role' => $this->role
            );

            return BackendController::view([
                '_templates/backend/head',
                '_templates/backend/sidebar',
                '_templates/backend/navbar',
                'App\Modules\Backend\Views\login_history',
                '_templates/backend/footer',
                '_templates/backend/script'
            ], $data);
        }
    }

    private function __loginHistory($user_name)
    {
        $request    = \Config\Services::request();
        $ipaddress  = $request->getIPAddress();
        $agent      = $this->request->getUserAgent();

        if ($agent->isBrowser()) {
            $currentAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
        } elseif ($agent->isRobot()) {
            $currentAgent = $agent->getRobot();
        } elseif ($agent->isMobile()) {
            $currentAgent = $agent->getMobile();
        } else {
            $currentAgent = 'Unidentified User Agent';
        }

        $loginHistory = new LoginHistoryModel();
        $loginHistory->insert([
            'user_id' => session()->get('uid'),
            'ip_address' => $ipaddress,
            'browser' => $currentAgent,
            'platform' => $agent->getPlatform()
        ]);

        logging('access', 'User '.$user_name.' logged from IP '.$ipaddress);
    }

    private function  __setRoles($gid)
    { 
        $roleModel = new UserGroupModel;
        $roles = $roleModel->find($gid);
        
        $roles = parseRoles($roles);
        
        return [
            'user_menu' => $roles['mainmenu'],
            'user_submenu' => $roles['submenu'],
            'user_btnmenu' => $roles['btnmenu']
        ];
    }

    public function dd()
    {
        // $roleModel = new UserGroupModel;
        // $roles = $roleModel->find('c6fc0aba-dcef-11ef-a1be-50a13237241a');
        // $roles = parseRoles($roles);
        
        // return [
        //     'user_menu' => $roles['mainmenu'],
        //     'user_submenu' => $roles['submenu'],
        //     'user_btnmenu' => $roles['btnmenu']
        // ];
        // $mainmenu = [];
        // $submenu = [];
        // $btnmenu = [];
        
        // $object = [
        //     'mainmenu' => $mainmenu,
        //     'submenu' => $submenu,
        //     'btnmenu' => $btnmenu
        // ];

        // $db = db_connect();
        // $menu = $db->table('tb_menus')->get()->getResultArray();
        // foreach ($menu as $res) {
        //     if($res['menu_location'] == 'mainmenu') {
        //         $mainmenu[] = $res;
        //     }
        //     if($res['menu_location'] == 'submenu') {
        //         $submenu[] = $res;
        //     }
        //     if($res['menu_location'] == 'btnmenu') {
        //         $btnmenu[] = $res;
        //     }
        // }

        // $object = array(
        //     'mainmenu' => $mainmenu,
        //     'submenu' => $submenu,
        //     'btnmenu' => $btnmenu
        // );
        // return json_encode($object, JSON_UNESCAPED_SLASHES);
        // return $this->response->setStatusCode(200)->setJSON($roles);
        $uuid = Uuid::uuid4()->toString();
        dd($uuid);
    }
}
