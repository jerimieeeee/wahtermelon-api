<?php

namespace App\Http\Controllers\API\Authorization;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\V1\Patient\Patient;
use Silber\Bouncer\BouncerFacade as Bouncer;

class RoleController extends Controller
{
    /**
     * @authenticated
     */
    public function addRole()
    {
//        $admin = Bouncer::role()->firstOrCreate([
//            'name' => 'admin',
//            'title' => 'Administrator',
//        ]);
//
//        $ban = Bouncer::ability()->firstOrCreate([
//            'name' => 'ban-users',
//            'title' => 'Ban users',
//        ]);
//
//        Bouncer::allow($admin)->to($ban);
        //$user = User::whereIs('admin')->get();

        return auth()->user()->getAbilities();

        return Bouncer::is(auth()->user())->an('admin');
        Bouncer::allow('admin')->to('ban-users');
        Bouncer::assign('admin')->to(auth()->id());
        Bouncer::allow(auth()->id())->to('ban-users');
        Bouncer::allow(auth()->id())->to('edit', Patient::class);
        Bouncer::allow(auth()->id())->toOwn(Patient::class);

        return 'OK';
    }
}
