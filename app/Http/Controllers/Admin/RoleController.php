<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\Admin ;


class RoleController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return IlluminateHttpResponse

     */

    // function __construct()

    // {

    //      $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);

    //      $this->middleware('permission:role-create', ['only' => ['create','store']]);

    //      $this->middleware('permission:role-edit', ['only' => ['edit','update']]);

    //      $this->middleware('permission:role-delete', ['only' => ['destroy']]);

    // }


   

    public function  get_role_of_model($id)

        {
            $admin=Admin::findOrFail($id);
            $model_has_roles_id=DB::table('model_has_roles')->where('model_id',$id)->select('role_id')->pluck('role_id') ;
            $roles = Role::orderBy('id','DESC')->get();

            return response()->json([
                "status" => "OK",
                "roles"  => $roles ,
                "admin_name" => $admin->name ,
                'model_has_roles_id' => $model_has_roles_id ,
            ]);

        }



    

    public function modelAssignRoles(Request $request, $id){
          
          $admin = Admin::find($id);
          //erase old data of permission 
          DB::table('model_has_roles')->where('model_id',$id)->delete();
         //assign permission 
         foreach ($request->role_id as $role_id) {
               $role=Role::find($role_id ); // capture role object by find. Note:- only role id will not work here . there are object passing not id passing .
              $admin->assignRole($role);
         }

         return  response()->json([
             "status" => "OK",
             "message" => "Role assigned successfully..",
         ]);

    }



     public function get_permissions_of_model($id)

    {
        $admin=Admin::findOrFail($id);
        $model_has_permissions_id=DB::table('model_has_permissions')->where('model_id',$id)->select('permission_id')->pluck('permission_id') ;
        $permissions = Permission::orderBy('id','DESC')->get();

        return response()->json([
            "status" => "OK",
            "permissions"  => $permissions ,
            "admin_name" => $admin->name ,
            'model_has_permissions_id' => $model_has_permissions_id ,
        ]);

    }





    public function modelAssignPermissions(Request $request, $id){
          
          $admin = Admin::find($id);
          //erase old data of permission 
          DB::table('model_has_permissions')->where('model_id',$id)->delete();
         //assign permission 
         foreach ($request->permission_id as $permission_id) {
               $permission=Permission::find($permission_id ); // capture permission object by find. Note:- only permission id will not work here . there are object passing not id passing .
              $admin->givePermissionTo($permission);
         }

         return  response()->json([
             "status" => "OK",
             "message" => "Permission assigned successfully..",
         ]);

    }



    public function create()

    {

        $permission = Permission::get();

        return view('roles.create',compact('permission'));

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  IlluminateHttpRequest  $request

     * @return IlluminateHttpResponse

     */

   

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return IlluminateHttpResponse

     */

    public function show($id)

    {

        $role = Role::find($id);

        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")

            ->where("role_has_permissions.role_id",$id)

            ->get();

        return view('roles.show',compact('role','rolePermissions'));

    }




      public function roleAsignPermission(Request $request)
    {

        $this->validate($request, [

            'name' => 'required|unique:roles,name',
            'permission' => 'required',

        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')->with('success','Role created successfully');

    }



   
    


    

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return IlluminateHttpResponse

     */

    public function edit($id)

    {

        $role = Role::find($id);

        $permission = Permission::get();

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)

            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')

            ->all();

        return view('roles.edit',compact('role','permission','rolePermissions'));

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  IlluminateHttpRequest  $request

     * @param  int  $id

     * @return IlluminateHttpResponse

     */

    public function update(Request $request, $id)

    {

        $this->validate($request, [

            'name' => 'required',

            'permission' => 'required',

        ]);

        $role = Role::find($id);

        $role->name = $request->input('name');

        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')

                        ->with('success','Role updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return IlluminateHttpResponse

     */

    public function destroy($id)

    {

        DB::table("roles")->where('id',$id)->delete();

        return redirect()->route('roles.index')

                        ->with('success','Role deleted successfully');

    }


}
