<?php
// +----------------------------------------------------------------------
// | 数据表格生成器(App\Http\datatableController)助手函数
// +----------------------------------------------------------------------
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

//数据库比对  https://blog.csdn.net/zhezhebie/article/details/78675711?utm_source=blogxgwz1


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