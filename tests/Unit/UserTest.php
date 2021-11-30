<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    public function isSuperAdmin()
    {
        $user = User::Create([
            'name'=>'SuperAdmin',
            'email'=>'superadmin@hot.com',
            'password'=>Hash::make('12345678'),

        ]);
        $this->assertEquals($user->isSuperAdmin(),false);

        $user->superadmin=true;
        $user->save();
        $this->assertEquals($user->isSuperAdmin(),true);
    }
}
