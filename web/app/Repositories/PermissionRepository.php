<?php
/**
 * @Author: Lich
 * @Date:   2016-08-07 21:20:57
 * @Last Modified by:   doanlich
 * @Last Modified time: 2016-08-17 14:53:51
 */
namespace App\Repositories;

use Illuminate\Container\Container as App;
use App\Repositories\Eloquent\Repository;
use App\Models\Permission;
use App\Repositories\RoleRepository as Role;

class PermissionRepository extends Repository
{
    protected $role;

    public function __construct(App $app, Role $role)
    {   
        $this->role = $role;

        parent::__construct($app);
    }

    public function model()
    {
        return Permission::class;
    }

    public function getAssignList()
    {
        $permissions = $this->all();

        $permissions = $permissions->keyBy('id');

        $defaultPermissions = $this->getPermissionIdOfDefaultRole();

        $permissions = $permissions->forget($defaultPermissions);

        $permissions->each(function ($permission) {
            $permission->group_name = $permission->getGroupName();
        });

        return $permissions;
    }

    public function getPermissionIdOfDefaultRole()
    {
        $defaultPermissions = [];
        $roles = $this->role->getDefaultRole();
        if(! $roles->isEmpty()) {
            foreach ($roles as $role) {
                $defaultPermissions = array_merge($defaultPermissions, $role->permissions()->getRelatedIds()->toArray());
            }
        }

        return array_unique($defaultPermissions);
    }
}