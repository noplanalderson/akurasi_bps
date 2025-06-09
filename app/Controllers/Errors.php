<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Errors extends BaseController
{
    public function index($code)
    {
        $this->response->setStatusCode($code);
        $data['message'] = 'Halaman tidak ditemukan';
        return view('errors/html/error_'.$code, $data);
    }

    public function show404()
    {
        $this->response->setStatusCode(404);
        $data['message'] = 'Halaman tidak ditemukan';
        return view('errors/html/error_404', $data);
    }
}
