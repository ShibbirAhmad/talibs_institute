<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category ;
use Illuminate\Support\Facades\Storage ;
use Image;



class CategoryController extends Controller
{
   
    public function get_category_list(){

           $categories = Category::orderBy('id','desc')->paginate(10);
           return response()->json([
                  "status" => "OK",
                  "categories" => $categories ,
           ]);
    }

    

     public function get_edit_category_item($id){

           $category = Category::findOrFail($id);
           return response()->json([
                  "category" => $category ,
           ]);
    }

   
    // function for store category 
    public function add_category(Request $request){

         $validateData=$this->validate($request,[
               'name' => 'required|unique:categories',
               'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
          ]);

              $category = new Category();
              $category->name=$request->name;
          if ($request->hasFile('image')) {
              $inerted_image = $request->file('image');
              $imageName = time().'-'.$inerted_image->getClientOriginalName();
              $image = Image::make($inerted_image);
              $image = $image->resize(150,150);
              $image->save(public_path('storage/images/category/'.$imageName));
              $category->image='images/category/'.$imageName ;
          }

          if ($category->save()) {
              return response()->json([
                  'status' => 'OK',
                  'message' => 'New category added',
              ]);
          }

    }



    // function for store category 
    public function edit_category(Request $request,$id){

         $validateData=$this->validate($request,[
               'name' => 'required|unique:categories,name,'.$id,
               'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
          ]);

              $category = Category::findOrFail($id);
              $category->name=$request->name;
          if ($request->hasFile('image')) {

              if (file_exists($category->image)) {
                  unlink("storage/".$category->image);
              }
              
              $inerted_image = $request->file('image');
              $imageName = time().'-'.$inerted_image->getClientOriginalName();
              $image = Image::make($inerted_image);
              $image = $image->resize(150,150);
              $image->save(public_path('storage/images/category/'.$imageName));
              $category->image='images/category/'.$imageName ;
          }

          if ($category->save()) {
              return response()->json([
                  'status' => 'OK',
                  'message' => 'this category updated',
              ]);
          }

    }



    
     public function deActive_category($id){

           $category = Category::findOrFail($id);
           $category->status=0 ;
           if ($category->save()) {
                return response()->json([
                  "status" => "OK",
                  "message" => "this category deactivated" ,
           ]);
           }
    }


        
     public function active_category($id){

           $category = Category::findOrFail($id);
           $category->status=1 ;
           if ($category->save()) {
                return response()->json([
                  "status" => "OK",
                  "message" => "this category activated" ,
           ]);
           }
    }



     public function delete_category($id){

           $category = Category::findOrFail($id);
           if ($category->delete()) {
                return response()->json([
                  "status" => "OK",
                  "message" => "this category destroyed" ,
           ]);
           }
    }



     





}
