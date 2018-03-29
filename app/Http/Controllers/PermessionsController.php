<?php

namespace App\Http\Controllers;
use App\Permission;
use App\Http\Requests\PermissionRequest;
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
    public function DeletePermission($id){
        $permission = Permission::find($id);
        $permission->Delete();
        return response()->json("deleted");
    }
}
