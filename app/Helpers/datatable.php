<?php
// +----------------------------------------------------------------------
// | 数据表格生成器(App\Http\datatableController)助手函数
// +----------------------------------------------------------------------
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

//数据库比对  https://blog.csdn.net/zhezhebie/article/details/78675711?utm_source=blogxgwz1


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