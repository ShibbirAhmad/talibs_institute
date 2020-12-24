<?php
 
 use Illuminate\Support\Facades\Route;
 
 Route::group([ 'namespace' => 'Frontend'],function(){

  
   Route::get('api/display/course/public','HomeController@get_course_list');
   Route::get('api/blog/post/public','HomeController@get_blog_post_list');
   Route::get('api/get/categories/to/display/frontend','HomeController@get_category_list');
   Route::get('api/get/landing/sliders/public','HomeController@get_landing_sliders');
   Route::get('api/get/category/sliders/public','HomeController@get_category_sliders');
   




 });

