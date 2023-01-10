<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $articles = array();
        $data = [
            'articles' => $articles,

        ];
        return view('user/dashboard', $data);
    }
}
