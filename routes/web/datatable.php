<?php
/*
|--------------------------------------------------------------------------
| Datatable Routes
|--------------------------------------------------------------------------
| 此路由文件由布尔懒人工具包自动生成，包含DataTable生成器相关路由
| 注意：请不要在此文件手写路由
*/
Route::any('/lazykit/datatable/index',        'Lazykit\DatatableController@index');         //菜单管理
Route::any('/lazykit/demo',                   'Lazykit\DemoController@index');              //Datatable完整演示
Route::any('/lazykit/module/index',           'Lazykit\ModuleController@index');            //模块管理
Route::any('/lazykit/demo/external',          'Lazykit\DemoController@external');           //Datatable自定义字段
Route::any('/lazykit/demo/treetable',         'Lazykit\DemoController@treetable');          //Datatable树形表格
Route::any('/ucenter/user/index',             'System\UserController@index');               //系统用户管理
Route::any('/system/auth/userGroup',          'System\AuthController@userGroup');           //用户组管理
