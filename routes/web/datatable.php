<?php
/*
|--------------------------------------------------------------------------
| Datatable Routes
|--------------------------------------------------------------------------
| 此路由文件由布尔懒人工具包自动生成，包含DataTable生成器相关路由
| 生成日期：2019-04-15 07:18:32
| 注    意：请不要在此文件手写路由
*/
Route::group(['middleware' => ['auth', 'permission']], function(){
	Route::any('/lazykit/datatable/index',        'Lazykit\DatatableController@index');         //菜单管理
	Route::any('/lazykit/demo/index',             'Lazykit\DemoController@index');              //Datatable完整演示
	Route::any('/lazykit/module/index',           'Lazykit\ModuleController@index');            //模块管理
	Route::any('/lazykit/demo/external',          'Lazykit\DemoController@external');           //Datatable自定义字段
	Route::any('/lazykit/demo/treetable',         'Lazykit\DemoController@treetable');          //Datatable树形表格
	Route::any('/system/environment/server',      'System\EnvironmentController@server');       //系统信息
	Route::any('/system/user/index',              'System\UserController@index');               //系统用户管理
	Route::any('/system/auth/user_group',         'System\AuthController@userGroup');           //用户组管理
});