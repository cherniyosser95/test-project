<?php

namespace App\Http\Controllers;
use App\Role;
use App\Http\Requests\RoleRequest;
use App\User;
use Illuminate\Http\Request;
class RolesController extends Controller
{
    // create role for user
    public function createRole(RoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name=$request->input('display_name');
        // test sur le role name, doit etre si admin ou bien user pour ne pas risqué d'entrer un nom quelconque
        if(($role->name == "admin")|| ($role->name == "user") || ($role->name == "super-admin")) {
            $role->save();
        }
        else{
           echo "try to create valid role";
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
    public function GetRoleById($id){}
        //Associer un role admin ou bien user a un utilisateur inscrit
    public function assignRole(Request $request){
        $user = User::where('username', '=', $request->input('username'))->first();
        $role = Role::where('name', '=', $request->input('name'))->first();
        //$user->attachRole($request->input('role'));
        $user->roles()->attach($role->id);
        return response()->json("created");
    }
 /*   public function EditAttachedRole(Request $request,$id_user,$id_role){
        $user = User::find($id_user)->where('username', '=', $request->input('username'))->first();
        $role = Role::find($id_role)->where('name', '=', $request->input('name'))->first();
        //$user->attachRole($request->input('role'));
        $user->roles()->attach($role);
        return response()->json("updated");
    }*/
    //Destroy user with her roles
    public function Destroy($id)
    {
        $user=User::find($id);
        $user->roles()->detach();
        $user->delete();
        return response()->json("deleted");
    }
}
