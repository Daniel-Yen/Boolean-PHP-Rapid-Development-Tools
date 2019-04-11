<?php
/**
 * Datatable自动生成演示
 */
namespace App\Http\Controllers\Lazykit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    /**
     * DataGrid完整示例
     * @access    	public
     * @author    	杨鸿<yh15229262120@qq.com>
     */
    public function index(Request $request)
    {
    	create_datatable('datatable_15', [], $request);
    }
	
	/**
	 * DataGrid自定义字段
	 * @access    	public
	 * @author    	杨鸿<yh15229262120@qq.com>
	 */
	public function external(Request $request)
	{
		$additional_config = [
			'data_source_method' => 'data_source',		//控制器类的方法:获得表格数据
		];
		
		create_datatable('datatable_22', $additional_config, $request);
	}
	
	//新数据源
	public function data_source(){
		$rows_arr = [];
		for($i=0; $i<100; $i++){
			$rows_arr[$i]['field_1'] = 'field_1'.$i;
			$rows_arr[$i]['field_2'] = 'field_2'.$i;
			$rows_arr[$i]['field_3'] = 'field_3'.$i;
			$rows_arr[$i]['field_4'] = 'field_4'.$i;
			$rows_arr[$i]['field_5'] = 'field_5'.$i;
			$rows_arr[$i]['field_6'] = 'field_6'.$i;
			$rows_arr[$i]['field_7'] = 'field_7'.$i;
		}
		
		return $rows_arr;
	}
	
	/**
	 * DataGrid树形表格
	 * @access    	public
	 * @author    	杨鸿<yh15229262120@qq.com>
	 */
	public function treetable()
	{
		create_datatable('datatable_22', [], $request);
	}
}
