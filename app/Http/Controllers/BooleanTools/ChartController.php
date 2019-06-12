<?php
/**
 |------------------------------------------------------------
 | [Boolean-PHP-Rapid-Development-Tools] 布尔快速开发工具
 |------------------------------------------------------------
 | 作者：倒车的螃蟹<yh15229262120@qq.com>
 | 官网：http://brdt.buersoft.cn
 | 手册：http://manual.buersoft.cn/brdt
 | 版本：V3.0.0
 |------------------------------------------------------------
 */

namespace App\Http\Controllers\BooleanTools;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ChartController extends Controller
{
	/**
	 * 生成统计图表页面
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		string     	$chart_data 			//统计图表的数据
	 * @return 		mixed
	 */
    public function createChart($chart_data)
    {
    	$chart_config = get_boolean_tools_config($chart_data['config_name']);
		
		$chart_set = $chart_config['chart_set'];
		//dd($chart_set);
		foreach($chart_set as $k=>$v){
			$v['option'] = json_encode($chart_data[$v['title']]);
			$chart_set[$k] = $v;
		}
		
		$chart_config['chart_set'] = $chart_set;
		//dd($chart_config);
		echo view('booleanTools.echarts.body', [
			'chart_config' => $chart_config,
		]);
	}
}