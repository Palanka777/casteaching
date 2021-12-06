<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Tests\Feature\Users\UserManageTest;

class UserManageController extends Controller
{
    public static function testedBy()
    {
        return UserManageTest::class;
    }

    public function index()
    {
        return view('users.manage.index',[
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password' => Hash::make($request->password)
        ]);

        add_personal_team($user);

//        $user->givePermissionTo('users_manage_index');

        session()->flash('status','Successfully created');
        return redirect(route('manage.users'));


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return view('users.manage.edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        session()->flash('status','Successfully removed');
        return redirect()->route('manage.users');

    }
}
