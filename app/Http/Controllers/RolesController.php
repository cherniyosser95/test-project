<?php

namespace App\Http\Controllers;
use App\Role;
use App\Http\Requests\RoleRequest;
use App\User;
class RolesController extends Controller
{
    // create role for user
    public function createRole(RoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->input('name');
        // test sur le role name, doit etre si admin ou bien user pour ne pas risqué d'entrer un nom quelconque
        if(($role->name == "admin")|| ($role->name == "user")) {
            $role->save();
        }
        else{
            "try to create valid role";
        }
        return response()->json("created");
    }
    //edit Role
    public function EditRole(RoleRequest $request,$id)
    {
        $role =Role::find($id);
        $role->name = $request->input('name');
        // test sur le role name, doit etre si admin ou bien user pour ne pas risqué d'entrer un nom quelconque
        if(($role->name == "admin")|| ($role->name == "user")) {
            $role->update();
        }
        else{
            "try to update valid role";
        }
        return response()->json("updated");
    }
    public function DeleteRole($id)
    {
        $role =Role::find($id);
        $role->delete();
        return response()->json("deleted");
    }
    public function GetRoles()
    {
        $roles =Role::all();
        return response()->json(compact('roles'));
    }
        //Associer un role admin ou bien user a un utilisateur inscrit
    public function assignRole(Request $request){
        $user = User::where('email', '=', $request->input('email'))->first();
        $role = Role::where('name', '=', $request->input('role'))->first();
        //$user->attachRole($request->input('role'));
        $user->roles()->attach($role->id);

        return response()->json("created");
    }
}
