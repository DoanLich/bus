<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = 'admins';

    protected $fillable = [
        'name', 'email', 'password', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            if(is_file($user->getAvatarPath())){
                unlink($user->getAvatarPath());
            }
        });
    }

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function isActive()
    {
        return $this->status == config('constant.active_status');
    }

    public function getRole()
    {
        $defaultRoles = Role::defaultRole()->active()->get();
        $roles = $defaultRoles->merge($this->roles);
        return $roles->filter(function($role) {
            return $role->isActive();
        });
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

    public function getAvatarPath($fileName = null)
    {
        $storePath = \Storage::disk('avatar')->getDriver()->getAdapter()->getPathPrefix();
        if($fileName != null) {
            return $storePath.$fileName;
        }

        if($this->avatar != null) {
            return $storePath.$this->avatar;
        }

        return null;
    }

    public function getAvatar()
    {
        $image = 'default.png';
        if($this->avatar != null) {
            $image = $this->avatar;
        }
        $avatarPath = \Storage::disk('avatar')->getAdapter()->getPathPrefix();

        return url(path_to_url(str_replace(public_path(), '', $avatarPath)).$image);
    }

    public function hasSystemRole()
    {
        $roles = $this->roles;
        foreach ($roles as $role) {
            if($role->isSystem()) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission($permission)
    {
        if(!is_array($permission)) {
            $permission = [$permission];
        }

        $assignedPermissions = collect([]);
        $roles = $this->getRole();
        foreach ($roles as $role) {
            $assignedPermissions = $assignedPermissions->merge($role->getPermission());
        }

        $assignedPermissions = $assignedPermissions->keyBy('id')->unique();

        $count = 0;
        foreach ($permission as $value) {
            $check = $assignedPermissions->contains('index', $value);
            if($check) {
                $count ++;
            }
        }

        return $count == count($permission);
    }

    public function getMenu()
    {
        $menus = \App\Models\AdminMenu::all();
        $menus = $menus->keyBy('id');

        $menus = $menus->filter(function ($menu) {
            $hasPermission = false;
            if($menu->permission != null){
                $hasPermission = $this->hasPermission($menu->permission->index);
            } elseif(!$menu->childrens->isEmpty()) {
                foreach ($menu->childrens as $children) {
                    if($this->hasPermission($children->permission->index)) {
                        $hasPermission = true;
                        break;
                    }
                }
            } else {
                $hasPermission = true;
            }

            return $hasPermission && $menu->level == 1;
        });

        return $menus;
    }
}
