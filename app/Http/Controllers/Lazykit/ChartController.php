<?php
/**
 | 统计图表：统计图表演示 
 | 该控制器类由 Boolean Lazyer Kit 页面设计器自动生成
 |
 | @auther 		Boolean-PHP-Rapid-Development-Tools
 | @datetime 	2019-04-29 06:12:50
 */

namespace App\Http\Controllers\Lazykit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
     * 统计图表演示
     *
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @param  		\Illuminate\Http\Request $request
     * @return  	mixed
     */
    public function index(Request $request)
    {
    	//读取配置统计图表数据
		$chart = chart_strat('chart_73');
		//print_r($chart);
		//
		
		create_chart($chart);
    }
}