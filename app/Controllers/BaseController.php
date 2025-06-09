<?php

namespace App\Controllers;

use App\Libraries\SeoLib;
use App\Modules\Backend\Models\PostsModel;
use App\Modules\Frontend\Models\NavigationModel;
use App\Modules\Frontend\Models\OrgModel;
use App\Modules\Frontend\Models\SiteModel;
use App\Modules\Frontend\Models\VisitorModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * Instance of the validation service.
     * 
     * @var \CodeIgniter\Validation\Validation
    */ 
    protected $validation;

    /**
     * Instance of the session service.
     * 
     * @var \CodeIgniter\Session\Session
    */
    protected $session;

    /**
     * Instance of the Seo Library.
     * 
     * @return void
    */
    protected $seo;
    
    /**
     * Instance of SiteModel.
     * 
     * @var \App\Modules\Frontend\Models\SiteModel
    */
    protected $siteModel;

    /**
     * Instance of OrgModel.
     * 
     * @var \App\Modules\Frontend\Models\OrgModel
    */
    protected $orgModel;

    /**
     * Instance of NavigationModel.
     * 
     * @var \App\Modules\Frontend\Models\NavigationModel
    */
    protected $navbarModel;

    /**
     * Instance of VisitorModel.
     * 
     * @var \App\Modules\Frontend\Models\VisitorModel
    */
    protected $visitorModel;

     /**
     * Instance of PostModel.
     * 
     * @var \App\Modules\Frontend\Models\PostModel
    */
    protected $postModel;

    protected static $siteSettings;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->session = Services::session();
        $this->validation = Services::validation();
        $this->siteModel = new SiteModel();
        $this->orgModel = new OrgModel();
        $this->navbarModel = new NavigationModel();
        
        if(empty(cache()->get('site_setting'))) {
            cache()->save('site_setting', array_merge($this->siteModel->first(), $this->orgModel->first()), 7200);
        }

        BaseController::$siteSettings = cache()->get('site_setting');

    }

    protected static function css($css = '')
    {
        if(is_array($css)) {
            $c = null;
            for ($i = 0; $i < count($css); $i++) {
                $c .= link_tag($css[$i])."\n";
            }
        } else {
            $c = link_tag($css);
        }

        return $c;
    }

    protected static function js($js = '')
    {
        if(is_array($js)) {
            $j = null;
            for ($i = 0; $i < count($js); $i++) {
                $j .= script_tag($js[$i])."\n";
            }
        } else {
            $j = script_tag($js);
        }

        return $j;
    }
}
