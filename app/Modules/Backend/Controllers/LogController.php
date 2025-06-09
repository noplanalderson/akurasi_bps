<?php
namespace App\Modules\Backend\Controllers;

use App\Controllers\BackendController;
use App\Modules\Backend\Models\LogModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

class LogController extends BackendController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        if($this->request->isAJAX()) {
            $draw       = $this->request->getVar('draw');
            $query      = $this->request->getVar('search[value]');
            $start      = $this->request->getVar('start');
            $length     = $this->request->getVar('length');
            $column     = $this->request->getVar('columns');
            $orderby    = $this->request->getVar('order[0][column]');
            $orderby    = empty($orderby) ? 'datetime' : preg_replace('/[^a-z0-9._]/', '', $column[$orderby]['name']);
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

                $logs = new LogModel();
                $data   = $logs->getLogs($request);
                $result = [
                    "draw" => $draw,
                    "recordsTotal" => $logs->countLogs($request),
                    "recordsFiltered" => $logs->countLogFiltered($request),
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
                    JSPATH . 'backend/logs.js'
                ]),
                'title' => BackendController::$siteSettings['site_name_alt'] . ' - Log Aplikasi',
                'role' => $this->role
            );

            return BackendController::view([
                '_templates/backend/head',
                '_templates/backend/sidebar',
                '_templates/backend/navbar',
                'App\Modules\Backend\Views\log_view',
                '_templates/backend/footer',
                '_templates/backend/script'
            ], $data);
        }
    }
}