<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course ;
use App\Models\BlogPost ;
use App\Models\Category;
use App\Models\Slider;
use App\Models\CategorySlider;

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


        public function get_category_list(){

                $categories = Category::where('status',1)->get();
                return response()->json([
                    "status" => "OK",
                    "categories" => $categories
                ]);
          }



       public function get_landing_sliders(){

                $landing_sliders = Slider::where('status',1)->get();
                return response()->json([
                    "status" => "OK",
                    "landing_sliders" => $landing_sliders
                ]);
        }



        public function get_category_sliders(){

                $category_sliders = CategorySlider::where('page_position',1)->where('status',1)->get();
                return response()->json([
                    "status" => "OK",
                    "category_sliders" => $category_sliders,
                ]);

           }

      



}
