<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusTrip extends Model
{
    protected $fillable = ['start_location', 'end_location', 'start_point', 'end_point', 'start_time', 'end_time', 'seat_type', 'seat_count', 'price', 'status'];

    public function startLocation()
    {
        return $this->belongsTo(\App\Models\Location::class, 'start_location', 'id');
    }

    public function endLocation()
    {
        return $this->belongsTo(\App\Models\Location::class, 'end_location', 'id');
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
