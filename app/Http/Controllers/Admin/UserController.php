<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserEditResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index ()
    {
        $users = User::paginate(10);

        return response()->json([
            'data' => $users
        ], 200);
    }

    public function create (Request $request)
    {
        $roles = Role::all();

        return response()->json([
            'data' => $roles
        ], 200);
    }

    public function store (Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $roles = Role::find(json_decode($request->role_id));

        $user->syncRoles($roles);

        return response()->json('created', 200);
    }

    public function edit (Request $request, $id)
    {
        $user = User::with('roles', 'permissions')->where('id', $id)->get();
        return UserEditResource::collection($user);
    }

    public function update (Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $roles = $user->roles()->get();
        foreach ($roles as $role) {
            $user->detachRole($role);
        }

        $roles = Role::find(json_decode($request->role_id));
        $user->syncRoles($roles);

        return response()->json('updated', 200);
    }
}
