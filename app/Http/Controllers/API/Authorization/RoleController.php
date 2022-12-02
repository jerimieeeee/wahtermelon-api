<?php

namespace App\Http\Controllers\API\Authorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade as Bouncer;

class RoleController extends Controller
{
    /**
     * @authenticated
     */
    public function addRole()
    {
        $admin = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        $ban = Bouncer::ability()->firstOrCreate([
            'name' => 'ban-users',
            'title' => 'Ban users',
        ]);

        Bouncer::allow($admin)->to($ban);
        return "OK";
    }
}
