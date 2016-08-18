<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\BusTrip;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusTripPolicy
{
    use HandlesAuthorization;

    public function index(Admin $user, BusTrip $bus)
    {
        return true;
    }

    public function add(Admin $user, BusTrip $bus)
    {
        return true;
    }
    public function edit(Admin $user, BusTrip $bus)
    {
        return true;
    }

    public function delete(Admin $user, BusTrip $bus)
    {
        return true;
    }

    public function view(Admin $user, BusTrip $bus)
    {
        return true;
    }
}
