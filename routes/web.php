<?php

use Illuminate\Support\Facades\Route;


// dd(app());
Route::get('/', function () {
    return view('frontend.pages.about');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// axios
Route::post('/user/permission','UserController@apirequest');
Route::post('/posts/status','PostController@statusPost');


Route::get('/admin','AdminController@index');


Route::resource('users','UserController')->middleware('role:admin,manager');
Route::resource('roles','RoleController')->middleware('can:isAdmin');
Route::resource('posts', 'PostController');

