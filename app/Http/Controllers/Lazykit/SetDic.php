<?php
/**
 * 功能名称：Datatable自动生成演示
 * 该控制器类由Datatable生成器自动生成
 * @auther 		boolean Lazykit
 */

namespace App\Http\Controllers\Lazykit;

trait SetDic
{
    /**
     * 数据字典：数据表关联类型
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array                       
     */
    private function joinTypeDic(){
    	return [
    		'INNER JOIN' 	=> 'INNER JOIN',
    		'LEFT JOIN' 	=> 'LEFT JOIN',
    		'RIGHT JOIN' 	=> 'RIGHT JOIN',
    	];
    }
    
    /**
     * 数据字典：行内按钮样式
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array                       
     */
    private function buttonStyleTypeDic(){
    	return [
    		'layui-btn-0' 	=> '绿色',
    		'layui-btn-primary' 	=> '无背景',
    		'layui-btn-normal' 		=> '蓝色',
    		'layui-btn-warm' 		=> '黄色',
    		'layui-btn-danger' 		=> '红色',
    		'layui-btn-disabled' 	=> '禁用',
    	];
    }
    
    /**
     * 数据字典：验证规则
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array                       
     */
    private function validateDic(){
    	$data = [
    		'bail' 			=> '第一次验证失败后停止运行验证规则（bail）',
    		'required' 		=> '必填（required）',
    		'alpha' 		=> '字段必须完全由字母构成（alpha）',
    		'string' 		=> '字段必须是一个字符串（string）',
    		'alpha_dash' 	=> '字段可能包含字母、数字，以及破折号 (-) 和下划线 ( _ )（alpha_dash）',
    		'alpha_num' 	=> '字段必须是完全是字母、数字（alpha_num）',
    		'date' 			=> '字段必须是有效的日期（date）',
    		'email' 		=> '字段必须为正确格式的电子邮件地址（email）',
    		'image' 		=> '文件必须是图片 (jpeg, png, bmp, gif, 或 svg)（image）',
    		'integer' 		=> '验证的字段必须是整数（integer）',
    		'numeric' 		=> '字段必须是数字（numeric）',
    		'ip' 			=> '字段必须是 IP 地址（ip）',
    		'ipv4' 			=> '字段必须是 IPv4 地址（ipv4）',
    		'ipv6' 			=> '字段必须是 IPv6 地址（ipv6）',
    		'json' 			=> '字段必须是有效的 JSON 字符串（json）',
    		'url' 			=> '字段必须是有效的 URL（url）',
    	];
    	
    	$data_arr = [];
    	foreach($data as $k=>$v){
    		$data_arr[] = [
    			'value' => $k,
    			'name'  => $v,
    		];
    	}
    	
    	return $data_arr;
    }
    
    /**
     * 数据字典：按钮打开方式
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array                       
     */
    private function buttonOpenTypeDic(){
    	return [
    		'window' 	=> '弹出窗口',
    		'ajax' 		=> '异步请求',
    	];
    }
    
    /**
     * 数据字典：固定列数组
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array
     */
    private function fixedColumnDic(){
    	return [
    		'left' 	=> '左固定',
    		'right' => '右固定',
    	];
    }
    
    /**
     * 数据字典：表单验证规则
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array
     */
    private function verifyDic(){
    	return [
    		'required' 	=> '必填项',
    		'phone' 	=> '手机号',
    		'email' 	=> '邮箱',
    		'url' 		=> '网址',
    		'number' 	=> '数字',
    		'date' 		=> '日期',
    		'identity' 	=> '身份证',
    	];
    }
    
    /**
     * 数据字典：链接类型
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array                       
     */
    private function urlTypeDic(){
    	return [
    		'new_window' 	=> '新窗口打开',
    		'window' 		=> '弹出窗口',
    		'redirect' 		=> '链接触发',
    	];
    }
    
    /**
     * datatable 头部工具菜单
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array                       
     */
    private function headMenu($datatable_set_arr, $datatable_arr){
    	$menu = [
    		'search' => 
    		[
    		  'text' => '搜索',
    		  'must' => 'on',
    		  'new_action' => '',
    		  'width' => '800px',
    		  'height' => '90%',
    		  'route' => '',
    		  'icon' => 'layui-icon-search'
    		],
    		'create' => 
    		[
    		  'text' => '新增',
    		  'must' => '',
    		  'new_action' => '',
    		  'width' => '100%',
    		  'height' => '100%',
    		  'route' => '',
    		  'icon' => 'layui-icon-add-1'
    		],
    		'update' => 
    		[
    		  'text' => '修改',
    		  'must' => '',
    		  'new_action' => '',
    		  'width' => '100%',
    		  'height' => '100%',
    		  'route' => '',
    		  'icon' => 'layui-icon-edit'
    		],
    		'delete' => 
    		[
    		  'text' => '删除',
    		  'must' => '',
    		  'new_action' => '',
    		  'width' => '',
    		  'height' => '',
    		  'route' => '',
    		  'icon' => 'layui-icon-delete'
    		],
    		/*'import' => 
    		[
    		  'text' => '导入',
    		  'must' => '',
    		  'new_action' => '',
    		  'width' => '100%',
    		  'height' => '100%',
    		  'route' => '',
    		  'icon' => 'layui-icon-down'
    		],
    		'export' => 
    		[
    		  'text' => '导出',
    		  'must' => '',
    		  'new_action' => '',
    		  'width' => '100%',
    		  'height' => '100%',
    		  'route' => '',
    		  'icon' => 'layui-icon-up'
    		],
    		'upload' => 
    		[
    		  'text' => '上传',
    		  'must' => '',
    		  'new_action' => '',
    		  'width' => '100%',
    		  'height' => '100%',
    		  'route' => '',
    		  'icon' => 'layui-icon-upload-drag'
    		],*/
    		'recycle' => 
    		[
    		  'text' => '回收站',
    		  'must' => 'on',
    		  'new_action' => '',
    		  'width' => '100%',
    		  'height' => '100%',
    		  'route' => '',
    		  'icon' => 'layui-icon-fonts-del'
    		],
    		'recovery' => 
    		[
    		  'text' => '数据恢复',
    		  'must' => 'on',
    		  'new_action' => '',
    		  'width' => '',
    		  'height' => '',
    		  'route' => '',
    		  'icon' => 'layui-icon-prev'
    		]
    	];
    	
    	//如果没有主表,则头部菜单只有搜索
    	if(empty($datatable_arr['main_table'])){
    		$menu = [
    			'search2' => 
    			[
    			  'text' => '搜索2',
    			  'must' => 'on',
    			  'new_action' => '',
    			  'width' => '800px',
    			  'height' => '90%',
    			  'route' => '',
    			  'icon' => 'layui-icon-search'
    			]
    		];
    	}
    	
    	//将头部工具菜单配置添加到头部菜单上
    	if(isset($datatable_set_arr['head_menu'])){
    		foreach($datatable_set_arr['head_menu'] as $k=>$v){
    			if(isset($menu[$k])){
    				$menu[$k] = $v;
    			}
    		}
    	}
    	
    	//如果有deleted_at字段则显示回收站跟数据恢复
    	if(!isset($datatable_set_arr['datatable_set']['deleted_at'])){
    		unset($menu['recycle']);
    		unset($menu['recovery']);
    	}
    	
    	return $menu;
    }
    
    /**
     * 数据字典:数据输入方式
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array                       
     */
    private function dataInputFormDic(){
    	return [
    		'文本输入' => [
    			'input' 				=> ['单行文本框', '100%'],
    			'textarea' 				=> ['文本区域', '100%']
    		],
    		'下拉选择' => [
    			'select' 				=> ['下拉单项选择', '180px'],
    			'multiple_select'		=> ['下拉多项选择', '180px'],
    			'tree_select'			=> ['树状下拉选择', '180px'],
    			'cascade_select'		=> ['级联选择', '180px'],
    		],
    		'编辑器' => [
    			'layui_editer' 			=> ['layui 编辑器', '100%'],
    			'layui_editer_simple' 	=> ['layui 编辑器精简版', '100%'],
    			'editormd' 				=> ['Markdown 编辑器', '100%']
    		],
    		'上传' => [
    			'single_photo_upload' 	=> ['单图上传', ''],
    			'photos_upload' 		=> ['多图上传', ''],
    			'single_file_upload' 	=> ['单文件上传', ''],
    			'files_upload' 			=> ['多文件上传', '']
    		],
    		'日期时间' => [
    			'year' 					=> ['年选择器', '180px'],
    			'year_mouth' 			=> ['年月选择器', '180px'],
    			'date' 					=> ['日期选择器', '180px'],
    			'time' 					=> ['时间选择器', '180px'],
    			'datetime' 				=> ['日期时间选择器', '180px'],
    			'date_scope' 			=> ['日期范围', '180px'],
    			'year_scope' 			=> ['年范围', '180px'],
    			'year_mouth_scope' 		=> ['年月范围', '180px'],
    			'time_scope' 			=> ['时间范围', '180px'],
    			'datetime_scope' 		=> ['日期时间范围', '340px']
    		],
    		'其他' => [
    			'color_choices' 		=> ['颜色选择', '180px']
    		]
    	];
    }
    
    /**
     * 数据字典类型
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array                       
     */
    private function dicTypeDic(){
    	return [
    		'no_dic' 		=> '不关联数据字典',
    		'static_dic' 	=> '关联静态数据字典',
    		'table_dic' 	=> '关联数据库数据字典',
    	];
    }
    
    /**
     * select/tree_select数据源类型
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array                       
     */
    private function dataSourceDic(){
    	return [
    		'method' 		=> '控制器方法',
    		'sql' 			=> 'SQL语句',
    		'json' 			=> 'JSON数据',
    	];
    }
    
    /**
     * 单元格排列方式
     * @access 		private
     * @author    	杨鸿<yh15229262120@qq.com> 
     * @return 		array                       
     */
    private function alignDic(){
    	return [
    		'left' 		=> '居左',
    		'center' 	=> '居中',
    		'right' 	=> '居右',
    	];
    }
	
	//model字段的下拉选择
	public function attribute_model(){
		$data = [
			['value' => '1', 	'name' => '自定义代码'],
			['value' => '2', 	'name' => '数据表格'],
			['value' => '3', 	'name' => '统计图表'],
			['value' => '3', 	'name' => '配置文件'],
		];
		
		return $data;
	}
}
