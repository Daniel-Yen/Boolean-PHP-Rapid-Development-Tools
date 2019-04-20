<?php
// +----------------------------------------------------------------------
// | 数据表格生成器(App\Http\datatableController)助手函数
// +----------------------------------------------------------------------
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

//数据库比对  https://blog.csdn.net/zhezhebie/article/details/78675711?utm_source=blogxgwz1

if (!function_exists('create_datatable')) {
    /**
     * datatable生成器
     * @auther 		杨鸿<yh15229262120@qq.com> 
     * @param 		string     	$datatable_config_name 		配置名称
     * @param 		array   	$additional_config 			调用数据表格生成器自定义的附加配置参数
     */
    function create_datatable($datatable_config_name, $additional_config = [], $request)
    {
        $datatable = new App\Http\Controllers\common\DatatableGenerateController();
		$datatable->createDatatable($datatable_config_name, $additional_config, $request);
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

if (!function_exists('get_datatable_config')) {
	/**
	 * 返回
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		string 		$datatable_config_name 			根据datatable配置文件及字段属性表中的的字段属性生成的layui数据表格表头属性的数组
	 * @return 		array                      					返回类似datatable数据表格的配置文件
	 */
	function get_datatable_config($datatable_config_name)
	{
		$path = app_path('Datatable'.DIRECTORY_SEPARATOR.$datatable_config_name.'.php');
		//$path = '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Datatable'.DIRECTORY_SEPARATOR.$datatable_config_name.'.php';
		//dd($path);
		if(file_exists($path)){
			$datatable_config = include($path);
		}else{
			$datatable_config = [];
		}
		//dd($datatable_config);
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
		return view('datatable.success')->with([
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
		return view('datatable.error')->with([
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

if (!function_exists('create_controller')) {
	/**
	 * 根据菜单的生成控制器及方法
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @param 		array		$data 		要处理的二维数组数组
	 * @param 		string		$title 		要作为title的字段
	 * @return 		array
	 */
	function create_controller($route_message) {
		if(!$route_message['controller_exists']){
			$path = app_path('Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$route_message['module'].DIRECTORY_SEPARATOR);
			//生成目录
			create_dir($path);
			$path = $path.$route_message['controller'].'.php';
			$file = file_get_contents(app_path('Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'NewController.php'));
			$file = str_replace('{menu_title}', $route_message['menu_title'], $file);
			$file = str_replace('{module}', $route_message['module'], $file);
			$file = str_replace('{NewController}', $route_message['controller'], $file);
			$file = str_replace('{method}', $route_message['method'], $file);
			$file = str_replace('{id}', $route_message['id'], $file);
			file_put_contents($path, $file);
		}
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

if (!function_exists('lazykit_encryption')) {
	/**
	 * 判断目录存在否，存在给出提示，不存在则创建目录
	 * @auther 		杨鸿<yh15229262120@qq.com> 
	 * @param 		string		$path 		文件目录
	 * @return 		boolean
	 */
	function lazykit_encryption($text) {
		
	}
}