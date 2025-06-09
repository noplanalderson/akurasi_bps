<?php
namespace App\Modules\Backend\Controllers;

use App\Controllers\BackendController;
use App\Libraries\DataTablesHandler;
use App\Modules\Backend\Models\CategoryModel;
use App\Modules\Backend\Models\DocumentModel;
use App\Modules\Backend\Models\FileModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class DocumentController extends BackendController
{
    protected $documentModel;

    protected $categoryModel;

    protected $fileModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->categoryModel = new CategoryModel();
        $this->documentModel = new DocumentModel();
        $this->fileModel = new FileModel();
    }

    public function index($classification)
    {
        if($this->request->isAJAX())
        {
            $status     = false;
            $message    = '';
            $data       = [];
            $fileData   = ['meta' => [], 'file' => []];
            $fileClass  = ['kak','form_permintaan','sk_kpa','surat_tugas','mon_kegiatan','dok_kegiatan','adm_kegiatan'];
            $post       = $this->request->getVar();

            if(!empty($post['document_id']))
            {
                $this->validation->setRules([
                    'document_id' => [
                        'label'  => 'ID Dokumen',
                        'rules'  => 'required|uuid7'
                    ]
                ]);

                if($this->validation->run($post) == true)
                {
                    $data = $this->documentModel->select('tb_documents.*, b.*, c.user_realname')
                                                ->join('tb_categories b','tb_documents.category_id = b.category_id','inner')
                                                ->join('tb_users c','tb_documents.user_id = c.user_id','inner')
                                                ->find($post['document_id']);
                    if(!empty($data)) {
                        $files = $this->fileModel->where('document_id',$post['document_id'])->findAll();
                        
                        for ($i=0; $i < count($fileClass); $i++) { 
                            $fileData['file'][$fileClass[$i]] = ''; 
                            $fileData['meta'][$fileClass[$i]] = [];
                        }

                        foreach ($files as $key => $file) {
                            $fileData['file'][$file['file_classification']] = base_url('blackhole/file/'.$file['file_id']);

                            $fileData['meta'][$file['file_classification']] =  array(
                                'file_id' => $file['file_id'],
                                'caption' => $file['file_name'],
                                'upload_date' => $file['created_at'],
                                'uploader' => $data['user_realname'],
                                'url' => base_url('blackhole/file/hapus'),
                                'key' => $file['file_id'],
                                'downloadUrl' => base_url('blackhole/file/'.$file['file_id'])
                            );
                        }
                        $status = true;
                    }
                    else {
                        $message = 'Dokumen tidak ditemukan.';
                    }
                }
                else
                {
                    $message    = implode('<br/>',$this->validation->getErrors());
                }

                $result = [
                    'status' => $status,
                    'data' => array_merge($data, ['file_data' => $fileData]),
                    'token' => csrf_hash(),
                    'message' => $message
                ];
            }
            else
            {
                $this->validation->setRules([
                    'startDate' => [
                        'label' => 'Tanggal Awal',
                        'rules' => 'required|valid_date[Y-m-d]'
                    ],
                    'endDate' => [
                        'label' => 'Tanggal Akhir',
                        'rules' => 'required|valid_date[Y-m-d]'
                    ],
                    'classification' => [
                        'label' => 'Klasifikasi',
                        'rules' => 'required|in_list[subbagumum,statsos,statprod,statdist,nerwilis,ipds]'
                    ]
                ]);

                if($this->validation->run($post))
                {
                    $dtHandler = new DataTablesHandler();
                    $dtHandler->defaultOrderColumn = 'tb_documents.created_at';
                    $params = $dtHandler->setAllowedOrderColumns([
                        'tb_documents.spj_date', 
                        'tb_documents.created_at', 
                        'b.user_realname',
                        'c.category_name'
                    ])->process();
    
                    $parameters = array_merge($params, [
                        'startDate' => $post['startDate'], 
                        'endDate' => $post['endDate'], 
                        'classification' => $post['classification']
                    ]);
                    $data = $this->documentModel->getDocuments($parameters);
            
                    $result = [
                        'draw'            => $params['draw'],
                        'recordsTotal'    => $this->documentModel->countAll(),
                        'recordsFiltered' => $this->documentModel->countAllResults(),
                        'data'            => $data,
                        'token'           => csrf_hash(),
                        'errors'          => null
                    ];

                }
                else
                {
                    $result = [
                        'draw'            => (int)$post['draw'],
                        'recordsTotal'    => 0,
                        'recordsFiltered' => 0,
                        'data'            => $data,
                        'token'           => csrf_hash(),
                        'errors'          => implode('<br/>',$this->validation->getErrors())
                    ];
                }
            }
            return $this->response
                        ->setStatusCode(200)
                        ->setHeader('Content-Type', 'application/json')
                        ->setHeader('X-Content-Type-Options', 'nosniff')
                        ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate')
                        ->setJSON($result);
        }
        else
        {
            $title = docClassification($classification);
            $data = array(
                'css' => BackendController::css([
                    PLUGINPATH . 'backend/datatables/datatables.min.css',
                    PLUGINPATH . 'backend/daterangepicker-master/daterangepicker.css',
                    PLUGINPATH . 'backend/select2/select2.min.css',
                    'https://cdn.jsdelivr.net/gh/AdrianVillamayor/Wizard-JS@1.9.9/styles/css/main.css',
                    PLUGINPATH . 'backend/fileinput/css/fileinput.min.css'
                ]),
                'js' => BackendController::js([
                    PLUGINPATH . 'backend/datatables/datatables.min.js',
                    PLUGINPATH . 'backend/momentjs/moment.min.js',
                    PLUGINPATH . 'backend/momentjs/moment-timezone.js',
                    PLUGINPATH . 'backend/momentjs/moment-timezone-with-data.js',
                    PLUGINPATH . 'backend/momentjs/datetime-moment.js',
                    PLUGINPATH . 'backend/daterangepicker-master/daterangepicker.js',
                    PLUGINPATH . 'backend/select2/select2.min.js',
                    'https://cdn.jsdelivr.net/gh/AdrianVillamayor/Wizard-JS@1.9.9/src/wizard.min.js',
                    PLUGINPATH . 'backend/fileinput/js/fileinput.min.js',
                    PLUGINPATH . 'backend/fileinput/themes/fa6/theme.min.js',
                    PLUGINPATH . 'backend/fileinput/js/locales/id.js',
                    JSPATH . 'backend/docs.js'
                ]),
                'title' => BackendController::$siteSettings['site_name_alt'] . ' - ' . $title,
                'header' => $title,
                'categories' => $this->categoryModel->findAll(),
                'classification' => preg_replace('/[^a-z]/i', '', $classification),
                'role' => $this->role
            );

            return BackendController::view([
                '_templates/backend/head',
                '_templates/backend/sidebar',
                '_templates/backend/navbar',
                'App\Modules\Backend\Views\docs_view',
                '_templates/backend/footer',
                '_templates/backend/script'
            ], $data);
        }
    }

    public function save()
    {
        if($this->request->isAJAX())
        {
            $status = false;
            $document_id = null;
            $message= 'Gagal menambahkan rincian dokumen.';
            $errors = [
                'validations' => []
            ];
            $post   = $this->request->getVar();

            if($this->validation->run($post, 'document'))
            {
                $document_id = empty($post['document_id']) ? uuid(7) : $post['document_id'];
                $data = [
                    'user_id' => session()->get('uid'),
                    'document_classification' => $post['document_classification'],
                    'document_details' => $post['document_details'],
                    'category_id' => $post['category_id'],
                    'spj_date' => $post['spj_date']
                ];
                switch ($post['action']) {
                    case 'edit':
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $status = $this->documentModel->update(['document_id' => $post['document_id']], $data);
                        break;
                    
                    default:
                        $data['document_id'] = $document_id;
                        // $status = true;
                        $status = $this->documentModel->insert($data, false);
                        break;
                }

                $message = ($status) ? 'Rincian dokumen disimpan.' : 'Gagal menyimpan rincian dokumen.';
            }
            else
            {
                $errors['validations'] = $this->validation->getErrors();
            }

            $result = [
                'status' => $status,
                'token' => csrf_hash(),
                'message' => $message,
                'document_id' => $document_id,
                'errors' => $errors
            ];
            return $this->response->setStatusCode(200)->setJSON($result);
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
                'document_id' => [
                    'label' => 'ID Dokumen',
                    'rules' => 'required|uuid7'
                ]
            ]);

            if($this->validation->run($post) == true)
            {
                $db = db_connect();

                $db->transStart();

                $status = $this->documentModel->delete($post['document_id']);
                if ($status) {
                    $this->fileModel->where('document_id', $post['document_id'])->delete();
                    logging('dokumen', 'Dokumen ' . $post['document_id'] . ' dihapus oleh ' . self::$udata['user_name']);
                }

                $db->transComplete();

                if ($db->transStatus() === false) {
                    $status = false;
                    $message = 'Gagal menghapus dokumen.';
                } else {
                    $message = 'Dokumen dihapus.';
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