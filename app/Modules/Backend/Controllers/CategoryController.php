<?php
namespace App\Modules\Backend\Controllers;

use App\Controllers\BackendController;
use App\Modules\Backend\Models\CategoryModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class CategoryController extends BackendController
{
    protected $categoryModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if ($this->request->isAJAX()) {

            $status     = false;
            $message    = '';
            $post       = $this->request->getVar();

            if(!empty($post['category_id']))
            {
                $this->validation->setRules([
                    'category_id' => [
                        'label'  => 'ID Kategori',
                        'rules'  => 'required|integer'
                    ]
                ]);

                if($this->validation->run($post) == true)
                {
                    $data = $this->categoryModel->find($post['category_id']);
                    if(!empty($data)) {
                        $status = true;
                    }
                    else {
                        $message = 'Kategori tidak ditemukan.';
                    }
                }
                else
                {
                    $data       = [];
                    $message    = implode('<br/>',$this->validation->getErrors());
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
                $type       = $this->request->getVar('type');
                $draw       = $this->request->getVar('draw');
                $query      = $this->request->getVar('search[value]');
                $start      = $this->request->getVar('start');
                $length     = $this->request->getVar('length');

                if($this->validation->run($this->request->getVar(), 'datatables') == true)
                {
                    $length     = ($length < 0) ? false : $length;
                    $data           = $this->categoryModel->getCategories($start, $length, $query);
                    $countFiltered  = $this->categoryModel->countAllResults();
                    $countAll       = $this->categoryModel->countAll();

                    $result = [
                        "draw" => $draw,
                        "recordsTotal" => $countAll,
                        "recordsFiltered" => $countFiltered,
                        'data' => $data,
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
                    JSPATH . 'backend/categories.js'
                ]),
                'title' => BackendController::$siteSettings['site_name_alt'] . ' - Kategori',
                'role' => $this->role
            );

            return BackendController::view([
                '_templates/backend/head',
                '_templates/backend/sidebar',
                '_templates/backend/navbar',
                'App\Modules\Backend\Views\categories_view',
                '_templates/backend/footer',
                '_templates/backend/script'
            ], $data);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $status     = false;
            $message    = '';
            $errors     = ['validatons' => []];
            $post       = $this->request->getVar();

            $this->validation->setRules([
                'category_id' => [
                    'label'  => 'ID Kategori',
                    'rules'  => 'permit_empty|integer'
                ],
                'action' => [
                    'label'  => 'Action',
                    'rules'  => 'required|in_list[add,edit]'
                ],
                'category_code' => [
                    'label'  => 'Kode Kategori',
                    'rules'  => 'required|regex_match[/[a-z0-9.]+$/i]'
                ],
                'category_name' => [
                    'label'  => 'Kategori',
                    'rules'  => 'required|alpha_numeric_space'
                ]
            ]);

            if($this->validation->run($post) == true)
            {
                $data = [
                    'category_code' => $post['category_code'],
                    'category_name' => $post['category_name'],
                    'category_slug' => slug($post['category_name']),
                ];

                if($post['action'] == 'edit')
                {
                    $data['category_id'] = $post['category_id'];
                    $data['updated_at'] = date('Y-m-d H:i:s');
                }

                $status = $this->categoryModel->save($data);

                if ($status && $post['action'] == 'add') {
                    $data['category_id'] = $this->categoryModel->insertID();
                }

                $message = $status ? 'Berhasil menyimpan kategori.' : 'Gagal menyimpan kategori.';
            }
            else
            {
                $errors['validatons'] = $this->validation->getErrors();
            }

            $result = [
                'status' => $status,
                'token' => csrf_hash(),
                'message' => $message,
                'data' => $data['category_id'],
                'errors' => $errors
            ];
            return $this->response->setStatusCode(200)->setJSON($result);
        }
        else
        {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed']);
        }
    }

    public function delete() {
        if ($this->request->isAJAX()) {
            $status     = false;
            $message    = '';
            $errors     = ['validatons' => []];
            $post       = $this->request->getVar();

            $this->validation->setRules([
                'category_id' => [
                    'label'  => 'ID Kategori',
                    'rules'  => 'required|integer'
                ]
            ]);

            if($this->validation->run($post) == true)
            {
                $status = $this->categoryModel->delete($post['category_id']);
                $message = $status ? 'Kategori dihapus.' : 'Gagal menghapus kategori.';
            }
            else
            {
                $errors['validatons'] = $this->validation->getErrors();
            }

            $result = [
                'status' => $status,
                'token' => csrf_hash(),
                'message' => $message,
                'errors' => $errors
            ];
            return $this->response->setStatusCode(200)->setJSON($result);
        }
        else
        {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed']);
        }
    }

    public function select2()
    {
        if ($this->request->isAJAX()) {
            $query = preg_replace('/[^a-z0-9 ]/i','', $this->request->getVar('search'));
            $data = $this->categoryModel->like('category_name', $query)
                                        ->orLike('category_code', $query)
                                        ->findAll(10);

            $results = [];
            foreach ($data as $category) {
                $results[] = [
                    'id' => $category['category_id'],
                    'text' => $category['category_code'].'.'.$category['category_name']
                ];
            }

            return $this->response->setJSON(['results' => $results]);
        } else {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed']);
        }
    }
}