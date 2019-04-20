<?php
/**
* 通用的树型类，可以生成任何树型结构
*/

namespace App\Http\Controllers\Blk;

use App\Http\Controllers\Controller;

class TreeController extends Controller
{
	/**
	* 生成树型结构所需要的2维数组
	* @var array
	*/
	public $arr = array();
	
	/**
	* 生成树型结构所需要的2维数组
	* @var array
	*/
	public $arr_2 = array();
 
	/**
	* @access private
	*/
	public $ret = '';
 
	/**
	* 构造函数，初始化类
	* @param array 2维数组，例如：
	* array(
	*      1 => array('id'=>'1','parentid'=>0,'name'=>'一级栏目一'),
	*      2 => array('id'=>'2','parentid'=>0,'name'=>'一级栏目二'),
	*      3 => array('id'=>'3','parentid'=>1,'name'=>'二级栏目一'),
	*      4 => array('id'=>'4','parentid'=>1,'name'=>'二级栏目二'),
	*      5 => array('id'=>'5','parentid'=>2,'name'=>'二级栏目三'),
	*      6 => array('id'=>'6','parentid'=>3,'name'=>'三级栏目一'),
	*      7 => array('id'=>'7','parentid'=>3,'name'=>'三级栏目二')
	*      )
	*/
	public function __construct($arr=array()){
       $this->arr = $arr;
	   //$this->ret = '';
	   return is_array($arr);
	}
	
	/**
	 * 将数组转化成DataGrid树形表格的数据
	 *
	 * @access    	public
	 * @author    	倒车的螃蟹<yh15229262120@qq.com>
	 * @return array
	 */
	public function listToDatatableTree($pk ='id',$pid = 'pid',$child = 'children',$root = 0)
	{
		$data_arr = [];
		//转换成树用于排序
		$data = $this->listToTree();
		if(is_array($data)?!empty($data):false) {
			$data_arr = $this->TreeToList($data, 'id', 'pid', 'children', 0);
		}
		
		return $data_arr;
		
	}
	
	/**
	 * 将数组转化成DataGrid树形表格的数据
	 *
	 * @access    	public
	 * @author    	倒车的螃蟹<yh15229262120@qq.com>
	 * @return array
	 */
	public function TreeToList($data, $pk ='id', $pid = 'pid', $child = 'children', $root = 0)
	{
		$data_arr = [];
		foreach($data as $k=>$v){
			$row = $v;
			if(@is_array($v[$child])){
				$row['title'] = '<i class="layui-icon layui-icon-triangle-r"></i> '.$row['title'];
				unset($row[$child]);
			}else{
				$row['title'] = '<i class="layui-icon layui-icon-file"></i> '.$row['title'];
			}
			$data_arr[] = $row;
			if(@is_array($v[$child])){
				foreach($v[$child] as $k1=>$v1){
					$row = $v1;
					if(@is_array($v1[$child])){
						$row['title'] = '<i class="layui-icon layui-icon-triangle-r"></i>'.$row['title'];
						unset($row[$child]);
					}else{
						$row['title'] = '<i class="layui-icon layui-icon-file"></i> '.$row['title'];
					}
					$row['title'] = '&nbsp; &nbsp; '.$row['title'];
					$data_arr[] = $row;
					if(@is_array($v1[$child])){
						foreach($v1[$child] as $k2=>$v2){
							$row = $v2;
							if(@is_array($v2[$child])){
								$row['title'] = '<i class="layui-icon layui-icon-triangle-r"></i>'.$row['title'];
								unset($row[$child]);
							}else{
								$row['title'] = '<i class="layui-icon layui-icon-file"></i> '.$row['title'];
							}
							$row['title'] = '&nbsp; &nbsp; &nbsp; &nbsp; '.$row['title'];
							$data_arr[] = $row;
							if(@is_array($v2[$child])){
								foreach($v2[$child] as $k3=>$v3){
									$row = $v3;
									if(@is_array($v3[$child])){
										$row['title'] = '<i class="layui-icon layui-icon-triangle-r"></i>'.$row['title'];
										unset($row[$child]);
									}else{
										$row['title'] = '<i class="layui-icon layui-icon-file"></i> '.$row['title'];
									}
									$row['title'] = '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; '.$row['title'];
									$data_arr[] = $row;
									if(@is_array($v2[$child])){
										foreach($v2[$child] as $k3=>$v3){
											$row = $v3;
											if(@is_array($v3[$child])){
												$row['title'] = '<i class="layui-icon layui-icon-triangle-r"></i>'.$row['title'];
												unset($row[$child]);
											}else{
												$row['title'] = '<i class="layui-icon layui-icon-file"></i> '.$row['title'];
											}
											$row['title'] = '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; '.$row['title'];
											$data_arr[] = $row;
											if(@is_array($v3[$child])){
												foreach($v3[$child] as $k4=>$v4){
													$row = $v4;
													if(@is_array($v4[$child])){
														$row['title'] = '<i class="layui-icon layui-icon-triangle-r"></i>'.$row['title'];
														unset($row[$child]);
													}else{
														$row['title'] = '<i class="layui-icon layui-icon-file"></i> '.$row['title'];
													}
													$row['title'] = '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; '.$row['title'];
													$data_arr[] = $row;
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return $data_arr;
		
	}
	
	/**
	 * 把返回的数据集转换成Tree
	 *
	 * @access    	public
	 * @author    	倒车的螃蟹<yh15229262120@qq.com>
	 * @return array
	 */
	function listToTree($pk = 'id',$pid = 'pid',$child = 'children',$root = 0) {
		// 创建Tree
		$tree = array();
		$list = $this->object_array($this->arr);
		if(is_array($list)?!empty($list):false) {
			// 创建基于主键的数组引用
			$refer = array();
			foreach ($list as $key => $data) {
				$refer[$data[$pk]] =& $list[$key];
			}
			foreach ($list as $key => $data) {
				// 判断是否存在parent
				$parentId = $data[$pid];
				if ($root == $parentId) {
					$tree[] =& $list[$key];
				}else{
					if (isset($refer[$parentId])) {
						$parent =& $refer[$parentId];
						$parent[$child][] =& $list[$key];
					}
				}
			}
		}
		return $tree;
	}
	
	/**
	 * 把返回的数据集转换成前端Select下拉需要的树
	 *
	 * @access    	public
	 * @author    	倒车的螃蟹<yh15229262120@qq.com>
	 * @return array
	 */
	function listToSelectTree($pk = 'value',$pid = 'pid',$child = 'children',$root = 0) {
		// 创建Tree
		$tree = array();
		$list = $this->object_array($this->arr);
		if(is_array($list)?!empty($list):false) {
			// 创建基于主键的数组引用
			$refer = array();
			foreach ($list as $key => $data) {
				$refer[$data[$pk]] =& $list[$key];
			}
			foreach ($list as $key => $data) {
				// 判断是否存在parent
				$parentId = $data[$pid];
				if ($root == $parentId) {
					$tree[] =& $list[$key];
				}else{
					if (isset($refer[$parentId])) {
						$parent =& $refer[$parentId];
						$parent[$child][] =& $list[$key];
					}
				}
			}
		}
		return $tree;
	}
	
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

	/**
	 * PHP stdClass Object转array  
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		object 			$array 			stdClass对象
	 * @return 		array                      		返回类似DataGrid数据表格的配置文件
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