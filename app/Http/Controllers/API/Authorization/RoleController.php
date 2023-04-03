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
        return $user = User::whereIs('admin')->get();
        //return Patient::query()->get();

        return auth()->user()->isAn('admin');
        Bouncer::allow(auth()->user())->toOwn(Patient::class)->to('update');

        return auth()->user()->getUserAbilities();
        //return Bouncer::is(auth()->user())->an('admin');
        Bouncer::allow('admin')->to('ban-users');
        Bouncer::assign('admin')->to(auth()->id());
        Bouncer::allow(auth()->id())->to('ban-users');
        Bouncer::allow(auth()->id())->to('edit', Patient::class);
        Bouncer::allow(auth()->user())->toOwn(Patient::class);

        return 'OK';
    }
}
