<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * ホーム画面の表示.
     */
    public function index()
    {
        return view('home');
    }
}
