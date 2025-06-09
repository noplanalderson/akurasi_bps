<?php
/*
 * CKFinder Configuration File
 *
 * For the official documentation visit https://ckeditor.com/docs/ckfinder/ckfinder3-php/
 */

/*============================ PHP Error Reporting ====================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/debugging.html

// echo dirname(__DIR__) . '/../../../uploads/sites/';
// echo exec('DIR '.dirname(__DIR__) . '/../../../uploads/sites/');
// die();
define('FCPATH', $_SERVER['DOCUMENT_ROOT']);

function url(){
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['SERVER_NAME'];
    $port = (isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] !== '80' || $_SERVER['SERVER_PORT'] !== '443') ? ':'.$_SERVER['SERVER_PORT'] : null);
    $baseUrl = $protocol . "://" . $host . $port;
    return $baseUrl;
}

if(!isset($_GET['uid']) && !isset($_GET['access'])) {
    http_response_code(403);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'code' => 403,
        'message' => 'Forbidden'
    ]);
    exit;
} else {
    $uid = (int)$_GET['uid'];
    $gid = (int)$_GET['gid'];

    $accessB64 = strtr($_GET['access'], '-_', '+/');
    $access = (array)json_decode(base64_decode($accessB64, false));
    
    if(!$access['logged']) {
        http_response_code(403);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'code' => 403,
            'message' => 'Forbidden'
        ]);
        exit;
    }
}

// Production
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 0);

// Development
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*============================ General Settings =======================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html

$config = array();

/*============================ Enable PHP Connector HERE ==============================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_authentication

$config['authentication'] = function () {
    $accessB64 = strtr($_GET['access'], '-_', '+/');
    $access = (array)json_decode(base64_decode($accessB64, false));
    return $access['logged'];
};

/*============================ License Key ============================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_licenseKey

$config['licenseName'] = 'alutsista.local';
$config['licenseKey']  = 'LMDM3Y5FBVEWTCKWMCG3PRF84WKDC';

/*============================ CKFinder Internal Directory ============================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_privateDir

$config['privateDir'] = array(
    'backend' => 'default',
    'tags'   => '.ckfinder/tags',
    'logs'   => '.ckfinder/logs',
    'cache'  => '.ckfinder/cache',
    'thumbs' => '.ckfinder/cache/thumbs',
);

/*============================ Images and Thumbnails ==================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_images

$config['images'] = array(
    'maxWidth'  => 1600,
    'maxHeight' => 1200,
    'quality'   => 80,
    'sizes' => array(
        'small'  => array('width' => 480, 'height' => 320, 'quality' => 80),
        'medium' => array('width' => 600, 'height' => 480, 'quality' => 80),
        'large'  => array('width' => 800, 'height' => 600, 'quality' => 80)
    )
);

/*=================================== Backends ========================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_backends

$config['backends'][] = array(
    'name'         => 'default',
    'adapter'      => 'local',
    'baseUrl'      => url() . '/uploads/sites/',
    'root'         => FCPATH . '/uploads/sites/', // Can be used to explicitly set the CKFinder user files directory.
    'chmodFiles'   => 0644,
    'chmodFolders' => 0755,
    'filesystemEncoding' => 'UTF-8',
);

/*================================ Resource Types =====================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_resourceTypes

$config['defaultResourceTypes'] = '';

$config['resourceTypes'][] = array(
    'name'              => 'Files', // Single quotes not allowed.
    'directory'         => 'files',
    'maxSize'           => '5M',
    // 'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip',
    'allowedExtensions' => 'doc,docx,pdf,ppt,pptx,txt',
    'deniedExtensions'  => 'php,phtml,shtml,html,php4,php5,exe,cfg,conf,dll',
    'backend'           => 'default'
);

$config['resourceTypes'][] = array(
    'name'              => 'Images',
    'directory'         => 'images',
    'maxSize'           => '5M',
    'allowedExtensions' => 'webp,jpg,png,jpeg',
    'deniedExtensions'  => 'php,phtml,shtml,html,php4,php5,exe,cfg,conf,dll',
    'backend'           => 'default'
);

$config['resourceTypes'][] = array(
    'name'              => 'Videos',
    'directory'         => 'videos',
    'maxSize'           => '20M',
    'allowedExtensions' => 'mp4,flv',
    'deniedExtensions'  => 'php,phtml,shtml,php4,php5,exe,cfg,conf,dll',
    'backend'           => 'default'
);
/*================================ Access Control =====================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_roleSessionVar

// $config['roleSessionVar'] = 'CKFinder_UserRole';
$config['roleSessionVar'] = 'CKFinder_UserRole';
// 
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_accessControl
$config['accessControl'][] = array(
    'role'                => '*',
    'resourceType'        => '*',
    'folder'              => '/',

    'FOLDER_VIEW'         => true,
    'FOLDER_CREATE'       => ($access['fm_create'] == 1 ? true : false),
    'FOLDER_RENAME'       => ($access['fm_rename'] == 1 ? true : false),
    'FOLDER_DELETE'       => ($access['fm_delete'] == 1 ? true : false),

    'FILE_VIEW'           => true,
    'FILE_CREATE'         => ($access['fm_create'] == 1 ? true : false),
    'FILE_RENAME'         => ($access['fm_rename'] == 1 ? true : false),
    'FILE_DELETE'         => ($access['fm_delete'] == 1 ? true : false),

    'IMAGE_RESIZE'        => ($access['fm_create'] == 1 ? true : false),
    'IMAGE_RESIZE_CUSTOM' => ($access['fm_create'] == 1 ? true : false)
);


/*================================ Other Settings =====================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html

$config['overwriteOnUpload'] = true;
$config['checkDoubleExtension'] = true;
$config['disallowUnsafeCharacters'] = true;
$config['secureImageUploads'] = true;
$config['checkSizeAfterScaling'] = true;
$config['htmlExtensions'] = array('html', 'htm', 'xml', 'js');
$config['hideFolders'] = array('.*', 'CVS', '__thumbs');
$config['hideFiles'] = array('.*');
$config['forceAscii'] = true;
$config['xSendfile'] = false;

// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_debug
$config['debug'] = false;

/*==================================== Plugins ========================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_plugins

$config['pluginsDirectory'] = __DIR__ . '/plugins';
$config['plugins'] = array();

/*================================ Cache settings =====================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_cache

$config['cache'] = array(
    'imagePreview' => 24 * 3600,
    'thumbnails'   => 24 * 3600 * 365,
    'proxyCommand' => 0
);

/*============================ Temp Directory settings ================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_tempDirectory

$config['tempDirectory'] = sys_get_temp_dir();

/*============================ Session Cause Performance Issues =======================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_sessionWriteClose

$config['sessionWriteClose'] = true;

/*================================= CSRF protection ===================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_csrfProtection

$config['csrfProtection'] = false;

/*===================================== Headers =======================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_headers

$config['headers'] = array();

/*============================== End of Configuration =================================*/

// Config must be returned - do not change it.
return $config;
