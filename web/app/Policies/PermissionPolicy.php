<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function index(Admin $user, Permission $permission)
    {
        return $user->hasPermission('permissions.list');
    }

    public function add(Admin $user, Permission $permission)
    {
        return $user->hasPermission('permissions.add');
    }
    public function edit(Admin $user, Permission $permission)
    {
        return $user->hasPermission('permissions.edit');
    }

    public function delete(Admin $user, Permission $permission)
    {
        return $user->hasPermission('permissions.delete');
    }

    public function view(Admin $user, Permission $permission)
    {
        return $user->hasPermission('permissions.view');
    }
}
