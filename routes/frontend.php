<?php
 
 use Illuminate\Support\Facades\Route;
 
 Route::group([ 'namespace' => 'Frontend'],function(){

  
   Route::get('api/display/course/public','HomeController@get_course_list');
   Route::get('api/blog/post/public','HomeController@get_blog_post_list');
   




 });

