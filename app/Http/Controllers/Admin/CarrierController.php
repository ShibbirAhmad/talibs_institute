<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\JobApply ;

class CarrierController extends Controller
{
    

    public  function index(Request $request){
        
        $item = $request->item ?? 10 ;
        $carriers= Carrier::orderBy('id','DESC')->with('applied_user')->paginate($item);

        return response()->json([
            "success" => "OK",
            "carriers" => $carriers ,
        ]);
    }



        

    public  function job_applied($id){
        
        $appliers= JobApply::where('job_id',$id)->orderBy('id','DESC')->with('job')->paginate(10);

        return response()->json([
            "status" => "OK",
            "appliers" => $appliers ,
        ]);
    }


    public function download_applied_user_resume($id){

           $applier = JobApply::findOrFail($id);
           $resume=$applier->file ;
           return response()->download(public_path('storage/'.$resume));
      
    }

    
    public function add_carrier(Request $request){
           
        $validatedData = $request->validate([
            'title'  => 'required',
            'vacency'  => 'required',
            'description'  => 'required',
            'deadline'  => 'required',
        ]);

         $carrier= new Carrier ();
         $carrier->title=$request->title ;
         $carrier->description=$request->description ;
         $carrier->vacency=$request->vacency ;
         $carrier->deadline=$request->deadline ;
         $carrier->status=1;
         if ($request->hasFile('image')) {
             $file_path=$request->file('image')->store('images/carrier','public');
              $carrier->image=$file_path ;
         }
        
         if ($carrier->save()) {
             return response()->json([
                 'success' => 'OK',
                  'message' => 'New job post added successfully '
             ]);
         }




    }

   
   public function getEdit_carrier($id){

    $carrier  = Carrier::find($id);  
     if ($carrier) {       
        return response()->json([
                "success"  => "OK",
                "carrier"  => $carrier,  ]);
    }else {
        return  response()->json([
                        "success" => "Fail",
                        "message" => "something wrong "  ]);
        }

}




    public function update_carrier(Request $request, $id){
           
        $validatedData = $request->validate([
            'title'  => 'required',
            'vacency'  => 'required',
            'description'  => 'required',
            'deadline'  => 'required',
        ]);


         $carrier= Carrier::find($id);
         $carrier->title=$request->title ;
         $carrier->description=$request->description ;
         $carrier->vacency=$request->vacency ;
         $carrier->deadline=$request->deadline ;
         $carrier->status=1;
         if ($request->hasFile('image')) {

             if($carrier->image){
                unlink('storage/'.$carrier->image);
             }
             
             $file_path=$request->file('image')->store('images/carrier','public');
             $carrier->image=$file_path ;

         }
        
         if ($carrier->save()) {
             return response()->json([
                 'success' => 'OK',
                  'message' => 'New job post added successfully '
             ]);
         }




    }



     
    public function deactive_carrier($id){

        $carrier  = Carrier::find($id);
        $carrier->status=0 ;
        if ($carrier->save()) {       
           return response()->json([
                   "success"  => "OK",
                   "message"  => "This carrier de-activated",  ]);
       }else {
           return  response()->json([
                           "success" => "Fail",
                           "message" => "something wrong "  ]);
           }
     } 




     public function active_carrier($id){

        $carrier  = Carrier::find($id);
        $carrier->status=1 ;
        if ($carrier->save()) {       
           return response()->json([
                   "success"  => "OK",
                   "message"  => "This carrier activated",  ]);
       }else {
           return  response()->json([
                           "success" => "Fail",
                           "message" => "something wrong "  ]);
           }
     }


     

    
    public function destroy_carrier($id){

        $carrier  = Carrier::find($id);
         if ($carrier->delete()) {       
            return response()->json([
                    "success"  => "OK",
                    "message"  => "This carrier has removed",  ]);
        }else {
            return  response()->json([
                            "success" => "Fail",
                            "message" => "something wrong "  ]);
            }

    }









}
