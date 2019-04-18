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
use App\Repositories\BlkMenuRepository;
use App\Repositories\BlkModuleRepository;
use App\Repositories\BlkSystemRepository;
use App\Repositories\BlkAttributeRepository;
use App\Http\Controllers\Lazykit\SetDic;

class MenuController extends Controller
{
    use SetDic;
	
	/**
     * datatable配置文件存放路径
     * @var 		string
     */
	protected $datatablePath = '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Datatable'.DIRECTORY_SEPARATOR;
	
	/**
	 * datatable配置列表
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		\Illuminate\Http\Request $request
	 * @return  	mixed
	 */
	public function index(Request $request)
    {
    	//新增的时候根据控制器及方法名生成路由
    	if($request->isMethod('post') && ( $request->do == 'create' || $request->do == 'update' ) ){
			$route_message = $this->getRouteMessage($request->post());
			//dd($route_message);
			//自定义请求参数
			if($request->method){
				$request->offsetSet('url', $route_message['route_path'].$route_message['route_name']);
			}
		}
		
		create_datatable('datatable_1', [], $request);
    }
	
	/**
	 * 获得"buer_Blk_datatable"表中的路由信息，并判断类跟方法是否存在
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param 		integer 	$datatable_arr 			菜单信息
	 * @return  	array
	 */
	public function getRouteMessage($datatable_arr)
	{
		//获得控制器路径
		$module_path = BlkModuleRepository::where('id', $datatable_arr['module_id'])->first(['module']);
		//dd($datatable_arr);
		//dd($module_path);
		//只有当控制器方法存在且不为空才能进行以下路由信息的计算并判断控制器是否存在,方法是否存在
		if($datatable_arr['method']){
			$method_arr = explode('@', $datatable_arr['method']);
		
			$route_path = strtolower($module_path['module']).'/'.strtolower(str_replace('Controller','',$method_arr[0])).'/';
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
			$class = $route_arr['namespace'].'\\'.$route_arr['controller'];
			//dd($class);
			if(class_exists($class)){
				$route_arr['controller_exists'] = true;
				if(method_exists(new $class, $route_arr['method'])){
					$route_arr['method_exists'] = true;
				}else{
					$route_arr['method_exists'] = false;
				}
			}else{
				$route_arr['controller_exists'] = false;
				$route_arr['method_exists'] = false;
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
		$datatable_arr = BlkMenuRepository::where('id', $request->id)->first();
		if($datatable_arr){
			$datatable_arr = $datatable_arr->toArray();
		}
		
		unset($datatable_arr['created_at']);
		unset($datatable_arr['updated_at']);
		unset($datatable_arr['deleted_at']);
		
		//获得datatable配置名称
		$datatable_config_name = $this->getDatatableFielName($datatable_arr);
		if($request->isMethod('post')){
			//datatable 字段配置:排序
			$datatable_arr['datatable_set'] = array_sort($request->datatable_set,'sorting');
			//datatable 头部工具菜单:内置(不可更改)
			$datatable_arr['head_menu'] = $request->head_menu;
			//datatable 其他设置
			$datatable_arr['other_set'] = $request->other_set;
			//datatable 路由信息
			$route_message = $this->getRouteMessage($datatable_arr);
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
			//创建按钮的控制其方法
			if(isset($datatable_arr['line_button'])){
				$this->createMethod($datatable_arr['line_button']);
			}
			//dd($method_arr);
			
			//保存datatable 配置文件
			$datatable_config = '<?php return '.var_export($datatable_arr, true).';?>';
			file_put_contents($this->datatablePath.$datatable_config_name.'.php',$datatable_config);
			
			//生成主表对应的模型类及验证器类
			if($datatable_arr['main_table']){
				$this->createRepositoryRequest($datatable_arr['main_table']);
			}
			//生成关联表对应的模型类及验证器类
			if($datatable_arr['associated_table']){
				$this->createRepositoryRequest($datatable_arr['associated_table']);
			}
			
			return success("操作成功");
		}else{
			//根据datatable名称获得模型配置
			$datatable_config = get_datatable_config($datatable_config_name);
			//dd($datatable_config);
			$route_message = $this->getRouteMessage($datatable_arr);
			if(!empty($route_message)){
				//生成控制器及方法
				if(!$route_message['controller_exists']){
					create_controller($route_message);
					$route_message = $this->getRouteMessage($datatable_arr);
					
					return success('控制器及方法生成成功', '控制器：'.$route_message['controller'].'已生成，控制器方法：'.$route_message['method'].'已生成', url()->full() );
				}
			}else{
				return view('datatable.msg', [
					'msg' => "没有指定的控制器及方法"
				]);
			}
			return view('lazykit.datatable.set', [
				'field_row_arr' 		=> $this->getFieldRow($datatable_arr),						//根据表配置获得字段属
				'fixed_column_dic_arr' 	=> $this->fixedColumnDic(),									//字典：固定列的类型
				'button_style_type_arr' => $this->buttonStyleTypeDic(),								//字典：行按钮样式
				'button_open_type_arr' 	=> $this->buttonOpenTypeDic(),								//字典：按钮打开方式
				'join_type_arr' 		=> $this->joinTypeDic(),									//字典：按钮打开方式
				'head_menu_arr' 		=> $this->headMenu($datatable_config, $datatable_arr),		//datatable 头部工具菜单
				'datatable_arr' 		=> $datatable_arr,											//datatable记录
				'datatable_config' 		=> $datatable_config,	
				'datatable_id' 			=> $request->id,
				'tables' 				=> $this->getTables(),
				'route_message' 		=> $route_message, 											//获得路由信息
			]);
		}
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
	public function addModel(Request $request)
	{
		//dd($request->id);
		$param = $request->post();
		unset($param['_token']);
		//DB::connection()->enableQueryLog();
		BlkMenuRepository::where('id', '=', $request->id)->update($param);
		//dd(DB::getQueryLog());
		return success("菜单模型设置成功");
	}
	
	/**
	 * 根据表名称生成模型与验证器
	 * 当配置存在数据表的时候根据数据表生成数据表对应的空模型类及空的验证器类,如果已存在同名文件则不重复生成
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		string 		$tablename 				表名称
	 * @return 		
	 */
	private function createRepositoryRequest($tablename)
	{
		//根据数据库表名称获得要生成的模型的类名称跟文件名
		$hump_name = Str::studly($tablename);
		//dd($hump_name);
		//保存datatable配置的时候判断是否有数据库表,如果有表,生成数据表模型跟验证器
		$path = ['..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Repositories'.DIRECTORY_SEPARATOR, '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Requests'.DIRECTORY_SEPARATOR];
		//foreach(['Repository','Request'] as $k=>$v){
		foreach(['Repository'] as $k=>$v){
			//读取空模型的模板
			$file_path = $path[$k];
			create_dir($file_path);
			$file_name = $file_path.$hump_name.$v.'.php';
			if(!file_exists($file_name)){
				$file = file_get_contents($file_path.'New'.$v.'.php');
				
				//替换空模型模板中的类名称
				$file = str_replace('New',$hump_name,$file);
				$file = str_replace('table_name',$tablename,$file);
				file_put_contents($file_name,$file);
			}
		}
	}
	
	/**
	 * 获得数据表格配置文件名称加路径
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		array 		$datatable_arr 				数据表格记录
	 * @return 		string
	 */
	private function getDatatableFielName($datatable_arr)
	{
		return 'datatable_'.$datatable_arr['id'];
	}
	
	/**
	 * 根据表配置获得字段属性
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		array 		$datatable_arr 			数据表格记录
	 * @param 		array 		$datatable_set_arr 		数据表格配置
	 * @return 		array
	 */
	private function getFieldRow($datatable_arr)
	{
		//获得数据表格配置文件名称
		$datatable_file_name = $this->getDatatableFielName($datatable_arr);
		//datatable配置文件存放路径
		$path = $this->datatablePath.$datatable_file_name.'.php';
		//dd($path);
		if(file_exists($path)){
			$datatable_set_arr = require($path);
		}else{
			$datatable_set_arr = [];
		}
		
		//如果不存在主表,则无数据库字段
		$main_table = $datatable_arr['main_table']?$datatable_arr['main_table']:'';
		$associated_table = $datatable_arr['associated_table']?$datatable_arr['associated_table']:'';
		$external_field = $datatable_arr['external_field']?$datatable_arr['external_field']:'';
		$field_row_arr = $result = $result_2 = $result_3 = [];
		if($main_table){
			//获得数据库表
			$tables_arr = $this->getTables();
			//如果主表在数据库中不存在,则返回空,没有主表,关联表设置无效
			$prefix = config('database.connections.mysql.prefix');
			$database = config('database.connections.mysql.database');
			
			if(in_array($main_table, $tables_arr)){
				//接收参数
				$main_table = $prefix . $main_table;
				// 查询结果 
				$sql = 'SHOW FULL COLUMNS FROM `'.$main_table.'`';
				$result = DB::select($sql);
				//dd($result);
				if(count($result)){
					//将数据表格配置信息与表字段数据合并，数据表格配置如果没有字段部分的数据,则这里不需要执行
					$result = $this->mergeAttribute($datatable_set_arr, $result, 'main_table');
				}
				
				if($associated_table){
					//如果主表在数据库中不存在,则返回空
					if(in_array($associated_table, $tables_arr)){
						$associated_table = $prefix . $associated_table;
						
						// 查询结果
						$sql_2 = 'SHOW FULL COLUMNS FROM `'.$associated_table.'`';
						$result_2 = DB::select($sql_2);
						//dd($result_2);
						if(count($result_2)){
							$result_2 = $this->mergeAttribute($datatable_set_arr, $result_2, 'associated_table');
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
			
			$result_3 = $this->mergeAttribute($datatable_set_arr, $result_3, 'external_field');
			//dump($result_3);
			$result = array_merge($result_3, $result);
		}
		
		//如果没有配置文件则不排序
		if(empty($datatable_set_arr)){
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
	public function mergeAttribute($datatable_set_arr, $result, $field_from)
	{
		//dd($result);
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
			//dd($type);
			
			//如果数据库中已有改字段的配置记录，则将当前记录$v与配置数组合并
			$v['field_from'] = $field_from;		//字段来自主表
			if( isset($datatable_set_arr['datatable_set']) ){
				$datatable_set = $datatable_set_arr['datatable_set'];
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
		//dd($result);
		return $result;
	}
	
	/**
	 * 获得数据库表
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access    	public
	 * @return 		array          	返回数据库表数组
	 */
	public function getTables()
	{
		$prefix = config('database.connections.mysql.prefix');
		$database = config('database.connections.mysql.database');
		
		$result = DB::select('show tables');
		$tables_arr = [];
		//dd($result);
		foreach($result as $k=>$v){
			$v = object_array($v);
			//dd($v);
			$table_name = $v['Tables_in_'.$database];
			$tables_arr[] = str_replace($prefix, '', $table_name);
		}
		//dd($tables_arr);
		
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
			//dd($data);
			
			//验证规则
			if(isset($data['verify'])){
				$verify = [];
				foreach($data['verify'] as $k=>$v){
					if($v == 'on'){
						$verify[] = $k;
					}
				}
				$data['verify'] = join(',',$verify);
			}
			
			$conditions = [
				'datatable_id' => $request->datatable_id,
				'field' => $request->field,
			];
			
			$param = [
				'field_from' => $request->field_from,
				'attribute' => json_encode($data),
			];
			
			//新增字段属性设置记录，如果已存在，则修改
			//DB::connection()->enableQueryLog();
			$result = BlkAttributeRepository::updateOrInsert($conditions, $param);
			//dd(DB::getQueryLog());
			if($result){
				return success("保存成功");
			}else{
				return error("保存失败");
			}
		}
		
		//DB::connection()->enableQueryLog();
		$conditions = [
			['datatable_id', '=', $request->datatable_id],
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
			'url_type_dic_arr' 			=> $this->urlTypeDic(),				//字典：行内链接类型
			'dic_type_dic_arr' 			=> $this->dicTypeDic(),				//字典：数据字典类型
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
	public function attribute_pid()
	{
		$data = BlkMenuRepository::select('id as value', 'title as name', 'pid')->get();
		if($data->count()){
			$data = $data->toArray();
			//转换为树结构
			$tree = new \App\Http\Controllers\Common\TreeController($data);
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
	public function attribute_module()
	{
// 		$data = BlkModuleRepository::select('id as value', 'module_name as name')->get();
// 		if($data->count()){
// 			$data = $data->toArray();
// 		}else{
// 			$data = [];
// 		}
// 		
// 		return $data;
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
				//$data[$k]['condition'] = [$system[$k]['id']];
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
						//$data_module[$k1]['condition'] = [$module[$k1]['id']];
					}
				}
				$data[$k]['children'] = $data_module;
			}
		}
		//dd($data);
		
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
	 * 生成路由
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @return  	json
	 */
	public function createRoute(){
		$data = BlkMenuRepository::orderBy('module_id', 'asc')->get();
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
			$path = base_path('routes'.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'datatable.php');
			//dd($route);
			$route .= '});';
			file_put_contents($path, $route);
			$result = ['code' => 0, 'msg' => "路由文件更新成功"];
		}else{
			$result = ['code' => 1, 'msg' => "没有要生成的路由"];
		}
		return json_encode($result);
	}
	
	/**
	 * model字段的下拉选择
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	public function attribute_model(){
		$data = [
			['value' => '1', 	'name' => '自定义代码'],
			['value' => '2', 	'name' => '数据表格'],
			['value' => '3', 	'name' => '统计图表'],
			['value' => '4', 	'name' => '配置文件'],
		];
		
		return $data;
	}
}