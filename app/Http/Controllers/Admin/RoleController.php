<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SpatiePermissionModelsRole;
use SpatiePermissionModelsPermission;
use Illuminate\Support\Facades\DB;
use App\Models\Role ;
use App\Models\Permission ;


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

    /**

     * Display a listing of the resource.

     *

     * @return IlluminateHttpResponse

     */

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

     public function get_permissions()

    {

        $permissions = Permission::orderBy('id','DESC')->get();

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



    /**

     * Show the form for creating a new resource.

     *

     * @return IlluminateHttpResponse

     */

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

    public function roleAsignPermission(Request $request)

    {

        $this->validate($request, [

            'name' => 'required|unique:roles,name',

            'permission' => 'required',

        ]);

        $role = Role::create(['name' => $request->input('name')]);

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')

                        ->with('success','Role created successfully');

    }

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
