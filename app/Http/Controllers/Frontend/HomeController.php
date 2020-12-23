<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course ;
use App\Models\BlogPost ;

class HomeController extends Controller
{
     

       public function get_course_list(){

            $courses = Course::where('status',1)->latest()->take(4)->with('category_name')->get();
            return response()->json([
                "status" => "OK",
                "courses" => $courses
            ]);
       }




        public function get_blog_post_list(){

                    $blog_posts = BlogPost::where('status',1)->latest()->take(4)->with('category_name','admin_name')->get();
                    return response()->json([
                        "status" => "OK",
                        "blog_posts" => $blog_posts,
                    ]);
            }





       
}
