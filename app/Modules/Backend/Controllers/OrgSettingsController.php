<?php
namespace App\Modules\Backend\Controllers;

use App\Controllers\BackendController;
use App\Modules\Backend\Models\OrgModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class OrgSettingsController extends BackendController
{
    protected $orgModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->orgModel = new OrgModel();
    }

    public function index()
    {
        $data = array(
            'css' => BackendController::css([
                'https://cdn.jsdelivr.net/gh/AdrianVillamayor/Wizard-JS@1.9.9/styles/css/main.css',
                PLUGINPATH . 'backend/select2/select2.min.css'
            ]),
            'js' => BackendController::js([
                PLUGINPATH . 'backend/select2/select2.min.js',
                'https://cdn.jsdelivr.net/gh/AdrianVillamayor/Wizard-JS@1.9.9/src/wizard.min.js',
                PLUGINPATH . 'backend/ckeditor/ckeditor.js',
                PLUGINPATH . 'backend/ckeditor/ckfinder/ckfinder.js',
                JSPATH . 'backend/organization.js'
            ]),
            'title' => BackendController::$siteSettings['site_name_alt'] . ' - Pengaturan Organisasi',
            'role' => $this->role
        );

        return BackendController::view([
            '_templates/backend/head',
            '_templates/backend/sidebar',
            '_templates/backend/navbar',
            'App\Modules\Backend\Views\organization_view',
            '_templates/backend/footer',
            '_templates/backend/script'
        ], $data);
    }

    public function save()
    {
        if($this->request->isAJAX()) {

            $status = false;
            $message= '';
            $errors = ['validations' => []];
            $post   = $this->request->getVar();
            
            if($this->validation->run($post, 'organization')) {
                $post['social_media']['email'] = $post['org_email'];
                $post['org_social_media'] = json_encode($post['social_media']);
                $post['updated_at'] = date('Y-m-d H:i:s');
                $status = $this->orgModel->save($post);
                $message= ($status) ? 'Pengaturan organisasi disimpan.' : 'Gagal menyimpan pengaturan organisasi.';
                if($status) {
                    cache()->delete('site_setting');
                    logging('settings', 'Organization settings has been change by '.self::$udata['user_name']);
                }
            }
            else {
                $errors['validations'] = $this->validation->getErrors();
            }

            $result = array(
                'token'  => csrf_hash(),
                'status' => $status,
                'message'=> $message,
                'errors' => $errors
            );
            return $this->response->setStatusCode(200)->setJSON($result);
        }
        else {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed']);
        }

    }
}