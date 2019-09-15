<?php

namespace App\Http\Controllers\Frontend\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() 
    {
        return view('frontend.client.dashboard');
    }
}
