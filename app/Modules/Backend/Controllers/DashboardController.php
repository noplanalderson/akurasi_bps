<?php
namespace App\Modules\Backend\Controllers;

use App\Controllers\BackendController;
use App\Controllers\BaseController;
use App\Modules\Backend\Models\AccountModel;
use App\Modules\Backend\Models\CategoryModel;
use App\Modules\Backend\Models\DocumentModel;
use App\Modules\Backend\Models\LoginHistoryModel;
use App\Modules\Frontend\Models\VisitorModel;
use CodeIgniter\HTTP\Message;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Faker\Factory;
use CodeIgniter\HTTP\UserAgent;

class DashboardController extends BackendController
{
    protected $accountModel;
    
    protected $documentModel;

    protected $categoryModel;

    protected $loginHistory;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->accountModel = new AccountModel();
        $this->documentModel = new DocumentModel();
        $this->categoryModel = new CategoryModel();
        $this->loginHistory = new LoginHistoryModel();
    }

    public function index()
    {
        if($this->request->isAJAX())
        {       
            $docClassification = $this->documentModel->select('COUNT(*) AS total, document_classification')->groupBy('document_classification')->findAll();
            $docCategories = $this->documentModel->select('COUNT(tb_documents.document_id) AS total, b.category_name')
                                                 ->join('tb_categories b', 'tb_documents.category_id = b.category_id', 'inner')
                                                 ->groupBy('b.category_id')->findAll();
            $loginInformation = $this->loginHistory->select('*')->where('user_id', session()->get('uid'))->orderBy('timestamp', 'DESC')->first();
            $countCategories = $this->categoryModel->countAll();

            $totalCsf = [];
            $csf = [];
            foreach ($docClassification as $key => $classification) {
                $totalCsf[] = $classification['total'];
                $csf[] = $classification['document_classification'];
            }

            $totalCategories = [];
            $categories = [];
            foreach ($docCategories as $key => $category) {
                $totalCategories[] = $category['total'];
                $categories[] = $category['category_name'];
            }
            $countAccount = $this->accountModel->countAll();
            $countDocument = $this->documentModel->countAll();

            return $this->response->setJSON([
                'status' => 'success',
                'docCategories' => array('total' => $totalCategories, 'categories' => $categories),
                'docClassification' => array('total' => $totalCsf, 'classification' => $csf),
                'totalAccount' => $countAccount,
                'totalDocument' => $countDocument,
                'loginInformation' => $loginInformation,
                'countCategories' => $countCategories,
            ]);
        }
        else
        {
            $data = array(
                'css' => BaseController::css([
                    PLUGINPATH . 'backend/datatables/datatables.min.css',
                    'https://cdn.jsdelivr.net/npm/jsvectormap/dist/css/jsvectormap.min.css',
                    PLUGINPATH . 'backend/select2/select2.min.css'
                ]),
                'js' => BaseController::js([
                    PLUGINPATH . 'backend/datatables/datatables.min.js',
                    PLUGINPATH . 'backend/chart.js/Chart.bundle.min.js',
                    PLUGINPATH . 'backend/select2/select2.min.js',
                    'https://cdn.jsdelivr.net/npm/jsvectormap',
                    'https://cdn.jsdelivr.net/npm/jsvectormap/dist/maps/world.js',
                    'https://d3js.org/d3.v4.js',
                    'https://cdn.jsdelivr.net/gh/holtzy/D3-graph-gallery@master/LIB/d3.layout.cloud.js',
                    JSPATH . 'backend/dashboard.js'
                ]),
                'title' => BackendController::$siteSettings['site_name_alt'] . ' - Dashboard',
                'role' => $this->role
            );

            return BackendController::view([
                '_templates/backend/head',
                '_templates/backend/sidebar',
                '_templates/backend/navbar',
                'App\Modules\Backend\Views\dash_view',
                '_templates/backend/footer',
                '_templates/backend/script'
            ], $data);
        }
    }
}