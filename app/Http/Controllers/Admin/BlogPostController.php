<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Storage ;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class BlogPostController extends Controller
{
     

      
     public function get_blog_post_list(){

           $posts = BlogPost::orderBy('id','desc')->with('admin_name')->paginate(10);
           return response()->json([
                  "status" => "OK",
                  "posts" => $posts ,
           ]);
    }

    

     public function get_edit_blog_post_item($id){

           $post = BlogPost::findOrFail($id);
           return response()->json([
                  "status" => "OK",
                  "post" => $post ,
           ]);
    }

    

    
      // function for store post 
      public function add_blog_post(Request $request){

         $validateData=$this->validate($request,[
               'title' => 'required|unique:blog_posts',
               'category_id'=> 'required',
               'description'=> 'required',
               'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
          ]);
           

            $post = new BlogPost();
            $post->title=$request->title;
              
            //this slug with encoding for any language 
            function CleanURL($string, $delimiter = '-') {
            // Remove special characters
            $string = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $string);
            // Replace blank space with delimeter
            $string = preg_replace("/[\/_|+ -]+/", $delimiter, $string);
              return $string;
             }
              $slug=CleanURL($request->title);
              $max_id=BlogPost::max('id')+1 ;
              $post->slug=$slug."-".$max_id;
              $post->admin_id=session()->get('admin')['id'];
              $post->category_id=$request->category_id;
              $post->description=$request->description;
              $post->status=1;

          if ($request->hasFile('image')) {
              $inerted_image = $request->file('image');
              $imageName = time().'-'.$inerted_image->getClientOriginalName();
              $image = Image::make($inerted_image);
              $image = $image->resize(370,250);
              $image->save(public_path('storage/images/blog_post/'.$imageName));
              $post->image='images/blog_post/'.$imageName ;
          }

          if ($post->save()) {
              return response()->json([
                  'status' => 'OK',
                  'message' => 'New post added successfully',
              ]);
          }

    }




      // function for store post 
      public function update_blog_post(Request $request,$id){

         $validateData=$this->validate($request,[
               'title' => 'required|unique:blog_posts,title,'.$id,
               'category_id'=> 'required',
               'description'=> 'required',
               'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
          ]);

             $post = BlogPost::findOrFail($id);
             $post->title=$request->title;
             $post->admin_id=session()->get('admin')['id'];
             $post->category_id=$request->category_id;
             $post->description=$request->description;
             $post->status=1;

          if ($request->hasFile('image')) {
                if (file_exists($post->image)) {
                   unlink("storage/".$post->image);
              }
              $inerted_image = $request->file('image');
              $imageName = time().'-'.$inerted_image->getClientOriginalName();
              $image = Image::make($inerted_image);
              $image = $image->resize(370,250);
              $image->save(public_path('storage/images/blog_post/'.$imageName));
              $post->image='images/blog_post/'.$imageName ;
          }

          if ($post->save()) {
              return response()->json([
                  'status' => 'OK',
                  'message' => 'Post edited successfully',
              ]);
           }

        }



    
    
     public function deActive_blog_post($id){

           $post = BlogPost::findOrFail($id);
           $post->status=0 ;
           if ($post->save()) {
                return response()->json([
                  "status" => "OK",
                  "message" => "this post deactivated" ,
           ]);
           }
    }


        
     public function active_blog_post($id){

           $post = BlogPost::findOrFail($id);
           $post->status=1 ;
           if ($post->save()) {
                return response()->json([
                  "status" => "OK",
                  "message" => "this post activated" ,
           ]);
           }
    }



     public function delete_blog_post($id){

           $post = BlogPost::findOrFail($id);
           if ($post->delete()) {
                return response()->json([
                  "status" => "OK",
                  "message" => "this post destroyed" ,
           ]);
           }
    }











}
