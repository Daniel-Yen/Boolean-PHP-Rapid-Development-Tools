<?php
/**
 |------------------------------------------------------------
 | [Boolean-PHP-Rapid-Development-Tools] 布尔快速开发工具
 |------------------------------------------------------------
 | 作者：倒车的螃蟹<yh15229262120@qq.com>
 | 官网：http://booleanTools.buersoft.cn
 | 手册：http://manual.buersoft.cn/booleanTools
 |------------------------------------------------------------
 */
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

if (!function_exists('create_datatable')) {
    /**
     * 数据表格生成器
     * @auther 		杨鸿<yh15229262120@qq.com> 
     * @param 		string     					$config_name 		配置名称
     * @param 		array   					$additional_config 	调用数据表格生成器自定义的附加配置参数
	 * @param  		\Illuminate\Http\Request  	$request
     */
    function create_datatable($config_name, $additional_config = [], $request)
    {
        $datatable = new App\Http\Controllers\BooleanTools\DatatableController();
		$datatable->createDatatable($config_name, $additional_config, $request);
    }
}

if (!function_exists('create_insert_form')) {
    /**
     * 数据表格生成器
     * @auther 		杨鸿<yh15229262120@qq.com> 
     * @param 		string     					$config_name 		配置名称
     * @param 		array   					$additional_config 	调用数据表格生成器自定义的附加配置参数
	 * @param  		\Illuminate\Http\Request  	$request
     */
    function create_insert_form($config_name, $additional_config = [], $request)
    {
        $request->merge([
			'do' 			=> 'create',
			'boolean_success' 	=> 'success',
			'lazykit_rules' => [
				'button' => [
					'key' 	=> 'do',
					'value' => ['create']
				]
			]
		]);
		
		$datatable = new App\Http\Controllers\BooleanTools\DatatableController();
		$datatable->createDatatable($config_name, $additional_config, $request);
    }
}

if (!function_exists('create_update_form')) {
    /**
     * 数据表格生成器
     * @auther 		杨鸿<yh15229262120@qq.com> 
     * @param 		string     					$config_name 		配置名称
     * @param 		array   					$additional_config 	调用数据表格生成器自定义的附加配置参数
	 * @param  		\Illuminate\Http\Request  	$request
     */
    function create_update_form($config_name, $additional_config = [], $request, $id)
    {
        $request->merge([
			'id' 			=> $id,
			'do' 			=> 'update',
			'boolean_success' 	=> 'success',
			'lazykit_rules' => [
				'button' => [
					'key' 	=> 'do',
					'value' => ['update']
				]
			]
		]);
		
		$datatable = new App\Http\Controllers\BooleanTools\DatatableController();
		$datatable->createDatatable($config_name, $additional_config, $request);
    }
}

if (!function_exists('chart_strat')) {
    /**
     * 统计图表生成器：获得统计图表配置
     * @auther 		杨鸿<yh15229262120@qq.com> 
     * @param 		string     	$config_name 		配置名称
     */
    function chart_strat($config_name)
    {
        $config = get_boolean_tools_config($config_name);
		
		$config = $config['chart_set'];
		//dd($config);
		$chart_set['config_name'] = $config_name;
		foreach($config as $k=>$v){
			$option = json_decode($v['option'], true);
			$option['tag'] = $v['tag'];
			$chart_set[$v['title']] = $option;
		}
		
		return $chart_set;
    }
}

if (!function_exists('create_chart')) {
    /**
     * 统计图表生成器
     * @auther 		杨鸿<yh15229262120@qq.com> 
     * @param 		array   	$chart_data 		包含统计图表数据的数组
     */
    function create_chart($chart_data)
    {
        $chart = new App\Http\Controllers\BooleanTools\ChartController();
		$chart->createChart($chart_data);
    }
}

if (!function_exists('create_config')) {
    /**
     * 配置页面生成器
     * @auther 		杨鸿<yh15229262120@qq.com> 
     * @param 		string     	$config_name 		配置名称
     */
    function create_config($config_name, $request)
    {
        $chart = new App\Http\Controllers\BooleanTools\ConfigController();
		$chart->createConfig($config_name, $request);
    }
}

if (!function_exists('datatable_success')) {
	/**
	 * 用于layui弹窗数据操作后关闭弹窗并刷新datatable
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @param 		string		$text 		提示信息
	 * @return 		string 					返回值为一段JavaScript代码
	 */
	function datatable_success($text)
	{
		echo "<script>
				parent.tools.reload();
				parent.tools.layerCloseAll();
			  </script>";
		die();
	}
}

if (!function_exists('datatable_callback_json')) {
	/**
	 * 用于给datatable数据表格返回查询结果的json数据，用于layui数据源
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		integer		$code 			0代表提供给layui的数据正常
	 * @param 		string		$msg 			提示信息
	 * @param 		integer 	$count 			数据总数，非当前分页的数据，此数值会被layui用于计算分页
	 * @param 		array 		$rows_arr 		二维数组数据
	 * @return 		string | json 				返回提交给layui数据表格的数据
	 */
	function datatable_callback_json($code = 0, $msg = "", $count = 0, $rows_arr=[])
	{
		$result = [
			'code' => $code,
			'msg' => $msg,
			'count' => $count,
			'data' => $rows_arr
		];
		
		echo json_encode($result);
	}
}

if (!function_exists('hump_name')) {
	/**
	 * 获得数据表驼峰法书写的名称，如hump_name('buer_tools_attachment') 输出ToolsAttachment
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		string		$main_table 			提示信息
	 * @return 		string 								返回提交给layui数据表格的数据
	 */
	function hump_name($main_table)
	{
		//替换表名称中的表前缀
		$char = str_replace(env('DB_PREFIX'), '', $main_table);
		//函数将给定的字符串转换为「变种驼峰命名」
		$char = studly_case($char);
		
		return $char;
	}
}

if (!function_exists('get_boolean_tools_config_by_file_path')) {
	/**
	 * 按文件路径返回配置，进开发工具中使用
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		string 		$config_path 			配置文件路径
	 * @return 		array                      			返回配置文件
	 */
	function get_boolean_tools_config_by_file_path($path)
	{
		if(file_exists($path)){
			$config_json = file_get_contents($path);
			$datatable_config = json_decode($config_json, true);
			if(!is_array($datatable_config)){
				exception_thrown(1002, '页面配置文件不是标准json数据');
			}
		}else{
			$datatable_config = [];
		}
		
		if(empty($datatable_config)){
			exception_thrown(1001, '配置文件不存在');
		}
		
		return $datatable_config;
	}
}

if (!function_exists('get_boolean_tools_config')) {
	/**
	 * 返回
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		string 		$config_name 			配置文件名
	 * @return 		array                      			返回配置文件
	 */
	function get_boolean_tools_config($config_name)
	{
		$path = app_path('booleanTools'.DIRECTORY_SEPARATOR.$config_name.'.json');
		
		if(file_exists($path)){
			$config_json = file_get_contents($path);
			$datatable_config = json_decode($config_json, true);
			if(!is_array($datatable_config)){
				exception_thrown(1002, '页面配置文件不是标准json数据');
			}
		}else{
			$datatable_config = [];
		}
		
		if(empty($datatable_config)){
			exception_thrown(1001, '配置文件不存在');
		}
		
		return $datatable_config;
	}
}

if (!function_exists('success')) {
	/**
	 * 操作成功跳转页面
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @param  		string 		$message 			提示信息
	 * @return 		
	 */
	function success($message = '', $supplement = '', $url = '') {
		//dd(request()->fullUrl());
		return view('booleanTools.success')->with([
			//跳转信息
			'message' => $message ? $message : "操作成功",
			//跳转信息
			'supplement' => $supplement ? $supplement : "您已成功完成当前操作，稍后为您跳转",
			//跳转路径
		    'url' => $url ? $url : url()->previous(),
		    //跳转等待时间（s）
		    'jumpTime' => 2,
		]);
	}
}

if (!function_exists('error')) {
	/**
	 * 操作成功跳转页面
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @param  		string 		$message 			提示信息
	 * @return 		
	 */
	function error($message = '', $supplement = '') {
		//dd(request()->fullUrl());
		return view('booleanTools.error')->with([
			//跳转信息
			'message' => $message ? $message : "操作失败",
			//跳转信息
			'supplement' => $supplement ? $supplement : "当前操作出现意外，稍后为您跳转返回重新操作",
		    //跳转等待时间（s）
		    'jumpTime' => 4,
		]); 
	}
}

if (!function_exists('exception_thrown')) {
	/**
	 * Datatable自定义异常提示 
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @param 		object		$array 		要排序的数组
	 * @return 		array
	 */
	function exception_thrown($code, $msg) {  
		echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>'.$msg.'</title><style>html,body{background-color:#fff;color:#636b6f;font-family:"Nunito",sans-serif;font-weight:100;height:100vh;margin:0}.full-height{height:100vh}.flex-center{align-items:center;display:flex;justify-content:center}.position-ref{position:relative}.code{border-right:2px solid;font-size:26px;padding:0 15px 0 15px;text-align:center}.message{font-size:18px;text-align:center}</style></head><body>
				<div class="flex-center position-ref full-height">
					<div class="code"> '.$code.' </div>
					<div class="message" style="padding: 10px;"> '.$msg.' </div>
				</div>
			  </body></html>';
		die();  
	}
}

if (!function_exists('is_empty')) {
    /**
     * 判断变量或者数据是否为空或者null
     *
     * @param 	array|variable 		$param 		变量或者数据
     * @return 	boolean
     */
    function is_empty($param)
    {
        if(empty($param) || is_null($param)){
			return true;
		}else{
			return false;
		}

    }
}

if (!function_exists('file_path')) {
    /**
     * 返回指定文件路径文件的完整地址，实现本地环境跟服务器环境加载不同存放位置的静态资源文件
     *
     * @param 	integer 	$file 	文件路径+文件名
     * @return 	string 				文件路径
     */
    function file_path($file)
    {
        return ''.$file;

    }
}

if (!function_exists('array_sort_by_value')) {
	/**
	 * 对二维数组按指定键值进行升序或者降序排列
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @param 		array		$arr 		要排序的数组
	 * @param 		string		$keys 		指定排序依据那个字段
	 * @param 		boolean 	$desc 		如果$desc 为 true 则对关联数组按照键值进行降序排序。
	 * @return 		array
	 */
	function array_sort_by_value($arr,$key,$type='asc')
	{
		$arr_1 = $arr_2 = [];
		//将被排序字段值为0的记录取出来放到$arr_1中
		foreach($arr as $k=>$v){
			if(isset($v[$key])?$v[$key]:false){
				$arr_2[] = $v;
			}else{
				//如果$key为空或者null,则给他一个默认值0
				$arr_1[] = $v;
			}
		}
		//dd($arr_1, $arr_2);
		//对$arr_2进行排序
		$collection = collect($arr_2);
		 
		if($type == 'asc'){  
			$result = $collection->sortBy($key);
			$merged = array_merge($arr_1, $result->values()->all());
		}else{  
			$result = $collection->sortByDesc($key); 
			$merged = array_merge($result->values()->all(), $arr_1);
		} 
		
		return $merged;
	}
}

if (!function_exists('object_array')) {
	/**
	 * stdClass Object转array 
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @param 		object		$array 		要排序的数组
	 * @return 		array
	 */
	function object_array($array) {  
		if(is_object($array)) {  
			$array = (array)$array;  
		} if(is_array($array)) {  
			foreach($array as $key=>$value) {  
				 $array[$key] = object_array($value);  
			}  
		}  
		return $array;  
	}
}

if (!function_exists('create_dir')) {
	/**
	 * 判断目录存在否，存在给出提示，不存在则创建目录
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @param 		string		$path 		文件目录
	 * @return 		boolean
	 */
	function create_dir($path) {
		if (!is_dir($path)){
		    //第三个参数是“true”表示能创建多级目录，iconv防止中文目录乱码
		    $res = mkdir(iconv("UTF-8", "GBK", $path),0777,true); 
		    if ($res){
		        return true;
		    }else{
		        return false;
		    }
		}
	}
}

