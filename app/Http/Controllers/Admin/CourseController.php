<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Storage ;
use Illuminate\Support\Str;
use Image;


class CourseController extends Controller
{
    //

     public function get_course_list(){

           $courses = Course::orderBy('id','desc')->with('category_name')->paginate(10);
           return response()->json([
                  "status" => "OK",
                  "courses" => $courses ,
           ]);
    }

    

     public function get_edit_course_item($id){

           $course = Course::findOrFail($id);
           return response()->json([
                  "status" => "OK",
                  "course" => $course ,
           ]);
    }

    

      // function for store course 
    public function add_course(Request $request){

         $validateData=$this->validate($request,[
               'name' => 'required|unique:courses',
               'category_id'=> 'required',
               'duration'=> 'required',
               'fee'=> 'required',
               'start_date'=> 'required',
               'description'=> 'required',
               'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
          ]);

              $course = new Course();
              $course->name=$request->name;
              //this slug with encoding for any language 
              function CleanURL($string, $delimiter = '-') {
             // Remove special characters
              $string = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $string);
             // Replace blank space with delimeter
              $string = preg_replace("/[\/_|+ -]+/", $delimiter, $string);
              return $string;
             }
              $slug=CleanURL($request->name);
              $max_id=Course::max('id')+1 ;
              $course->slug=$slug."-".$max_id;
              $course->category_id=$request->category_id;
              $course->duration=$request->duration;
              $course->start_date=$request->start_date;
              $course->fee=$request->fee;
              $course->offer=$request->offer;
              $course->description=$request->description;
              $course->status=1;

          if ($request->hasFile('image')) {
              $inerted_image = $request->file('image');
              $imageName = time().'-'.$inerted_image->getClientOriginalName();
              $image = Image::make($inerted_image);
              $image = $image->resize(370,250);
              $image->save(public_path('storage/images/course/'.$imageName));
              $course->image='images/course/'.$imageName ;
          }

          if ($course->save()) {
              return response()->json([
                  'status' => 'OK',
                  'message' => 'New course added successfully',
              ]);
          }

    }




    
      // function for store course 
    public function update_course(Request $request,$id){

         $validateData=$this->validate($request,[
               'name' => 'required|unique:courses,name,'.$id,
               'category_id'=> 'required',
               'duration'=> 'required',
               'start_date'=> 'required',
               'fee'=> 'required',
               'description'=> 'required',
               'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
          ]);

              $course = Course::findOrFail($id);
              $course->name=$request->name;
              $course->category_id=$request->category_id;
              $course->duration=$request->duration;
              $course->start_date=$request->start_date;
              $course->offer=$request->fee;
              $course->fee=$request->offer;
              $course->description=$request->description;
              $course->status=1;

          if ($request->hasFile('image')) {
              if ($course->image) {
                   unlink("storage/".$course->image);
              }
              $inerted_image = $request->file('image');
              $imageName = time().'-'.$inerted_image->getClientOriginalName();
              $image = Image::make($inerted_image);
              $image = $image->resize(370,250);
              $image->save(public_path('storage/images/course/'.$imageName));
              $course->image='images/course/'.$imageName ;
          }

          if ($course->save()) {
              return response()->json([
                  'status' => 'OK',
                  'message' => 'Course updated successfully',
              ]);
          }

    }



    
    
     public function deActive_course($id){

           $course = Course::findOrFail($id);
           $course->status=0 ;
           if ($course->save()) {
                return response()->json([
                  "status" => "OK",
                  "message" => "this course deactivated" ,
           ]);
           }
    }


        
     public function active_course($id){

           $course = Course::findOrFail($id);
           $course->status=1 ;
           if ($course->save()) {
                return response()->json([
                  "status" => "OK",
                  "message" => "this course activated" ,
           ]);
           }
    }



     public function delete_course($id){

           $course = Course::findOrFail($id);
           if ($course->delete()) {
                return response()->json([
                  "status" => "OK",
                  "message" => "this course destroyed" ,
           ]);
           }
    }











}
