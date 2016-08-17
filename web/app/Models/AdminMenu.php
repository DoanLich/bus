<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    protected $fillable = [
        'index', 'permission_id', 'name', 'icon', 'route', 'level', 'parent_id', 'order'
    ];

    public function permission()
    {
        return $this->belongsTo(\App\Models\Permission::class);
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    public function isActive()
    {
        if(\Route::is($this->route)) {
            return true;
        }
        if(!$this->childrens->isEmpty()) {
            foreach ($this->childrens as $menu) {
                if(\Route::is($menu->route)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getChildMenu()
    {
        $menus = $this->childrens;
        $menus = $menus->filter(function($menu) {
            return auth()->guard('admins')->user()->hasPermission($menu->permission->index);
        });

        return $menus;
    }

    public function getName()
    {
        if(\Lang::has('backend/menus.'.$this->index, app()->getLocale(), false)) {
            return trans('backend/menus.'.$this->index);
        }

        return $this->name;
    }
}
