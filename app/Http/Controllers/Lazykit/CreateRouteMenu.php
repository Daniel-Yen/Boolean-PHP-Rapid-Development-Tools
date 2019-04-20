<?php
/**
 * 功能名称：创建路由及菜单
 * @auther 		boolean Lazykit
 */

namespace App\Http\Controllers\Lazykit;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repositories\BlkFunctionPageRepository;
use App\Repositories\BlkModuleRepository;
use App\Repositories\BlkSystemRepository;
use App\Repositories\BlkMenuRepository;

trait CreateRouteMenu
{
    /**
     * 生成系统菜单
     *
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @param  		\Illuminate\Http\Request $request
     * @return  	mixed
     */
    public function createMenu()
    {
    	//清除菜单表中已有的数据
    	BlkMenuRepository::truncate();
    	
    	$data = BlkFunctionPageRepository::where('system_id', request()->id)
    				->where('function_type', 1) 			//function_type = 1 取的所有"系统菜单"的页面记录
    				->get();
    	if($data->count()){
    		$data = $data->toArray();
    		
    		//将BlkFunctionPageRepository中查询到的数据转换为BlkMenuRepository的数据并插入
    		$menudata = [];
    		foreach($data as $k=>$v){
    			$menudata[$k] = [
    				'id' => $v['id'],
    				'title' => $v['title'],
    				'pid' => $v['pid'],
    				'url' => $v['url']?$v['url']:NULL,
    			];
    		}
    		
    		//dd($menudata);
    		//DB::connection()->enableQueryLog();
    		$result = BlkMenuRepository::insert($menudata);
    		//dd(DB::getQueryLog());
    		//dd($result);
    		if($result){
    			echo json_encode(['code' => 0, 'msg' => "菜单生成成功", 'refresh' => 'no']);
    		}else{
    			echo json_encode(['code' => 1, 'msg' => "菜单生成失败", 'refresh' => 'no']);
    		}
    	}
    	
    	//dd($menudata);
    }
	
	/**
	 * 生成路由
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @return  	json
	 */
	public function createRoute()
	{
		//获得系统信息
		$system = BlkSystemRepository::where('id', request()->id)->first();
		
		//获得当前系统对应的各类路径
		$path = $this->getPath($system);
		
		//获得菜单中要生成的路由
		$data = BlkFunctionPageRepository::orderBy('module_id', 'asc')
					->where('system_id', $system->id)
					->where('method', '!=', '')
					->get();
		//dd($data);
		$route = "<?php
/*
|--------------------------------------------------------------------------
| Datatable Routes
|--------------------------------------------------------------------------
| 此路由文件由布尔懒人工具包自动生成，包含DataTable生成器相关路由
| 生成日期：".date('Y-m-d H:i:s', time())."
| 注    意：请不要在此文件手写路由
*/

Route::group(['middleware' => ['auth', 'permission']], function(){".PHP_EOL;
		
		if($data->count()){
			$data = $data->toArray();
			//dd($data);
			foreach($data as $k=>$v){
				$module = BlkModuleRepository::where('id',$v['module_id'])->get();
				//dd($module);
				if($module->first()){
					$module = $module->toArray()[0];
				}else{
					$module = [];
				}
				//dd($module);
				//如果菜单没有对应模块则软删除该菜单
				if(!empty($module)){
					if($v['url'] && $v['method']){
						$route_name = "'/".$v['url']."',";
						//计算要补充的空格,让路由文件易读
						$lenth = 35-strlen($route_name);
						if($lenth>0){
							for($i=0;$i<$lenth;$i++){
								$route_name = $route_name.' ';
							}
						}
						$method = $module['module'].'\\'.$v['method'];
						$route_record = "	Route::any(".$route_name."'".$method."');";
						$lenth = 90-strlen($route_record);
						if($lenth>0){
							for($i=0;$i<$lenth;$i++){
								$route_record = $route_record.' ';
							}
						}
						$route .= $route_record."  //".$v['title'].PHP_EOL;
					}
				}else{
					$result = BlkMenuRepository::where('id',$v['id'])->delete();
					//$result = ['code' => 1, 'msg' => "路由生成失败，菜单“".$v['title']."”没有对应的模块"];
				}
			}
			//dd($route);
			$route .= '});';
			
			create_dir($path['route']);
			$route_path = $path['route'].'auto_generate.php';
			//dd($route_path);
			file_put_contents($route_path, $route);
			
			$result = ['code' => 0, 'msg' => "路由文件更新成功", 'refresh' => 'no'];
		}else{
			$result = ['code' => 1, 'msg' => "没有要生成的路由", 'refresh' => 'no'];
		}
		
		return json_encode($result);
	}
}
