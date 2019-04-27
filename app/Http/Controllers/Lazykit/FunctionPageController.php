<?php
/**
 * datatable配置的生成与相关属性设置
 * @auther 		倒车的螃蟹<yh15229262120@qq.com>
 */
namespace App\Http\Controllers\Lazykit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Repositories\BlkFunctionPageRepository;
use App\Repositories\BlkModuleRepository;
use App\Repositories\BlkSystemRepository;
use App\Repositories\BlkMenuRepository;
use App\Repositories\BlkAttributeRepository;
use App\Repositories\BlkAutoGenerateRepository;
use App\Http\Controllers\Lazykit\SetDic;
use App\Http\Controllers\Lazykit\SystemPath;

class FunctionPageController extends Controller
{
    /**
     * 配置字典
     */
	use SetDic;
	
	/**
	 * 系统所在路径
	 */
	use SystemPath;
	
	/**
	 * 创建路由、菜单、模型、验证器等
	 */
	use Create;
	
	/**
	 * 系统列表
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		\Illuminate\Http\Request $request
	 * @return  	mixed
	 */
	public function index(Request $request)
    {
    	create_datatable('datatable_46', [], $request);
    }
	
	/**
	 * datatable配置列表
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		\Illuminate\Http\Request $request
	 * @return  	mixed
	 */
	public function design(Request $request)
	{
		$additional_config = [
			//数据查询条件
			'conditions' => [
				['system_id', '=', $request->system_id],
			],
		];
		
		//新增的时候如果method（处理方法）字段不为空，则根据控制器及方法名生成路由
		if($request->isMethod('post') && ( $request->do == 'create' || $request->do == 'update' ) ){
			if($request->method){
				$route_message = $this->getRouteMessage($request->post(), []);
				//dd($route_message);
				
				//附加的新增数据
				$additional_config['create_param'] = [
					'url' => $route_message['route_path'].$route_message['route_name'],
				];
				
				//附加的修改数据
				$additional_config['update_param'] = [
					'url' => $route_message['route_path'].$route_message['route_name'],
				];
			}
			$additional_config['create_param']['system_id'] = $request->system_id;
		}
		
		create_datatable('datatable_1', $additional_config, $request);
	}
	
	/**
	 * 获得"buer_Blk_datatable"表中的路由信息，并判断类跟方法是否存在
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param 		integer 	$datatable_arr 			菜单信息
	 * @return  	array
	 */
	public function getRouteMessage($datatable_arr, $path)
	{
		//dd($datatable_arr);
		//获得控制器及方法名称
		$module_path = BlkModuleRepository::where('id', $datatable_arr['module_id'])->first(['module']);
		//dd($datatable_arr);
		//dd($module_path);
		//只有当控制器方法存在且不为空才能进行以下路由信息的计算并判断控制器是否存在,方法是否存在
		if($datatable_arr['method']){
			$method_arr = explode('@', $datatable_arr['method']);
		
			$route_path = strtolower($module_path['module']).'/'.\Illuminate\Support\Str::snake(str_replace('Controller','',$method_arr[0])).'/';
			//dd($route_path);
			$route_arr = [
				'id' 			=> isset($datatable_arr['id'])?$datatable_arr['id']:'',
				'route_path' 	=> $route_path,
				'route_name' 	=> \Illuminate\Support\Str::snake($method_arr[1]),
				'namespace' 	=> 'App\Http\Controllers\\'.$module_path['module'],
				'controller' 	=> $method_arr[0],
				'method' 		=> $method_arr[1],
				'module' 		=> $module_path['module'],
				'menu_title' 	=> $datatable_arr['title'],
			];
			
			if($path){
				$class_path = $path['controller'].$module_path['module'].'\\'.$route_arr['controller'].'.php';
				$class = $route_arr['namespace'].'\\'.$route_arr['controller'];
				//dd($class_path, $class);
				
				$route_arr['controller_exists'] = false;
				$route_arr['method_exists'] = false;
				
				if(file_exists($class_path)){
					include_once($class_path);
					if(class_exists($class)){
						$route_arr['controller_exists'] = true;
						if(method_exists(new $class, $route_arr['method'])){
							$route_arr['method_exists'] = true;
						}else{
							$route_arr['method_exists'] = false;
						}
					}
				}
			}
		}else{
			$route_arr = [];
		}
		
		return $route_arr;
	}
	
	/**
	 * datatable生成器
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @return  	\Illuminate\Http\Response
	 */
	public function set()
	{
		$request = request();
		
		//dd($request->id);
		$datatable_arr = BlkFunctionPageRepository::where('id', $request->design_id)->first();
		//dd($datatable_arr);
		if($datatable_arr){
			$datatable_arr = $datatable_arr->toArray();
			
			//判断当前页面是存在对应的模型
			$module = BlkModuleRepository::where('id', $datatable_arr['module_id'])->first();
			if($module){
				//判断当前页面是存在对应的系统
				$system = BlkSystemRepository::where('id', $datatable_arr['system_id'])->first();
				if($system){
					$path = $this->getPath($system);
					
					//去除不需要记录在配置中的页面设计中的字段
					unset($datatable_arr['created_at']);
					unset($datatable_arr['updated_at']);
					unset($datatable_arr['deleted_at']);
				}else{
					die("当前页面没有对应的系统模块！");
				}
			}else{
				die("当前页面没有对应的系统模块！");
			}
		}else{
			$datatable_arr = [];
		}
		//dd($path);
		
		//配置在对应系统中的文件路径
		if($datatable_arr['model']){
			$model = [
				2 => 'datatable',
				3 => 'chart',
				4 => 'config',
				5 => 'datatable',
			];
			$datatable_config_path = $path['datatable'].$model[$datatable_arr['model']].'_'.$datatable_arr['id'].'.php';
		}else{
			die("当前记录功能模型不存在！");
		}
		//dd($datatable_config_path);
		
		//获得当前页面设计的路由信息
		$route_message = $this->getRouteMessage($datatable_arr, $path);
				
		//获得datatable配置名称
		//$datatable_config_name = $this->getDatatableFielName($datatable_arr);
		if($request->isMethod('post')){
			//数据源设置
			BlkFunctionPageRepository::where('id', '=', $request->id)->update($param);
			
			//datatable 字段配置:排序
			$datatable_arr['datatable_set'] = array_sort($request->datatable_set,'sorting');
			foreach($datatable_arr['datatable_set'] as $k=>$v){
				//取设置的字段属性,用于表单生成
				$conditions = [
					['design_id', '=', $datatable_arr['id']],
					['field', '=', $v['field']],
				];
				$attribute_arr = BlkAttributeRepository::where($conditions)->first();
				if($attribute_arr){
					$datatable_arr['datatable_set'][$k]['attribute'] = json_decode($attribute_arr['attribute'], true);
				}else{
					$datatable_arr['datatable_set'][$k]['attribute'] = NULL;
				}
			}
			
			//datatable 头部工具菜单:内置(不可更改)
			$datatable_arr['head_menu'] = $request->head_menu;
			//datatable 其他设置
			$datatable_arr['other_set'] = $request->other_set;
			
			$datatable_arr['route'] = [
				'route_path' 	=> $route_message['route_path'],
				'route_name' 	=> $route_message['route_name'],
				'controller' 	=> $route_message['namespace'].'\\'.$route_message['controller'],
				'method' 		=> $route_message['method'],
			];
			//datatable 左侧目录树
			if(isset($request->directory['has'])){
				$datatable_arr['directory'] = $request->directory;
			}
			
			//datatable 附加工具菜单
			$datatable_arr['new_head_menu'] = $request->new_head_menu_list;
			if(isset($request->new_head_menu['type'])){
				//dd($request->new_head_menu_list);
				foreach($request->new_head_menu['type'] as $k=>$v){
					if($v){
						$datatable_arr['new_head_menu'][$v] = [
							'text' 		=> $request->new_head_menu['text'][$k],
							'icon' 		=> $request->new_head_menu['icon'][$k],
							'open_tepe' => $request->new_head_menu['open_tepe'][$k],
							'must' 		=> isset($request->new_head_menu['must'][$k])?$request->new_head_menu['must'][$k]:'',
							'width' 	=> $request->new_head_menu['width'][$k],
							'height' 	=> $request->new_head_menu['height'][$k],
							'method' 	=> $request->new_head_menu['method'][$k],
							//'route' 	=> \Illuminate\Support\Str::snake($request->new_head_menu['method'][$k]),
						];
					}
				}
			}
			
			//创建按钮的控制器方法[未实现]
			if(isset($datatable_arr['new_head_menu'])){
				$this->createMethod($datatable_arr['new_head_menu']);
			}
			//dd($datatable_arr['new_head_menu']);
			
			//datatable 附加工具菜单
			$datatable_arr['line_button'] = $request->line_button_list;
			if(isset($request->line_button['type'])){
				foreach($request->line_button['type'] as $k=>$v){
					if($v){
						$datatable_arr['line_button'][$v] = [
							'text' 		=> $request->line_button['text'][$k],
							'style' 	=> $request->line_button['style'][$k],
							'open_tepe' => $request->line_button['open_tepe'][$k],
							'must' 		=> isset($request->line_button['must'][$k])?$request->line_button['must'][$k]:'',
							'width' 	=> $request->line_button['width'][$k],
							'height' 	=> $request->line_button['height'][$k],
							'method' 	=> $request->line_button['method'][$k],
							//'route' 	=> \Illuminate\Support\Str::snake($request->line_button['method'][$k]),
						];
					}
				}
			}
			
			//创建按钮的控制器方法
// 			if(isset($datatable_arr['line_button'])){
// 				$this->createMethod($datatable_arr['line_button']);
// 			}
			//dd($method_arr);
			
			//将页面设计对应的datatable 配置文件保存到数据库
			BlkAutoGenerateRepository::updateOrInsert(
					['function_page_id' => $datatable_arr['id']],
					['config' => json_encode($datatable_arr)]
				);
			
			//生成对应系统的改页面设计对应的datatable 配置文件
			unset($datatable_arr['module_id']);
			unset($datatable_arr['system_id']);
			$datatable_config = '<?php return '.var_export($datatable_arr, true).';?>';
			file_put_contents($datatable_config_path,$datatable_config);
			
			//生成主表对应的模型类及验证器类
			if($datatable_arr['main_table']){
				$this->createRepository($datatable_arr['main_table'], $path);
			}
			//生成关联表对应的模型类及验证器类
// 			if($datatable_arr['associated_table']){
// 				$this->createRequest($datatable_arr['associated_table']);
// 			}
			
			return success("操作成功");
		}else{
			if(file_exists($datatable_config_path)){
				$datatable_config = require($datatable_config_path);
			}else{
				$auto_generate = BlkAutoGenerateRepository::where('function_page_id', $datatable_arr['id'])->first();
				//dd($datatable_config_path);
				if($auto_generate){
					$datatable_config = json_decode($auto_generate['config'], true);
				}else{
					$datatable_config = [];
				}
			}
			//dd($datatable_config);
			
			//生成控制器及当前配置对应页面的方法
			if(!empty($route_message)){
				//生成控制器及方法
				if(!$route_message['controller_exists']){
					//如果控制器不存在则生成当前数据表格的控制器及方法
					$this->create_controller($route_message, $path);
					
					return success('控制器及方法生成成功', '控制器：'.$route_message['controller'].'已生成，控制器方法：'.$route_message['method'].'已生成', url()->full() );
				}
			}else{
				return view('datatable.msg', [
					'msg' => "没有指定的控制器及方法"
				]);
			}
			
			//dd($datatable_arr);
			if($datatable_arr['model'] == 2){
				view()->share([
					'join_type_arr' 		=> $this->joinTypeDic(),								//字典：数据库表连接方式
					'tables' 				=> $this->getTables($system),
					'fixed_column_dic_arr' 	=> $this->fixedColumnDic(),								//字典：固定列的类型
					'field_row_arr' 		=> $this->getFieldRow($datatable_arr, $datatable_config, $system),	//根据表配置获得字段属
				]);
			}else if($datatable_arr['model'] == 5){
				view()->share([
					'inheritance_datatable_arr' 	=> $this->getInheritanceDatatable($system),		//可继承的数据表格
				]);
			}
			return view('lazykit.datatable.set', [
				'button_style_type_arr' => $this->buttonStyleTypeDic(),							//字典：行按钮样式
				'button_open_type_arr' 	=> $this->buttonOpenTypeDic(),							//字典：按钮打开方式
				'search_conditions_dic_arr' => $this->searchConditionsDic(),					//字典：按钮打开方式
				'head_menu_arr' 		=> $this->headMenu($datatable_config, $datatable_arr),	//datatable 头部工具菜单
				'datatable_arr' 		=> $datatable_arr,										//datatable 记录
				'datatable_config' 		=> $datatable_config,									//datatable 配置
				'design_id' 			=> $request->design_id,									//页面设计ID
				'system_id' 			=> $request->system_id,									//系统ID
				'route_message' 		=> $route_message, 										//获得路由信息
				'module' 				=> $module, 											//当前配置所在模型
				'system' 				=> $system, 											//当前配置所在系统
			]);
		}
	}
	
	/**
	 * 获得获得可继承的数据表格
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access    	public
	 * @param 		App\Repositories\BlkSystemRepository 	$system 	//当前操作的系统
	 * @return 		array          	返回可继承的数据表格
	 */
	public function getInheritanceDatatable($system){
		$data = BlkFunctionPageRepository::where('system_id', $system->id)
					->where('model', 2)
					->get();
		if($data->count()){
			$data = $data->toArray();
		}else{
			$data = [];
		}
		
		return $data;
	}
	
	//生成行按钮的控制器方法
	public function createMethod($anniu_config){
		foreach($anniu_config as $v){
			//$v['method']
		}
	}
	
	/**
	 * 设置菜单模型
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		\Illuminate\Http\Request  $request
	 * @return  	\Illuminate\Http\Response
	 */
	// public function addModel(Request $request)
	// {
	// 	//dd($request->id);
	// 	$param = $request->post();
	// 	unset($param['_token']);
	// 	//DB::connection()->enableQueryLog();
	// 	BlkFunctionPageRepository::where('id', '=', $request->id)->update($param);
	// 	//dd(DB::getQueryLog());
	// 	return success("数据源设置成功");
	// }
	
	/**
	 * 根据表配置获得字段属性
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		array 		$datatable_arr 			数据表格记录
	 * @param 		array 		$datatable_config 		数据表格配置
	 * @param 		App\Repositories\BlkSystemRepository 	$system 	//要重连的系统
	 * @return 		array
	 */
	private function getFieldRow($datatable_arr, $datatable_config, $system)
	{
		//如果不存在主表,则无数据库字段
		$main_table = $datatable_arr['main_table']?$datatable_arr['main_table']:'';
		$associated_table = $datatable_arr['associated_table']?$datatable_arr['associated_table']:'';
		$external_field = $datatable_arr['external_field']?$datatable_arr['external_field']:'';
		$field_row_arr = $result = $result_2 = $result_3 = [];
		if($main_table){
			//获得数据库表
			$tables_arr = $this->getTables($system);
			//如果主表在数据库中不存在,则返回空,没有主表,关联表设置无效
			$prefix = $system->prefix;
			//$database = config('database.connections.mysql.database');
			
			if(in_array($main_table, $tables_arr)){
				//接收参数
				$main_table = $prefix . $main_table;
				// 查询结果 
				$sql = 'SHOW FULL COLUMNS FROM `'.$main_table.'`';
				$this->reconnectDB($system);
				$result = DB::select($sql);
				$this->reconnectBlkDB();
				//dd($result);
				
				if(count($result)){
					//将数据表格配置信息与表字段数据合并，数据表格配置如果没有字段部分的数据,则这里不需要执行
					$result = $this->mergeAttribute($datatable_config, $result, 'main_table');
				}
				
				if($associated_table){
					//如果主表在数据库中不存在,则返回空
					if(in_array($associated_table, $tables_arr)){
						$associated_table = $prefix . $associated_table;
						
						// 查询结果
						$sql_2 = 'SHOW FULL COLUMNS FROM `'.$associated_table.'`';
						$this->reconnectDB($system);
						$result_2 = DB::select($sql_2);
						$this->reconnectBlkDB();
						//dd($result_2);
						
						if(count($result_2)){
							$result_2 = $this->mergeAttribute($datatable_config, $result_2, 'associated_table');
							//dump($result_2);
							
							//将主表字段属性跟关联表字段属性数组合并
							$result = array_merge($result, $result_2);
						}
					}
				}
			}
		}
		
		//自定义字段
		if($external_field){
			//自定义字段以逗号隔开,处理成逗号不区分中文逗号跟英文逗号
			$external_field = str_replace('，', ',', $external_field);
			$external_field_arr = explode(',', $external_field);
			foreach($external_field_arr as $v){
				$result_3[] = [
					'Field' 		=> $v,
					'Comment' 	=> '',
				];
			}
			
			$result_3 = $this->mergeAttribute($datatable_config, $result_3, 'external_field');
			//dump($result_3);
			$result = array_merge($result_3, $result);
		}
		
		//如果没有配置文件则不排序
		if(empty($datatable_config)){
			$field_row_arr = $result;
		}else{
			$field_row_arr = array_sort($result,'sorting');
		}
		
		//dd($field_row_arr);
		return $field_row_arr;
	}
	
	/**
	 * 获得Datatable字段属性
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access    	public
	 * @return 		array          	返回Datatable字段属性
	 */
	public function mergeAttribute($datatable_config, $result, $field_from)
	{
		foreach($result as $k=>$v){
			$v = object_array($v);
			
			if(isset($v['Type'])){
				$type = explode('(',str_replace(')', '', $v['Type']));
				if($type[0]){
					$v['field_type'] = $type[0];		//字段类型
				}
				if(isset($type[1])){
					$v['field_length'] = $type[1];		//字段长度
				}else{
					$v['field_length'] = 'no_limit';	//不限长度
				}
			}
			
			//如果数据库中已有改字段的配置记录，则将当前记录$v与配置数组合并
			$v['field_from'] = $field_from;
			if( isset($datatable_config['datatable_set']) ){
				$datatable_set = $datatable_config['datatable_set'];
				if(isset($v['Field'])?isset($datatable_set[$v['Field']]):false){
					//将created_at、updated_at、deleted_at三个功能性字段放到队尾
					if(in_array($v['Field'],["created_at", "updated_at", "deleted_at"])){
						$datatable_set[$v['Field']]['sorting'] = 999;
					}
					unset($datatable_set[$v['Field']]['field_from']);
					if($datatable_set[$v['Field']]){
						$result[$k] = array_merge($v, $datatable_set[$v['Field']]);
					}else{
						$result[$k] = $v;
					}
				}else{
					$result[$k] = $v;
				}
			}else{
				$result[$k] = $v;
			}
		}
		
		return $result;
	}
	
	/**
	 * 获得数据库表
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access    	public
	 * @param 		App\Repositories\BlkSystemRepository 	$system 	//要重连的系统
	 * @return 		array          	返回数据库表数组
	 */
	public function getTables($system)
	{
		$prefix = $system->prefix;
		$database = $system->database;
		
		//动态改变数据库配置重连数据库
		$this->reconnectDB($system);
		
		$result = DB::select('show tables');
		
		//将数据库重连回boolean lazykit
		$this->reconnectBlkDB();
		
		$tables_arr = [];
		
		foreach($result as $k=>$v){
			$v = object_array($v);
			$table_name = $v['Tables_in_'.$database];
			$tables_arr[] = str_replace($prefix, '', $table_name);
		}
		
		return $tables_arr;
	}
	
	/**
	 * 字段附加属性设置
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		\Illuminate\Http\Request $request
	 * @return  	\Illuminate\Http\Response
	 */
	public function attributeSet(Request $request)
	{
		if($request->isMethod('post')){
			$data = $request->post();
			unset($data['_token']);
			
			//单元格事件对应的行为是否为路由,如果是,生成路由键值
			if(Str::contains($data['event_behavior'], '@')){
				$arr = explode('@',$data['event_behavior']);
				$data['event_route'] = '/'.$arr['1'];
			}
			
			$conditions = [
				'design_id' => $request->design_id,
				'field' => $request->field,
			];
			
			$param = [
				'field_from' => $request->field_from,
				'attribute' => json_encode($data),
			];
			
			//新增字段属性设置记录，如果已存在，则修改
			$result = BlkAttributeRepository::updateOrInsert($conditions, $param);
			if($result){
				//获得当前页面信息
				$datatable_arr = BlkFunctionPageRepository::where('id', $request->design_id)->first();
				
				//将字段属性设置写入Datatable配置文件
				$system = BlkSystemRepository::where('id', $request->system_id)->first();
				
				if($system){
					$path = $this->getPath($system);
					
					$model = [
						2 => 'datatable',
						3 => 'chart',
						4 => 'config',
						5 => 'datatable',
					];
					$datatable_config_path = $path['datatable'].$model[$datatable_arr['model']].'_'.$request->design_id.'.php';
					
					if(file_exists($datatable_config_path)){
						$datatable_arr = require($datatable_config_path);
						$datatable_arr['datatable_set'][$request->field]['attribute'] = $data;
						//dd($datatable_config);
						
						$datatable_config = '<?php return '.var_export($datatable_arr, true).';?>';
						file_put_contents($datatable_config_path,$datatable_config);
					}
					
					//将页面设计对应的datatable 配置文件保存到数据库
					BlkAutoGenerateRepository::updateOrInsert(
							['function_page_id' => $request->design_id],
							['config' => json_encode($datatable_arr)]
						);
				}
				
				return success("保存成功");
			}else{
				return error("保存失败");
			}
		}
		
		//DB::connection()->enableQueryLog();
		$conditions = [
			['design_id', '=', $request->design_id],
			['field', '=', $request->field],
		];
		
		$attribute_arr = BlkAttributeRepository::where($conditions)->get();
		if($attribute_arr->first()){
			$attribute_arr = $attribute_arr->toArray();
			$attribute = json_decode($attribute_arr[0]['attribute'], true);
		}else{
			$attribute = [];
		}
		//dd(DB::getQueryLog());
		//dd($attribute_arr);
		
		//获得验证类型
		$validate = isset($attribute['validate'])?explode(',',$attribute['validate']):[];
		if($validate){
			$attribute['validate'] = json_encode($validate);
		}else{
			//没有验证规则，返回一个空的json
			$attribute['validate'] = '{}';
		}
		
		//dd($attribute);
		view()->share([
			'attribute_arr' 			=> $attribute,						//字段属性
			'validate_dic_arr' 			=> $this->validateDic(),			//字典：验证规则
			'data_input_form_dic_arr' 	=> $this->dataInputFormDic(),		//字典：数据输入方式选择
			'event_type_dic_arr' 		=> $this->eventTypeDic(),			//字典：事件类型
			//'dic_type_dic_arr' 			=> $this->dicTypeDic(),			//字典：数据字典类型
			'verify_dic_arr' 			=> $this->verifyDic(),				//字典：数据字典类型
			'align_dic_arr' 			=> $this->alignDic(),				//字典：单元格排列方式
			'data_source_dic_arr' 		=> $this->dataSourceDic(),			//字典：单元格排列方式
			'request' 					=> $request
		]);
		
		return view('lazykit.datatable.attribute_set');
	}
	
	/**
	 * pid字段的下拉选择
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @return  	array
	 */
	public function attributePid()
	{
		$data = BlkFunctionPageRepository::select('id as value', 'title as name', 'pid')
					->where('system_id', request()->system_id)
					->get();
		if($data->count()){
			$data = $data->toArray();
			//转换为树结构
			$tree = new \App\Http\Controllers\Blk\TreeController($data);
			$data = $tree->listToSelectTree();
		}else{
			$data = [];
		}
		
		return $data;
	}
	
	/**
	 * module字段的下拉选择
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @return  	array
	 */
	public function attributeModule()
	{
		$data = BlkModuleRepository::select('id as value', 'module_name as name')
					->where('system_id', request()->system_id)
					->get();
		if($data->count()){
			$data = $data->toArray();
		}else{
			$data = [];
		}
		
		return $data;
	}
	
	/**
	 * 左侧目录
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @return  	array
	 */
	public function leftDirectory()
	{
		$system = BlkSystemRepository::select('system_name', 'id')->get();
		
		$data = [];
		
		if($system->count()){
			$system = $system->toArray();
			//dd($data);
			foreach($system as $k=>$v){
				$data[$k] = $v;
				$data[$k]['name'] = $v['system_name'];
				$data[$k]['value'] = $v['id'];
				//树结构的查询条件
				$data[$k]['condition'] = [$system[$k]['id']];
				$data[$k]['spread'] = 'true';
				
				$module = BlkModuleRepository::select('module_name', 'id')
							->where('system_id', $v['id'])
							->get();
							
				$data_module = [];
				
				if($module->count()){
					$module = $module->toArray();
					//dd($data);
					foreach($module as $k1=>$v1){
						$data_module[$k1] = $v1;
						$data_module[$k1]['name'] = $v1['module_name'];
						$data_module[$k1]['value'] = $v1['id'];
						$data_module[$k1]['condition'] = [$module[$k1]['id']];
					}
				}
				$data[$k]['children'] = $data_module;
			}
		}
		//dd($data);
		
		return $data;
	}
	
	/**
	 * function_type字段的下拉选择
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	public function attributeSystem(){
		$data = BlkSystemRepository::select('id as value', 'system_name as name')->get();
		if($data->count()){
			$data = $data->toArray();
		}else{
			$data = [];
		}
		
		return $data;
	}
	
	
	/**
	 * function_type字段的下拉选择
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	public function attributeFunctionType(){
		$data = [
			['value' => 1, 		'name' => '系统菜单'],
			['value' => 2, 		'name' => '内页按钮'],
			['value' => 3, 		'name' => '路由'],
		];
		
		return $data;
	}
	
	/**
	 * model字段的下拉选择
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	public function attributeModel(){
		$data = [
			['value' => 0, 	'name' => '无'],
			['value' => 1, 	'name' => '自定义代码'],
			['value' => 2, 	'name' => '数据表格'],
			['value' => 3, 	'name' => '统计图表'],
			['value' => 4, 	'name' => '配置文件'],
			['value' => 5, 	'name' => '继承数据表格'],
		];
		
		return $data;
	}
	
	/**
	 * inheritance字段的下拉选择
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	public function attributeInheritance(){
		$function_page = BlkFunctionPageRepository::get();
		
		$data = [];
		if($function_page->count()){
			$function_page = $function_page->toArray();
			foreach($function_page as $k=>$v){
				$data[$k]['name'] = $v['title'].'('.$v['id'].')';
				$data[$k]['value'] = $v['id'];
			}
		}
		
		//dd($data);
		return $data;
	}
	
	public function preview(Request $request){
		$datatable_config = get_datatable_config('datatable_'.$request->design_id);
		echo "<style>
				body{margin:0;}
				.sf-dump{min-height:100%;}
			 </style>";
		dd($datatable_config);
	}
}