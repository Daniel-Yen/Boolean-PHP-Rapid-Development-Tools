<?php
/**
 |------------------------------------------------------------
 | [Boolean Lazyer Kit]布尔懒人工具包·PHP快速开发平台
 |------------------------------------------------------------
 | 作者：倒车的螃蟹<yh15229262120@qq.com>
 | 官网：http://blk.buersoft.cn
 | 手册：http://manual.buersoft.cn/blk
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
        $datatable = new App\Http\Controllers\Blk\DatatableController();
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
			'blk_success' 	=> 'success',
			'lazykit_rules' => [
				'button' => [
					'key' 	=> 'do',
					'value' => ['create']
				]
			]
		]);
		
		$datatable = new App\Http\Controllers\Blk\DatatableController();
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
			'blk_success' 	=> 'success',
			'lazykit_rules' => [
				'button' => [
					'key' 	=> 'do',
					'value' => ['update']
				]
			]
		]);
		
		$datatable = new App\Http\Controllers\Blk\DatatableController();
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
        $config = get_blk_config($config_name);
		
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
        $chart = new App\Http\Controllers\Blk\ChartController();
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
        $chart = new App\Http\Controllers\Blk\ConfigController();
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

if (!function_exists('get_blk_config')) {
	/**
	 * 返回
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		string 		$config_name 			配置文件名
	 * @return 		array                      			返回配置文件
	 */
	function get_blk_config($config_name)
	{
		$path = app_path('Blk'.DIRECTORY_SEPARATOR.$config_name.'.php');
		
		if(file_exists($path)){
			$datatable_config = include($path);
		}else{
			$datatable_config = [];
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
		return view('blk.success')->with([
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
		return view('blk.error')->with([
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
		echo '<div style="font-size:26px; text-align:center; padding-top:15px;">'.$code.'</div>
			  <div style="font-size:18px; text-align:center; padding-top:15px;">'.$msg.'</div>;
			  <div onclick="location.reload();" style="font-size:18px; cursor:pointer; text-align:center; padding-top:15px; color:blue;">刷新</div>';
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

if (!function_exists('array_sort')) {
	/**
	 * 对二维数组按指定键值进行升序或者降序排列
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @param 		array		$arr 		要排序的数组
	 * @param 		string		$keys 		指定排序依据那个字段
	 * @param 		boolean 	$desc 		如果$desc 为 true 则对关联数组按照键值进行降序排序。
	 * @return 		array
	 */
	function array_sort($arr,$keys,$type='asc')
	{
		$keysvalue = $new_array = array();  
		foreach ($arr as $k=>$v){  
			$keysvalue[$k] = $v[$keys];  
		}  
		if($type == 'asc'){  
			asort($keysvalue);  
		}else{  
			arsort($keysvalue);  
		}  
		reset($keysvalue);  
		foreach ($keysvalue as $k=>$v){  
			$new_array[$k] = $arr[$k];  
		}  
		return $new_array;  
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

