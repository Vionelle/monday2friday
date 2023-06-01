<?php

namespace App\Controllers;

class About extends BaseController
{
    public function index()
    {
        return view('about',[
            'cart' => $cart = \Config\Services::cart()
        ]);
        // return view('data/test');
        
    }
}