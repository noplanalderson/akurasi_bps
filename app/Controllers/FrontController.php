<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class FrontController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class FrontController extends BaseController
{
    protected static $navbars;

    protected static $navBottom;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        if(empty(cache()->get('navbars'))) {
            $navbars = [];
            $menus = $this->navbarModel->orderBy('nav_sequence', 'asc')
                                       ->getWhere(['nav_position' => 'top', 'nav_parent IS NULL' => null])
                                       ->getResultArray();
            
            foreach ($menus as $value) {
                $submenus = $this->navbarModel->orderBy('nav_sequence', 'asc')
                                              ->getWhere(['nav_position' => 'top', 'nav_parent' => $value['nav_id']])
                                              ->getResultArray();
                $navbars[] = array(
                    'nav_id' => $value['nav_id'],
                    'nav_name' => $value['nav_name'],
                    'nav_slug' => $value['nav_slug'],
                    'nav_sequence' => $value['nav_sequence'],
                    'custom_link' => $value['custom_link'],
                    'open_newtab' => $value['open_newtab'],
                    'submenus' => $submenus
                );
            }
            cache()->save('navbars', $navbars, 7200);
        }

        if(empty(cache()->get('navBottom'))) {
            $navBottom = $this->navbarModel->orderBy('nav_sequence', 'asc')
                                           ->getWhere(['nav_position' => 'bottom', 'nav_parent IS NULL' => null])
                                           ->getResultArray();
            cache()->save('navBottom', $navBottom, 7200);
        }

        FrontController::$navbars  = cache()->get('navbars');
        FrontController::$navBottom= cache()->get('navBottom');
    }

    protected static function view($views = '', $data = null)
    {
        $data = array_merge($data, [
            'setting' => FrontController::$siteSettings,
            'navbar' => FrontController::$navbars,
            'bottom_navs' => FrontController::$navBottom,
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
