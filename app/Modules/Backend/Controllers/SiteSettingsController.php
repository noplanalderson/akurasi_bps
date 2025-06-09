<?php
namespace App\Modules\Backend\Controllers;

use App\Controllers\BackendController;
use App\Modules\Backend\Models\SiteModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class SiteSettingsController extends BackendController
{
    protected $siteModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->siteModel = new SiteModel();
    }

    public function index()
    {
        $data = array(
            'css' => BackendController::css([
                PLUGINPATH . 'backend/select2/select2.min.css',
            ]),
            'js' => BackendController::js([
                PLUGINPATH . 'backend/select2/select2.min.js',
                PLUGINPATH . 'backend/tags/jquery.tagsinput.min.js',
                PLUGINPATH . 'backend/ckeditor/ckfinder/ckfinder.js',
                JSPATH . 'backend/site-settings.js'
            ]),
            'title' => BackendController::$siteSettings['site_name_alt'] . ' - Pengaturan Aplikasi',
            'role' => $this->role
        );

        return BackendController::view([
            '_templates/backend/head',
            '_templates/backend/sidebar',
            '_templates/backend/navbar',
            'App\Modules\Backend\Views\site_settings_view',
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
            
            $data = [
                'site_id' => $post['site_id'],
                'site_name' => $post['site_name'],
                'site_name_alt' => $post['site_name_alt'],
                'site_description' => $post['site_description'],
                'site_author' => $post['site_author'],
                'site_keywords' => $post['site_keywords'],
                'site_logo' => $post['site_logo'],
                'info_adm' => json_encode(array(
                    'no_surat_dinas' => $post['no_surat_dinas'],
                    'no_sk_kpa' => $post['no_sk_kpa'],
                    'laporan_keuangan' => $post['laporan_keuangan'],
                    'monitoring_kegiatan' => $post['monitoring_kegiatan']
                )),
                'pedoman_adm_keuangan' => json_encode(array(
                    'file_pok' => $post['file_pok'],
                    'file_pak' => $post['file_pak'],
                    'file_peraturan' => $post['file_peraturan']
                )),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if($this->validation->run($post, 'site_settings')) {
                $status = $this->siteModel->save($data);
                $message= ($status) ? 'Pengaturan aplikasi disimpan.' : ' Gagal menyimpan pengaturan aplikasi.';
                if($status) {
                    cache()->delete('site_setting');
                    logging('settings', 'Site settings has been change by '.self::$udata['user_name']);
                }
            }
            else {
                $errors['validations'] = $this->validation->getErrors();
            }

            $result = array(
                'csrf_token'  => csrf_hash(),
                'status' => $status,
                'message'=> $message,
                'json' => $post,
                'errors' => $errors
            );
            return $this->response->setStatusCode(200)->setJSON($result);
        }
        else {
            return $this->response->setStatusCode(405)->setJSON(['status' => false, 'code' => 405, 'message' => 'Method not Allowed']);
        }

    }
}