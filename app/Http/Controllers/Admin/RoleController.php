<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    protected $roleModel;
    protected $permissionModel;

    public function __construct()
    {
        $this->roleModel = Config::get('laratrust.models.role');
        $this->permissionModel = Config::get('laratrust.models.permission');
    }

    public function create (Request $request)
    {
        $role = $this->roleModel::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        $role->syncPermissions((!empty($request->permissions)) ? json_decode($request->permissions) : []);

        return response('created successfully', 200);
    }

    public function destroy ($id)
    {
        $role = $this->roleModel::findOrFail($id);

        $role_permissions = DB::table('permission_role')->where('role_id', $id)->get();
        foreach ($role_permissions as $key => $value) {
            unset($value);
        }

        // test this part
        $role->delete();

        return response('deleted', 200);
    }

    public function update (Request $request, $id)
    {
        $role = $this->roleModel::findOrFail($id);
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        $role->syncPermissions(!empty($request->permissions) ? json_decode($request->permissions) : []);

        return response('updated', 200);
    }

}
