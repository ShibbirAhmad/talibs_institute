<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage ;
use Image;

class AdminController extends Controller
{
      
      public function login(Request $request){

            $validatedData = $request->validate([
            'email' => 'required ',
            'password' => 'required',
        ]);


        $credential = ['email' => $request->email, 'password' => $request->password, 'status' => 1];

        if (Auth::guard('admin')->attempt($credential)) {
            Session::put('admin', Auth::guard('admin')->user());
            return response()->json([
                'status' => 'SUCCESS',
                'admin' => Auth::guard('admin')->user(),
                'token' => Hash::make($request->password),
                'message' => 'Login successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'FAILD',
                'message' => 'sorry ! invalid login information '
            ]);
        }

      }




       public function logout()
    {

        Auth::guard('admin')->logout();
        session()->forget('admin');
        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Logout successfully'
        ]);
    }


     public function sessionCheck()
    {


        if (!Session::has('admin')) {
            return response()->json([
                'status' => 'EXPIRED',
                'message' => 'Your session has expired'
            ]);
        } else {
            return response()->json([
                'status' => 'RUNNING',
                'message' => 'your session is running',
                'admin'=>session()->get('admin'),
            ]);
        }
    }

      

       public function current_admin(){
            $current_admin= session()->get('admin');
           return response()->json([
               "admin" => $current_admin ,
           ]);
       }

       public function get_admins() {
        $admins = Admin::orderby('id', 'desc')->paginate(10);
        return response()->json([
            'admins' => $admins,
            'status' => 'SUCCESS'
        ]);
       }

     

       public function storeNewAdmin(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required ',
            'password' => 'required',
            'name' => 'required',
            'phone' => 'required|digits:11',


        ]);
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->password = Hash::make($request->password);
        $admin->status= 1 ;
        if ($request->hasFile('image')) {
            $inputed_image = $request->file('image');
            $imageName = time().'-'.$inputed_image->getClientOriginalName();
            $image = Image::make($inputed_image);
            $image = $image->resize(150,150);
            $image->save(public_path('storage/images/admin/'.$imageName));
            $admin->image='images/admin/'.$imageName ;
        }


        if ($admin->save()) {

            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'admin add successfully'
            ]);
        }

    }


     public function get_edit_admin($id)
    {
        $admin = Admin::find($id);
        if ($admin) {
            return response()->json([
                'status' => 'SUCCESS',
                'admin' => $admin
            ]);
        }


    }

        public function edit_admin(Request $request, $id){

        $validatedData = $request->validate([
            'email' => 'required|unique:admins,email,'.$id,
            'phone' => 'required|unique:admins,phone,'.$id,
            'name' => 'required',
        ]);

     //   return $request->all();

        $admin =Admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        if ($request->hasFile('image')) {
 
            $inputed_image = $request->file('image');
            $imageName = time().'-'.$inputed_image->getClientOriginalName();
            $image = Image::make($inputed_image);
            $image = $image->resize(150,150);
            $image->save(public_path('storage/images/admin/'.$imageName));
            $admin->image='images/admin/'.$imageName ;
        } 
        if ($admin->save()) {

            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'admin update successfully'
            ]);
        }
    }



    public function update_self_Profile(Request $request){
         $id= session()->get('admin')['id'] ;
      //   return "$id" ;
        $validatedData = $request->validate([
            'email' => 'required|unique:admins,email,'.$id,
            'phone' => 'required|unique:admins,phone,'.$id,
            'name' => 'required',
           ]);

          $admin = session()->get('admin');
          $admin->name=$request->name ;
          $admin->email=$request->email ;
          $admin->phone=$request->phone ;

        if ($request->hasFile('image')) {
            $inputed_image = $request->file('image');
            $imageName = time().'-'.$inputed_image->getClientOriginalName();
            $image = Image::make($inputed_image);
            $image = $image->resize(150,150);
            $image->save(public_path('storage/images/admin/'.$imageName));
            $admin->image='images/admin/'.$imageName ;
        }
        
        if ($admin->save()) {
            return response()->json([
                "status" => "OK",
                "message" => "your profile information updated"
            ]);
        }
    }



    public function updatePassword(Request $request){

        $validatedData = $request->validate([
            'old_password' => 'required ',
            'new_password' => 'required',

        ]);

        $admin= session()->get('admin');
        $admin_current_password=$admin->password;

        if (Hash::check($request->old_password,$admin_current_password)) {
            if($request->new_password==$request->old_password){
                return response()->json([
                    "message" => "current password and new password can't be same ",
                ]);
            }else{
                $admin->password=Hash::make($request->new_password);  
                    if ($admin->save()) {
                        return response()->json([ "success" => "OK", "message" => "password changed successfully" ]);
                    }  
            }
         }else{
             return response()->json([
                "message" => "current password is incorrect! ",
              ]);
         } 
        

           
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }

    public
    function deactive($id)
    {
        $admin = Admin::find($id);
        if ($admin) {
            $admin->status = 0;
            if ($admin->save()) {
                return response()->json([
                    'status' => 'SUCCESS',
                    'message' => 'admin deactive successfully'
                ]);
            }
        }
    }


    function active($id)
    {
        $admin = Admin::find($id);
        if ($admin) {
            $admin->status = 1;
            if ($admin->save()) {
                return response()->json([
                    'status' => 'SUCCESS',
                    'message' => 'admin active successfully'
                ]);
            }
        }
    }





       

}
