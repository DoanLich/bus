<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Common\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $linkRequestView = 'backend.auth.passwords.email';

    protected $resetView = 'backend.auth.passwords.reset';

    protected $redirectPath = '/admin';

    protected $guard = 'admins';

    protected $broker = 'admins';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest');
    }
}
