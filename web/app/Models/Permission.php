<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['parent_id', 'index', 'name', 'description', 'status', 'group'];

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'role_permissions');
    }

    public function parent()
    {
         return $this->belongsTo(static::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', config('constant.active_status'));
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
}
