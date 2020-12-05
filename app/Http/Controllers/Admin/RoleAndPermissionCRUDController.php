<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role ;
use App\Models\Permission ;

class RoleAndPermissionCRUDController extends Controller
{
      public function get_role_list(Request $request)

    {

        $roles = Role::orderBy('id','DESC')->paginate(5);

        return response()->json([
            "status" => "OK",
            "roles"  => $roles ,
        ]);

    }

     public function add_role(Request $request) {

        $role = new Role() ;
        $role->name=$request->name ;
        $role->guard_name=$request->guard_name ;
        $role->save();
        return response()->json([
            "status" => "OK",
            "message"  => "role added successfully " ,
        ]);

    }

     public function get_edit_role($id){

        $role = Role::findOrFail($id) ;

        return response()->json([
            "status" => "OK",
            "role"  => $role ,
        ]);

    }




     public function edit_role(Request $request,$id) {

        $role = Role::findOrFail($id) ;
        $role->name=$request->name ;
        $role->guard_name=$request->guard_name ;
        $role->save();

        return response()->json([
            "status" => "OK",
            "message"  => "role updated successfully " ,
        ]);

    }

 

  
    public function get_permission_list(Request $request)

    {

        $permissions = Permission::orderBy('id','DESC')->paginate(5);

        return response()->json([
            "status" => "OK",
            "permissions"  => $permissions ,
        ]);

    }

    


     public function add_permission(Request $request) {

        $permission = new Permission() ;
        $permission->name=$request->name ;
        $permission->guard_name=$request->guard_name ;
        $permission->save();
        return response()->json([
            "status" => "OK",
            "message"  => "Permission added successfully " ,
        ]);

    }

     public function get_edit_permission($id){

        $permission = Permission::findOrFail($id) ;

        return response()->json([
            "status" => "OK",
            "permission"  => $permission ,
        ]);

    }




     public function edit_permission(Request $request,$id) {

        $permission = Permission::findOrFail($id) ;
        $permission->name=$request->name ;
        $permission->guard_name=$request->guard_name ;
        $permission->save();

        return response()->json([
            "status" => "OK",
            "message"  => "Permission updated successfully " ,
        ]);

    }



}
