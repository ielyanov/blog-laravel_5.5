<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/category/{slug?}', 'BlogController@category')->name('category');
Route::get('/article/{slug?}', 'BlogController@article')->name('article');

Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>['auth']], function(){
  Route::get('/', 'DashboardController@dashboard')->name('admin.index');
  Route::resource('/category', 'CategoryController', ['as'=>'admin']);
  Route::resource('/article', 'ArticleController', ['as'=>'admin']);
  Route::group(['prefix' => 'user_managment', 'namespace' => 'UserManagment'], function() {
  	Route::resource('/user', 'UserController', ['as' => 'admin.user_managment']);
  });
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');