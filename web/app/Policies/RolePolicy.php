<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function index(Admin $user, Role $role)
    {
        return $user->hasPermission('roles.list');
    }
    public function add(Admin $user, Role $role)
    {
        return $user->hasPermission('roles.add');
    }
    public function edit(Admin $user, Role $role)
    {
        return $user->hasPermission('roles.edit') && !$role->isSystem();
    }
    public function delete(Admin $user, Role $role)
    {
        return $user->hasPermission('roles.delete') && !$role->isSystem();
    }
    public function view(Admin $user, Role $role)
    {
        return $user->hasPermission('roles.view');
    }
}
