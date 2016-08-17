<?php
/**
 * @Author: doanlich
 * @Date:   2016-08-17 09:37:51
 * @Last Modified by:   doanlich
 * @Last Modified time: 2016-08-17 10:38:57
 */
namespace App\Repositories;

use App\Repositories\Eloquent\Repository;
use App\Models\Role;

class RoleRepository extends Repository
{
    public function model()
    {
        return Role::class;
    }

    public function getDefaultRole()
    {
        return $this->getObject()->defaultRole()->active()->get();
    }

    public function getAssignRole()
    {
        return $this->getObject()->active()->where('default', '<>', Role::IS_DEFAULT)->where('system', '<>', Role::IS_SYSTEM)->get();
    }
}
