<?php
/**
 * 运行环境信息
 * @auther 		杨鸿<yh15229262120@qq.com>
 */
namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EnvironmentController extends Controller
{
    /**
	 * 系统信息
	 * @access    	public
	 */
	public function server(Request $request)
	{
		$additional_config = [
			'data_source_method' => 'data_source',		//控制器类的方法:获得表格数据
		];
		
		create_datatable('datatable_41', $additional_config, $request);
	}
	
	/**
	 * 系统信息数据源
	 * @access    	public
	 */
    public function data_source()
    {
       $sql_ver = DB::select('select version() as ver');
	   return $sys_info_arr = [
			['set' => '操作系统',		'key' => PHP_OS   ],
			['set' => 'Web Server',		'key' => $_SERVER['SERVER_SOFTWARE']   ],
			['set' => '数据库版本',		'key' => 'MySQL '.$sql_ver[0]->ver],
			['set' => 'IP地址',			'key' => GetHostByName($_SERVER['SERVER_NAME'])   ],
			['set' => 'Zlib',			'key' => function_exists('gzclose') ? 'YES' : 'NO'   ],
			['set' => '安全模式',		'key' => (boolean)ini_get('safe_mode') ? 'YES' : 'NO'   ],
			['set' => '时区',			'key' => function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone"   ],
			['set' => 'Curl',			'key' => function_exists('curl_init') ? 'YES' : 'NO'   ],
			['set' => 'php版本',		'key' => phpversion()   ],
			['set' => '文件最大上传',	'key' => @ini_get('file_uploads') ? ini_get('upload_max_filesize') : '未知'   ],
			['set' => '脚本最大执行时间','key' => @ini_get("max_execution_time") . '秒'   ],
			['set' => '设置时间限制',	'key' => function_exists("set_time_limit") ? 'YES' : 'NO'   ],
			['set' => '域名',			'key' => $_SERVER['HTTP_HOST']   ],
			['set' => 'GD库',			'key' => function_exists("gd_info")?gd_info()['GD Version']:'未知'   ],
			['set' => '内存分配',		'key' => ini_get('memory_limit')   ],
		];
    }
	
	/**
	 * 菜单管理
	 * @access    	public
	 */
	public function menu()
	{
		$additional_config = [
			'condition' => [
				['module', '=', request()->module()]
			],
			'create_param' => [
				'module' => request()->module()
			]
		];
		
		datagrid('datagrid_25',$additional_config);
	}
}