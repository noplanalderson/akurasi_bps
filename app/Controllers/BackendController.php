<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BackendController
 * 
 * BackendController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new backend controllers:
 *     Ex: class Dashboard extends BackendController
*/
abstract class BackendController extends BaseController
{
    protected $role;
    
    protected static $hash = '';

    protected static $udata = array();

    protected static $umenu = array('user_menu' => null, 'user_submenu' => null, 'user_btnmenu' => null);

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        if(session()->get('uid') && session()->get('gid')) 
        {
            self::$hash = hash('sha3-256', session()->get('uid'));
            self::$udata = session()->get();
        }
    }

    protected static function view($views = '', $data = null)
    {
        $data = array_merge($data, [
            'mainmenu' => session()->get('user_menu'),
            'submenu' => session()->get('user_submenu'),
            'btnmenu' => session()->get('user_btnmenu'),
            'user' => self::$udata,
            'setting' => BaseController::$siteSettings,
            'social_media' => json_decode(BaseController::$siteSettings['org_social_media'], true)
        ]);

        if(is_array($views)) {
            $view = null;
            for ($i = 0; $i < count($views); $i++) {
                $view .= view($views[$i], $data);
            }
        } else {
            $view = view($views, $data);
        }

        return $view;
    }
}
