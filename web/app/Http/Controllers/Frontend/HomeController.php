<?php

namespace App\Http\Controllers\Frontend;

use App\Jobs\SendMail;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\Controller;

class HomeController extends Controller
{
    public function index()
    {
    	$this->authorize('add', new \App\Models\User());
        
    	return view('frontend.homes.index');
    }
}
