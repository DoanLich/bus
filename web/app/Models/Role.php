<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const IS_SYSTEM = 1;
    const IS_DEFAULT = 1;
    protected $fillable = ['name', 'description', 'status', 'system', 'default'];

    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Permission::class, 'role_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\Admin::class, 'user_roles', 'user_id', 'role_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', config('constant.active_status'));
    }

    public function scopeDefaultRole($query)
    {
        return $query->where('default', static::IS_DEFAULT);
    }

    public function isActive()
    {
        return $this->status == config('constant.active_status');
    }

    public function getStatusAsText()
    {
        $status = config('constant.status_list');

        return $status[$this->status];
    }

    public function getStatusColor()
    {
        return $this->isActive() ? config('constant.active_status_color') : config('constant.block_status_color');
    }

    public function isSystem()
    {
        return $this->system == static::IS_SYSTEM;
    }

    public function isDefault()
    {
        return $this->default == static::IS_DEFAULT;
    }

    public function getPermission()
    {
        $roles = static::defaultRole()->active()->get();
        // Get default permission
        $defaultPermissions = [];
        if(count($roles) > 0) {
            foreach ($roles as $role) {
                if(count($defaultPermissions) > 0) {
                    $defaultPermissions = $defaultPermissions->merge($role->permissions);
                } else {
                    $defaultPermissions = $role->permissions;
                }
            }
        }
        if(count($defaultPermissions) > 0) {
            $permissions =  $defaultPermissions->merge($this->permissions);
        } else {
            $permissions = $this->permissions;
        }
        $permissions = $permissions->keyBy('id')->unique();
        // Get parents permission
        return $this->getParentPermisson($permissions)->sortBy('group');
    }

    private function getParentPermisson($permissions)
    {
        $allPermissions = collect($permissions);
        $permissions = $permissions->keyBy('id');
        $forgetId = [];
        while (count($permissions) > 0) {
            foreach ($permissions as $key => $value) {
                if($value->parent != null) {
                    $parent = $value->parent;
                    $permissions->merge(collect([$parent->id => $parent]));
                    $allPermissions = $allPermissions->merge(collect([$parent->id => $parent]));
                }

                $forgetId[] = $key;
            }

            $permissions =  $permissions->unique()
                                        ->keyBy('id')
                                        ->forget($forgetId);
        }

        return $allPermissions->keyBy('id')->unique();
    }
}
