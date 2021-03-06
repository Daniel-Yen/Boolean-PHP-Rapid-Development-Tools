<?php		
/*
|--------------------------------------------------------------------------
| Datatable Routes
|--------------------------------------------------------------------------
| 此路由文件由布尔快速开发工具自动生成，包含DataTable生成器相关路由
| 生成日期：2019-06-12 07:44:58
| 注    意：请不要在此文件手写路由
*/

Route::group(['middleware' => ['auth','permission']], function(){
	Route::any('/lazykit/function_page/design',   'Lazykit\FunctionPageController@design');    //页面设计
	Route::any('/lazykit/demo/index',             'Lazykit\DemoController@index');             //Datatable完整演示
	Route::any('/lazykit/module/index',           'Lazykit\ModuleController@index');           //模块管理
	Route::any('/lazykit/demo/external',          'Lazykit\DemoController@external');          //Datatable自定义字段
	Route::any('/lazykit/demo/treetable',         'Lazykit\DemoController@treetable');         //Datatable树形表格
	Route::any('/lazykit/environment/server',     'Lazykit\EnvironmentController@server');     //系统信息
	Route::any('/lazykit/system/index',           'Lazykit\SystemController@index');           //系统管理
	Route::any('/lazykit/function_page/index',    'Lazykit\FunctionPageController@index');     //开发设计
	Route::any('/lazykit/function_page/preview',  'Lazykit\FunctionPageController@preview');   //预览配置文件
	Route::any('/lazykit/chart/index',            'Lazykit\ChartController@index');            //统计图表演示
	Route::any('/lazykit/function_page/chart_attribute_set','Lazykit\FunctionPageController@chartAttributeSet');  //统计图表附加属性设置
	Route::any('/lazykit/config/index',           'Lazykit\ConfigController@index');           //多个配置文件
	Route::any('/lazykit/config/input_type',      'Lazykit\ConfigController@inputType');       //多种输入方式配置
	Route::any('/lazykit/function_page/config_attribute_set','Lazykit\FunctionPageController@configAttributeSet');  //配置文件附加属性设置
	Route::any('/lazykit/function_page/attribute_set','Lazykit\FunctionPageController@attributeSet');  //数据表格附加属性设置
	Route::any('/lazykit/system/middleware_management','Lazykit\SystemController@middlewareManagement');  //中间件管理
	Route::any('/user/user/index',                'User\UserController@index');                //系统用户管理
	Route::any('/user/user_group/index',          'User\UserGroupController@index');           //用户组管理
});

Route::group(['middleware' => ['auth']], function(){
	Route::any('/user/user/update_user',          'User\UserController@updateUser');           //个人资料
	Route::any('/user/user/update_user_password', 'User\UserController@updateUserPassword');   //修改密码
});

