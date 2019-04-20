<?php

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
