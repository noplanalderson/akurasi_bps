<?php
namespace App\Modules\Frontend\Controllers;

use App\Controllers\FrontController;

class HomeController extends FrontController
{
    public function index(): string
    {
        return view('welcome_message');
    }
}
