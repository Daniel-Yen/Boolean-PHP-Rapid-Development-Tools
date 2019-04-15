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

Route::get('/', 'IndexController@index');    	//首页
Route::any('/welcome','IndexController@welcome');			//字段属性设置
Route::any('/no_permission','IndexController@noPermission');			//字段属性设置
Auth::routes();