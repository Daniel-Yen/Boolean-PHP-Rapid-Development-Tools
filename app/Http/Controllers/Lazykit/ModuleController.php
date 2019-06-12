<?php
/**
 * Datatable自动生成演示
 */
namespace App\Http\Controllers\Lazykit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
   /**
    * 模块管理
    *
    * @author    	倒车的螃蟹<yh15229262120@qq.com> 
    * @access 		public
    * @param  		\Illuminate\Http\Request $request
    * @return  	mixed
    */
    public function index(Request $request)
    {
    	$additional_config = [
    		//数据查询条件
    		'conditions' => [
    			['system_id', '=', $request->system_id],
    		],
    	];
		
		create_datatable('datatable_19', $additional_config, $request);
    }
}
