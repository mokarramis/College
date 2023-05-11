<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    protected $roleModel;
    protected $permissionModel;

    public function __construct()
    {
        $this->roleModel = Config::get('laratrust.models.role');
        $this->permissionModel = Config::get('laratrust.models.permission');
    }
    
    public function store (Request $request)
    {
        Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        return response('added permissions', 200);
    }

    public function show ($id)
    {
        $this->permissionModel::findOrFail($id);

        return response('found', 200);
    }

    public function update (Request $request, $id)
    {
        $per = $this->permissionModel::findOrFail($id);

        $data = [
            'display_name' => $request->display_name,
        ];
        $per->update($data);

        return response('updated', 200);
    }

    public function destroy ($id)
    {
        $permission = $this->permissionModel::findOrFail($id);

        $collection = DB::table('role_permission')->where('permission_id', $id);

        foreach ($collection as $key => $value) {
            unset($value);
        }

        $permission->delete();
        return response('permission deleted', 200);
    }
}

