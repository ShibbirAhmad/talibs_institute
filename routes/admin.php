<?php

use Illuminate\Support\Facades\Route;

Route::post('api/backend/category/admin/login','Admin\AdminController@login');
  Route::get('api/check/session/admin','Admin\AdminController@sessionCheck');
 Route::group([
      'namespace' => 'Admin',
      'middleware' => 'admin'
            ],function(){
      // admin route is here      
      Route::get('api/logout/admin','AdminController@logout');
      Route::get('api/single/admin', 'AdminController@current_admin');
      Route::get('api/list/admin', 'AdminController@get_admins');
      Route::post('api/add/admin', 'AdminController@storeNewAdmin');
      Route::get('api/deactive/admin/{id}', 'AdminController@deactive');
      Route::get('api/active/admin/{id}', 'AdminController@active');
      Route::get('api/get/edit/admin/{id}', 'AdminController@get_edit_admin');
      Route::post('api/update/admin/{id}', 'AdminController@edit_admin');
      Route::post('api/current/admin/password/update', 'AdminController@updatePassword');
      Route::post('api/update/profile/admin', 'AdminController@update_self_Profile');
      // admin route is finshed here

      //category route is here
      Route::get('api/get/category/list','CategoryController@get_category_list');
      Route::post('api/add/category','CategoryController@add_category');
      Route::get('api/get/edit/category/item/{id}','CategoryController@get_edit_category_item');
      Route::post('api/edit/category/{id}','CategoryController@edit_category');
      Route::get('api/de-active/category/{id}','CategoryController@deActive_category');
      Route::get('api/active/category/{id}','CategoryController@active_category');
      Route::get('api/delete/category/{id}','CategoryController@delete_category');


      //role route is here
      Route::get('api/get/role/list','RoleAndPermissionCRUDController@get_role_list');
      Route::post('api/add/role','RoleAndPermissionCRUDController@add_role');
      Route::get('api/get/edit/role/item/{id}','RoleAndPermissionCRUDController@get_edit_role');
      Route::post('api/edit/role/{id}','RoleAndPermissionCRUDController@edit_role');


      //role route is here
      Route::get('api/get/permission/list','RoleAndPermissionCRUDController@get_permission_list');
      Route::get('api/get/role/assign/for/model/{id}','RoleController@get_role_of_model');
      Route::post('api/update/assign/role/to/model/{id}','RoleController@modelAssignRoles');
      Route::get('api/get/permissions/assign/for/model/{id}','RoleController@get_permissions_of_model');
      Route::post('api/update/assign/permission/to/model/{id}','RoleController@modelAssignPermissions');
      Route::post('api/add/permission','RoleAndPermissionCRUDController@add_permission');
      Route::get('api/get/edit/permission/item/{id}','RoleAndPermissionCRUDController@get_edit_permission');
      Route::post('api/edit/permission/{id}','RoleAndPermissionCRUDController@edit_permission');

     
 });