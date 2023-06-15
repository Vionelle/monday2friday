<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {               
        return view('home',[
            'cart' => $cart = \Config\Services::cart()
        ]);
        // return view('data/test');
        
    }
}
