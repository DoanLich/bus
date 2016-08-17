<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function index(Admin $loginUser, Admin $user)
    {
        return $loginUser->hasPermission('admin_users.list');
    }
    public function add(Admin $loginUser, Admin $user)
    {
        return $loginUser->hasPermission('admin_users.add');
    }
    public function edit(Admin $loginUser, Admin $user)
    {
        return $loginUser->hasPermission('admin_users.edit') && (!$user->hasSystemRole() || ($user->hasSystemRole() & $loginUser->hasSystemRole()));
    }
    public function delete(Admin $loginUser, Admin $user)
    {
        return $loginUser->hasPermission('admin_users.delete') && !$user->hasSystemRole() && $loginUser->id != $user->id;
    }
    public function view(Admin $loginUser, Admin $user)
    {
        return $loginUser->hasPermission('admin_users.view');
    }
    public function profile(Admin $loginUser, Admin $user)
    {
        return $loginUser->hasPermission('profile') && $loginUser->id == $user->id;
    }
}
