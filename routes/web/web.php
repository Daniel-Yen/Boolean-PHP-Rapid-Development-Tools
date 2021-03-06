<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| 默认路由文件
*/

//用户认证相关路由
Auth::routes();

//只需要用户登录认证的页面
Route::group(['middleware' => ['auth']], function(){
	Route::get('/', 										'IndexController@index');    					//首页
	Route::get('/welcome',									'IndexController@welcome');						//欢迎页
	Route::get('/no_permission',							'IndexController@noPermission');				//没有权限提示页
	Route::post('/clear', 									'BooleanTools\CacheController@clear');    					//首页
	//Route::any('/lazykit/functionpage/add_model',			'lazykit\FunctionPageController@addModel');				//数据表格模型设置
	//Route::any('/lazykit/functionpage/set',					'lazykit\FunctionPageController@set');					//数据表格配置生成
	//Route::any('/lazykit/functionpage/attribute_set',		'lazykit\FunctionPageController@attributeSet');			//字段属性设置
	//Route::any('/lazykit/functionpage/chart_attribute_set',	'lazykit\FunctionPageController@ChartAttributeSet');			//字段属性设置
	//Route::any('/lazykit/functionpage/config_attribute_set','lazykit\FunctionPageController@configAttributeSet');			//配置文件字段附加属性设置
});