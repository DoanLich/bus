<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    public function index(Admin $user, Location $permission)
    {
        return true;
    }

    public function add(Admin $user, Location $permission)
    {
        return true;
    }
    public function edit(Admin $user, Location $permission)
    {
        return true;
    }

    public function delete(Admin $user, Location $permission)
    {
        return true;
    }

    public function view(Admin $user, Location $permission)
    {
        return true;
    }
}
