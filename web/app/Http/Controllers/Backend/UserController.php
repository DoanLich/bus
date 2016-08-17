<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\UserRequest;
use App\Http\Controllers\Common\Controller;

class UserController extends Controller
{
    public function add()
    {
    	$actions = [['url' => '#', 'label' => trans('backend/systems.list')]];
    	
    	return view('backend.users.add', compact('actions', 'breadcrumbs'));
    }
    public function store(UserRequest $request)
    {
    }
}
