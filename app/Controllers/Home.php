<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('data/test',['data'=>'Test lagi']);
        return view('layout');
    }
}
