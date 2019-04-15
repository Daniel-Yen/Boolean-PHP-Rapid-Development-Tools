<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| 布尔懒人工具包DataTable数据表格生成器相关路由
*/
Route::group(['middleware' => ['auth', 'permission']], function(){
	Route::any('/lazykit/datatable/add_model','lazykit\DatatableController@addModel');			//数据表格模型设置
	Route::any('/lazykit/datatable/set','lazykit\DatatableController@set');						//数据表格配置生成
	Route::any('/lazykit/datatable/attribute_set','lazykit\DatatableController@attributeSet');
});