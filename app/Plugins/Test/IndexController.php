<?php

namespace App\Plugins\Test;

use App\Controllers\BaseController;
use Jenssegers\Blade\Blade;

class IndexController extends BaseController
{
    /**
     * Главная страница
     */
    public function index()
    {
        blade()->addNamespace('test', APP . '/Plugins/Test/views');


        return view('test::xxx');


   /*

        return $blade->render($view, $params);


        return view('index');*/
    }
}
