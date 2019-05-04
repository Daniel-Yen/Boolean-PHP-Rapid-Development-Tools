<?php
/**
 * 功能名称：创建路由、菜单、模型、验证器等
 * @auther 		boolean Lazykit
 */

namespace App\Http\Controllers\Lazykit;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Repositories\BlkFunctionPageRepository;
use App\Repositories\BlkMiddlewareRepository;
use App\Repositories\BlkModuleRepository;
use App\Repositories\BlkSystemRepository;
use App\Repositories\BlkMenuRepository;

trait Create
{
    /**
     * 根据表名称生成表模型
     * 当配置存在数据表的时候根据数据表生成数据表对应的空模型类及空的验证器类,如果已存在同名文件则不重复生成
     *
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		private
     * @param 		string 		$tablename 				表名称
     * @return 		
     */
    private function createRepository($tablename, $path)
    {
    	//根据数据库表名称获得要生成的模型的类名称跟文件名
    	$hump_name = Str::studly($tablename);
    	//读取空模型的模板
    	create_dir($path['repository']);
    	$file_name = $path['repository'].$hump_name.'Repository'.'.php';
    	if(!file_exists($file_name)){
    		//替换空模型模板中的数据
    		$file = $path['repository_tpl'];
			$file = str_replace('{New}',$hump_name,$file);
    		$file = str_replace('{table_name}',$tablename,$file);
    		file_put_contents($file_name,$file);
    	}
    }
    
    /**
     * 根据菜单的生成控制器及方法
	 
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		private
     * @param 		array		$route_message 		要处理的二维数组数组
     * @param 		array		$path 				相关path
	 * @param 		string 		$model 				页面模型
     * @return 		array
     */
    private function create_controller($route_message, $path, $model) {
    	//dd($route_message, $path);
		if(!$route_message['controller_exists']){
    		//$controller_path = app_path('Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$route_message['module'].DIRECTORY_SEPARATOR);
    		$controller_path = $path['controller'].$route_message['module'].DIRECTORY_SEPARATOR;
			//生成目录
    		create_dir($controller_path);
    		
 			$file_path = $controller_path.$route_message['controller'].'.php';
			$file = $path['controller_'.$model.'tpl'];
    		//$file = file_get_contents(app_path('Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'NewController.php'));
    		$file = str_replace('{menu_title}', $route_message['menu_title'], $file);
    		$file = str_replace('{module}', $route_message['module'], $file);
    		$file = str_replace('{NewController}', $route_message['controller'], $file);
    		$file = str_replace('{method}', $route_message['method'], $file);
    		$file = str_replace('{id}', $route_message['id'], $file);
    		file_put_contents($file_path, $file);
    	}
    }
	
	/**
	 * 动态改变数据库配置重连数据库
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access    	public
	 * @param 		App\Repositories\BlkSystemRepository 	$system 	//要重连的系统
	 * @return 		void
	 */
	public function reconnectDB($system)
	{
		config(['database.connections.mysql.host' 		=> $system->host]);
		config(['database.connections.mysql.port' 		=> $system->port]);
		config(['database.connections.mysql.database' 	=> $system->database]);
		config(['database.connections.mysql.username' 	=> $system->username]);
		config(['database.connections.mysql.password' 	=> $system->password]);
		config(['database.connections.mysql.prefix' 	=> $system->prefix]);
		
		DB::reconnect();
	}
	
	/**
	 * 动态改变数据库配置重连回布尔懒人工具包的数据库
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access    	public
	 * @param 		App\Repositories\BlkSystemRepository 	$system 	//要重连的系统
	 * @return 		void
	 */
	public function reconnectBlkDB()
	{
		config(['database.connections.mysql.host' 		=> env('DB_HOST')]);
		config(['database.connections.mysql.port' 		=> env('DB_PORT')]);
		config(['database.connections.mysql.database' 	=> env('DB_DATABASE')]);
		config(['database.connections.mysql.username' 	=> env('DB_USERNAME')]);
		config(['database.connections.mysql.password' 	=> env('DB_PASSWORD')]);
		config(['database.connections.mysql.prefix' 	=> env('DB_PREFIX')]);
		
		DB::reconnect();
	}
	
	/**
     * 生成用户组授权数据
     *
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @return  	void
     */
    public function createPermissions()
    {
    	$callback = $this->createPermissionsDo();
		
		echo json_encode($callback);
    }
	
	protected function createPermissionsDo()
	{
		$data = BlkFunctionPageRepository::where('system_id', request()->system_id)
					//->where('function_type', 1) 			//function_type = 1 取的所有"系统菜单"的页面记录
					->get();
		if($data->count()){
			$data = $data->toArray();
			
			//要生成菜单的系统
			$system = BlkSystemRepository::where('id', request()->system_id)->first();
			
			//根据系统数据中的数据库信息动态改变数据库配置重连数据库
			$this->reconnectDB($system);
			
			//清除菜单表中已有的数据
			DB::table('blk_permissions')->truncate();
			
			//将"BlkFunctionPageRepository"中查询到的数据转换为blk_menu表的数据并插入
			$permissions = [];
			foreach($data as $k=>$v){
				$permissions[$k] = [
					'id' 	=> $v['id'],
					'title' => $v['title'],
					'pid' 	=> $v['pid'],
					'url' 	=> $v['url']?$v['url']:NULL,
					'model' => $v['model'],
				];
			}
			
			$result = DB::table('blk_permissions')->insert($permissions);
			
			//将数据库重连回boolean lazykit
			$this->reconnectBlkDB();
			
			if($result){
				$callback = ['code' => 0, 'msg' => "可授权页面生成成功", 'refresh' => 'no'];
			}else{
				$callback = ['code' => 1, 'msg' => "可授权页面生成失败", 'refresh' => 'no'];
			}
		}else{
			$callback = ['code' => 1, 'msg' => "没有可生成的授权页面", 'refresh' => 'no'];
		}
		
		return $callback;
	}
	
	/**
     * 生成系统菜单
     *
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @return  	void
     */
    public function createMenu()
    {
    	$callback = $this->createMenuDo();
    	
    	echo json_encode($callback);
    }
	
	protected function createMenuDo()
	{
		$data = BlkFunctionPageRepository::where('system_id', request()->system_id)
					->where('function_type', 1) 			//function_type = 1 取的所有"系统菜单"的页面记录
					->get();
		
		$result = false;
		if($data->count()){
			$data = $data->toArray();
			
			//要生成菜单的系统
			$system = BlkSystemRepository::where('id', request()->system_id)->first();
			
			//根据系统数据中的数据库信息动态改变数据库配置重连数据库
			$this->reconnectDB($system);
			
			//清除菜单表中已有的数据
			//DB::connection()->enableQueryLog();
			DB::table('blk_menu')->truncate();
			//dd(DB::getQueryLog());
			
			//将"BlkFunctionPageRepository"中查询到的数据转换为blk_menu表的数据并插入
			$menu = [];
			foreach($data as $k=>$v){
				$menu[$k] = [
					'id' 	=> $v['id'],
					'title' => $v['title'],
					'pid' 	=> $v['pid'],
					'url' 	=> $v['url']?$v['url']:NULL,
				];
			}
			
			$result = DB::table('blk_menu')->insert($menu);
			
			//将数据库重连回boolean lazykit
			$this->reconnectBlkDB();
		}
		
		if($result){
			$callback = ['code' => 0, 'msg' => "菜单生成成功", 'refresh' => 'no'];
		}else{
			$callback = ['code' => 1, 'msg' => "菜单生成失败", 'refresh' => 'no'];
		}
		
		return $callback;
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
		$callback = $this->createRouteDo();
		
		echo json_encode($callback);
	}
	
	protected function createRouteDo()
	{
		//获得系统信息
		$system = BlkSystemRepository::where('id', request()->system_id)->first();
		
		//获得当前系统对应的各类路径
		$path = $this->getPath($system);
		
		//获得菜单中要生成的路由
		$data = BlkFunctionPageRepository::orderBy('module_id', 'asc')
					->where('system_id', $system->id)
					->where('method', '!=', '')
					->get();
		if($data->count()){
			$data = $data->toArray();
			
			$data_arr = [];
			foreach($data as $k=>$v){
				$data_arr[$v['middleware']][] = $v;
			}
			
			$route = "<?php		
/*
|--------------------------------------------------------------------------
| Datatable Routes
|--------------------------------------------------------------------------
| 此路由文件由布尔懒人工具包自动生成，包含DataTable生成器相关路由
| 生成日期：".date('Y-m-d H:i:s', time())."
| 注    意：请不要在此文件手写路由
*/".PHP_EOL;
		
			foreach($data_arr as $key=>$value){
				//获得中间件
				$middleware = BlkMiddlewareRepository::whereIn('id',explode(',',$key))->get();
				$data = [];
				if($middleware->count()){
					$middleware = $middleware->toArray();
					foreach($middleware as $k=>$v){
						$data[] = "'".$v['key']."'";
					}
				}
				
				$route .= "Route::group(['middleware' => [".join(',', $data)."]], function(){".PHP_EOL;
				//dd($data);
				foreach($value as $k=>$v){
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
						//删除没有对应模块跟系统的菜单
						//BlkMenuRepository::where('id',$v['id'])->delete();
					}
				}
				//dd($route);
				$route .= '});';
			}
			create_dir($path['route']);
			$route_path = $path['route'].'blk.php';
			//dd($route_path);
			file_put_contents($route_path, $route);
			
			$callback = ['code' => 0, 'msg' => "路由文件更新成功", 'refresh' => 'no'];			
		}else{
			$callback = ['code' => 1, 'msg' => "没有要生成的路由", 'refresh' => 'no'];
		}
		//dd($data_arr);
		
		
		
		return $callback;
	}
	
	/**
	 * 生成路由、菜单、权限
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @return  	void
	 */
	public function createRouteMenuPermissions()
	{
		$callback = $this->createRouteDo();
		$callback = $this->createMenuDo();
		$callback = $this->createPermissionsDo();
		
		//将数据库重连回boolean lazykit
		$this->reconnectBlkDB();
	}
}
