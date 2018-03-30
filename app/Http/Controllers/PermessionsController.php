<?php

namespace App\Http\Controllers;
use App\Permission;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use App\Role;
class PermessionsController extends Controller
{
    //create new permission
    public function createPermission(PermissionRequest $request){
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->save();
        return response()->json("created");
    }
    //Update Permeission
    public function EditPermission(PermissionRequest $request,$id){
        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->update();
        return response()->json("updated");
    }
    //delete permission
    public function DeletePermission($id){
        $permission = Permission::find($id);
        $permission->delete();
        return response()->json("deleted");
    }
    //attach permission to role
    public function attachPermission(Request $request){
        $role = Role::where('name', '=', $request->input('name'))->first();
        dd($role);
        $permission = Permission::where('name', '=', $request->input('name'))->first();
        dd($permission);
        $role->attachPermission($permission);
        return response()->json("created");
    }
}
