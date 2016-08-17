<?php
/**
 * @Author: doanlich
 * @Date:   2016-08-17 10:30:53
 * @Last Modified by:   doanlich
 * @Last Modified time: 2016-08-17 10:31:58
 */
namespace App\Repositories;

use App\Repositories\Eloquent\Repository;
use App\Models\Admin;

class AdminUserRepository extends Repository
{
    public function model()
    {
        return Admin::class;
    }
}