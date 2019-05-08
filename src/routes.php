<?php
Route::group(['middleware' => ['web']], function () {
    Route::get("blogs/{id?}", "Hosein\Blogs\Controllers\BlogsController@index");
    Route::get("blogs/{cat}/{id}", "Hosein\Blogs\Controllers\BlogsController@editCategory");
    Route::get("deletecategory/{id}", "Hosein\Blogs\Controllers\BlogsController@deletecategory");
    Route::post("categoryUpdate/{id}", "Hosein\Blogs\Controllers\BlogsController@categoryUpdate");
    Route::post("createCategory/{id}", "Hosein\Blogs\Controllers\BlogsController@createCategory");
    Route::post("createBlog", "Hosein\Blogs\Controllers\BlogsController@createBlog");
    Route::post("blogUpdate/{id}", "Hosein\Blogs\Controllers\BlogsController@blogUpdate");
    Route::get("editBlog/{id}", "Hosein\Blogs\Controllers\BlogsController@editBlog");
    Route::get("deleteblog/{id}", "Hosein\Blogs\Controllers\BlogsController@deleteblog");
});
