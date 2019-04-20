<?php
/*
|--------------------------------------------------------------------------
| Datatable Routes
|--------------------------------------------------------------------------
| 此路由文件由布尔懒人工具包自动生成，包含DataTable生成器相关路由
| 生成日期：2019-04-20 12:08:21
| 注    意：请不要在此文件手写路由
*/

Route::group(['middleware' => ['auth', 'permission']], function(){
	Route::any('/lazykit/functionpage/design',    'Lazykit\FunctionPageController@design');    //页面设计
	Route::any('/lazykit/demo/index',             'Lazykit\DemoController@index');             //Datatable完整演示
	Route::any('/lazykit/module/index',           'Lazykit\ModuleController@index');           //模块管理
	Route::any('/lazykit/demo/external',          'Lazykit\DemoController@external');          //Datatable自定义字段
	Route::any('/lazykit/demo/treetable',         'Lazykit\DemoController@treetable');         //Datatable树形表格
	Route::any('/lazykit/environment/server',     'Lazykit\EnvironmentController@server');     //系统信息
	Route::any('/lazykit/system/index',           'Lazykit\SystemController@index');           //系统管理
	Route::any('/lazykit/functionpage/index',     'Lazykit\FunctionPageController@index');     //开发设计
	Route::any('/system/user/index',              'System\UserController@index');              //系统用户管理
	Route::any('/system/permission/user_group',   'System\PermissionController@userGroup');    //用户组管理
});