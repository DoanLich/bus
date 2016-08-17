<?php

namespace App\Http\Controllers\Backend;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\Controller;

class BackendController extends Controller
{
    protected $authUser;

    public function __construct()
    {
        $this->authUser = Auth::guard('admins')->user();
    }

    public function authorizeForAdmin($ability, $arguments = [])
    {
        $this->authorizeForUser($this->authUser, $ability, $arguments);
    }


}
