<?php
/**
 * 功能名称：Datatable自动生成演示
 * 该控制器类由Datatable生成器自动生成
 * @auther 		boolean Lazykit
 */

namespace App\Http\Controllers\Lazykit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DemoTreeRepository;

class DemoController extends Controller
{
    /**
     * DataGrid完整示例
     *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @param  		\Illuminate\Http\Request $request
     * @return  	mixed
     */
    public function index(Request $request)
    {
    	create_datatable('datatable_15', [], $request);
    }
	
	/**
	 * DataGrid自定义字段
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		\Illuminate\Http\Request $request
	 * @return  	mixed
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
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		\Illuminate\Http\Request $request
	 * @return  	mixed
	 */
	public function treeTable(Request $request)
	{
		create_datatable('datatable_24', [], $request);
	}
	
	//select
	public function attributeSelect(){
		$data = [
			[ 'value' => '1', 'name' => '灞桥区' ],
			[ 'value' => '2', 'name' => '长安区' ],
			[ 'value' => '3', 'name' => '未央区' ],
		];
		
		return $data;
	}
	
	//下拉多项选择
	public function attributeTreeSelect(){
		$data = [
			['name' => '陕西', 'value' => '1', 'children' => [
					['name' => '西安', 'value' => '2', 'children' => [
							['name' => '灞桥区', 'value' => '3'],
							['name' => '长安区', 'value' => '4'],
							['name' => '未央区', 'value' => '5']
						]
					],
					['name' => '汉中', 'value' => '6'],
					['name' => '咸阳', 'value' => '7']
				]	
			],
			['name' => '甘肃', 'value' => '8', 'children' => [
					['name' => '武威', 'value' => '9', 'children' => [
							['name' => '古浪县', 'value' => '10'],
							['name' => '民勤县', 'value' => '11'],
						]	
					],
					['name' => '天水', 'value' => '12'],
					['name' => '庆阳', 'value' => '13']
				]
			]
		];
		
		return $data;
	}
	
	//pid字段的下拉选择
	public function attribute_pid(){
		$data = DemoTreeRepository::select('id as value', 'title as name', 'pid')->get();
		if($data->count()){
			$data = $data->toArray();
			//转换为树结构
			$tree = new \App\Http\Controllers\BooleanTools\TreeController($data);
			$data = $tree->listToSelectTree();
		}else{
			$data = [];
		}
		
		return $data;
	}
}