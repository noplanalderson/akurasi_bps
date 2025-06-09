<?php
namespace App\Modules\Backend\Controllers;

use App\Controllers\BackendController;
use App\Modules\Backend\Models\CategoryModel;
use CKSource\CKFinder\Backend\Backend;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class InformationController extends BackendController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title' => BackendController::$siteSettings['site_name_alt'] . ' - Informasi dan Pedoman',
            'role' => $this->role
        ];

        return BackendController::view([
            '_templates/backend/head',
            '_templates/backend/sidebar',
            '_templates/backend/navbar',
            'App\Modules\Backend\Views\information_view',
            '_templates/backend/footer',
            '_templates/backend/script'
        ], $data);
    }
}