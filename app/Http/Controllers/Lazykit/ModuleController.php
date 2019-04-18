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
    	create_datatable('datatable_19', [], $request);
    }
	
// 	public function build(){
// 		$module_name = 'test';
// 		
// 		Storage::makeDirectory('app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$module_name);
// 		Storage::makeDirectory('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$module_name);
// 	}
}
