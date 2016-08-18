<?php
/**
 * @Author: doanlich
 * @Date:   2016-08-18 15:44:30
 * @Last Modified by:   doanlich
 * @Last Modified time: 2016-08-18 15:45:06
 */
namespace App\Repositories;

use App\Repositories\Eloquent\Repository;
use App\Models\BusTrip;

class BusTripRepository extends Repository
{
    public function model()
    {
        return BusTrip::class;
    }
}