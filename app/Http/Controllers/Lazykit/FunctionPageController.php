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
use App\Repositories\FunctionPageRepository;
use App\Repositories\MiddlewareRepository;
use App\Repositories\ModuleRepository;
use App\Repositories\SystemRepository;
use App\Repositories\MenuRepository;
use App\Repositories\AttributeRepository;
use App\Repositories\AutoGenerateRepository;
use App\Http\Controllers\Lazykit\SetDic;
use App\Http\Controllers\Lazykit\SystemPath;
use App\Http\Controllers\Lazykit\ChartDic;

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
	 * 统计图表
	 */
	use ChartDic;
	
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
					'url' 		=> $route_message['route_path'].$route_message['route_name'],
				];
				
				//附加的修改数据
				$additional_config['update_param'] = [
					'url' => $route_message['route_path'].$route_message['route_name'],
				];
			}
		}
		$additional_config['create_param']['system_id'] = $request->system_id;
		
		create_datatable('datatable_1', $additional_config, $request);
	}
	
	/**
	 * 获得"buer_function_page"表中的路由信息，并判断类跟方法是否存在
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param 		integer 	$datatable_arr 			菜单信息
	 * @return  	array
	 */
	public function getRouteMessage($datatable_arr, $path)
	{
		//获得控制器及方法名称
		$module_path = ModuleRepository::where('id', $datatable_arr['module_id'])->first(['module']);
		
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
				
				$route_arr['controller_exists'] = false;
				$route_arr['method_exists'] = false;
				
				error_reporting(0);
				if(file_exists($class_path)){
					//只要类文件存则就默认为类存在,避免因判断类不存在而覆盖用户代码
					$route_arr['controller_exists'] = true;
					include_once($class_path);
					if(class_exists($class)){
						if(method_exists(new $class, $route_arr['method'])){
							$route_arr['method_exists'] = true;
						}else{
							$route_arr['method_exists'] = false;
						}
					}
				}
				error_reporting(E_ALL);
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
		$function_page = FunctionPageRepository::where('id', $request->design_id)->first();
		
		//判断当前页面是否已有配置
		if($function_page){
			$function_page = $function_page->toArray();
			
			//判断当前页面是存在对应的模型
			$module = ModuleRepository::where('id', $function_page['module_id'])->first();
			if($module){
				//判断当前页面是存在对应的系统
				$system = SystemRepository::where('id', $function_page['system_id'])->first();
				if($system){
					$path = $this->getPath($system);
					
					//去除不需要记录在配置中的页面设计中的字段
					unset($function_page['created_at']);
					unset($function_page['updated_at']);
					unset($function_page['deleted_at']);
				}else{
					return view('booleanTools.msg', [
						'msg' => "当前页面没有对应的系统！"
					]);
				}
			}else{
				return view('booleanTools.msg', [
					'msg' => "当前页面没有对应的系统模块！"
				]);
			}
		}else{
			$function_page = [];
		}
		
		//配置在对应系统中的文件路径
		if(isset($function_page['model'])?$function_page['model']:false){
			$model = $this->getModel($function_page['model']);
			$config_path = $path['brdt'].$model.$function_page['id'].'.json';
		}else{
			return view('booleanTools.msg', [
				'msg' => "当前记录功能模型不存在"
			]);
		}
		
		//获得当前页面设计的路由信息
		$route_message = $this->getRouteMessage($function_page, $path);
				
		//获得datatable配置名称
		if($request->isMethod('post')){
			//创建配置文件目录
			create_dir($path['brdt']);
			
			if(in_array($function_page['model'], [2, 5])){
				$this->datatable_set($function_page, $request, $route_message, $path, $config_path);
			}else if($function_page['model'] == 3){
				$this->chart_set($function_page, $request, $route_message, $path, $config_path);
			}else if($function_page['model'] == 4){
				$this->config_set($function_page, $request, $route_message, $path, $config_path);
			}
			
			return success("操作成功");
		}else{
			if(file_exists($config_path)){
				$config = file_get_contents($config_path);
				$config = json_decode($config, true);
			}else{
				$auto_generate = AutoGenerateRepository::where('function_page_id', $function_page['id'])->first();
				if($auto_generate){
					$config = json_decode($auto_generate['config'], true);
				}else{
					$config = [];
				}
			}
			//dd($config);
			
			//生成控制器及当前配置对应页面的方法
			if(!empty($route_message)){
				//生成控制器及方法
				if(!$route_message['controller_exists']){
					//如果控制器不存在则生成当前配置的控制器及方法
					$this->createController($route_message, $path, $model);
					
					return success('控制器及方法生成成功', '控制器：'.$route_message['controller'].'已生成，控制器方法：'.$route_message['method'].'已生成', url()->full() );
				}
			}
			
			view()->share([
				'function_page' 		=> $function_page,			//页面设计 记录
				'design_id' 			=> $request->design_id,		//页面设计ID
				'system_id' 			=> $request->system_id,		//系统ID
				'route_message' 		=> $route_message, 			//获得路由信息
				'module' 				=> $module, 				//当前配置所在模型
				'system' 				=> $system, 				//当前配置所在系统
			]);
			
			if(in_array($function_page['model'], [2, 5])){
				if($function_page['model'] == 2){
					view()->share([
						'join_type_arr' 		=> $this->joinTypeDic(),								//字典：数据库表连接方式
						'tables' 				=> $this->getTables($system),
						'fixed_column_dic_arr' 	=> $this->fixedColumnDic(),								//字典：固定列的类型
						'field_row_arr' 		=> $this->getFieldRow($function_page, $config, $system),//根据表配置获得字段属
					]);
				}else if($function_page['model'] == 5){
					view()->share([
						'inheritance_datatable_arr' => $this->getInheritanceDatatable($system),		//可继承的数据表格
					]);
				}
				return view('lazykit.datatable.set', [
					'button_style_type_arr' => $this->buttonStyleTypeDic(),					//字典：行按钮样式
					'button_open_type_arr' 	=> $this->buttonOpenTypeDic(),					//字典：按钮打开方式
					'search_conditions_dic_arr' => $this->searchConditionsDic(),			//字典：按钮打开方式
					'head_menu_arr' 		=> $this->headMenu($config, $function_page),	//datatable 头部工具菜单
					'datatable_config' 		=> $config,										//datatable 配置
					// 'function_page' 		=> $function_page,								//页面设计 记录
					// 'design_id' 			=> $request->design_id,							//页面设计ID
					// 'system_id' 			=> $request->system_id,							//系统ID
					// 'route_message' 		=> $route_message, 								//获得路由信息
					// 'module' 				=> $module, 									//当前配置所在模型
					// 'system' 				=> $system, 									//当前配置所在系统
				]);
			}else if($function_page['model'] == '3'){
				return view('lazykit.chart.set', [
					// 'function_page' 		=> $function_page,			//页面设计 记录
					// 'design_id' 			=> $request->design_id,		//页面设计ID
					// 'system_id' 			=> $request->system_id,		//系统ID
					// 'route_message' 		=> $route_message, 			//获得路由信息
					// 'module' 				=> $module, 				//当前配置所在模型
					// 'system' 				=> $system, 				//当前配置所在系统
					'chart_config' 			=> $config,					//chart 配置
					'chart_tpl' 			=> $this->chart('all'),		//统计图表模板
				]);
			}else if($function_page['model'] == '4'){
				return view('lazykit.config.set', [
					'config' 				=> $config,					//chart 配置
					// 'function_page' 		=> $function_page,			//页面设计 记录
					// 'design_id' 			=> $request->design_id,		//页面设计ID
					// 'system_id' 			=> $request->system_id,		//系统ID
					// 'route_message' 		=> $route_message, 			//获得路由信息
					// 'module' 				=> $module, 				//当前配置所在模型
					// 'system' 				=> $system, 				//当前配置所在系统
				]);
			}
		}
	}
	
	/**
	 * 设置菜单模型
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		$datatable_arr  			页面设计记录
	 * @param  		\Illuminate\Http\Request  	$request
	 * @param 		$route_message 				页面设计路由信息
	 * @param 		$path 						当前页面设计对应的各类文件路径
	 * @param 		$config_path 				当前页面设计对应配置文件的路径
	 * @return  	void
	 */
	private function config_set($function_page, $request, $route_message, $path, $config_path)
	{
		//去取配置文件
		if(file_exists($config_path)){
			$config = include($config_path);
			if(!is_array($config)){
				$config = [];
			}
		}else{
			$config = [];
		}
		
		$config['id'] 			= $function_page['id'];
		$config['title'] 		= $function_page['title'];
		$config['url'] 			= $function_page['url'];
		$config['method'] 		= $function_page['method'];
		
		//获得表单提交的配置基本信息数据
		$config_set_from_form = [];
		if($request->config){
			//dd($request->chart_set);
			foreach($request->config['tag'] as $k=>$v){
				if($v){
					$tag = $request->config['tag'][$k];
					$config_set_from_form[$tag]['name'] 	= $request->config['name'][$k];
					$config_set_from_form[$tag]['tag'] 		= $request->config['tag'][$k];
					$config_set_from_form[$tag]['describe'] = $request->config['describe'][$k];
					
					//dd($request->config_fields);
					$field_arr = isset($request->config_fields[$request->config['tag'][$k]])?$request->config_fields[$request->config['tag'][$k]]:[];
					//dd($field_arr);
					$fields = [];
					if($field_arr){
						foreach($field_arr['field'] as $key=>$value){
							$field = $field_arr['field'][$key];
							if($field){
								$fields[$field]['field'] 		= $field;
								$fields[$field]['title'] 		= $field_arr['title'][$key];
								$fields[$field]['sorting'] 		= $field_arr['sorting'][$key]?$field_arr['sorting'][$key]:0;
								$fields[$field]['width'] 		= $field_arr['width'][$key]?$field_arr['sorting'][$key]:'100%';
								$fields[$field]['instructions'] = $field_arr['instructions'][$key];
							}
						}
					}
					
					//字段排序
					$fields = array_sort($fields,'sorting');
					
					foreach($fields as $k1=>$v1){
						//取设置的字段属性,用于表单生成
						$conditions = [
							['design_id', '=', $request->design_id],
							['field', '=', $v1['field']],
						];
						$attribute_arr = AttributeRepository::where($conditions)->first();
						if($attribute_arr){
							$fields[$k1]['attribute'] = json_decode($attribute_arr['attribute'], true);
						}else{
							$fields[$k1]['attribute'] = NULL;
						}
					}
					
					$config_set_from_form[$tag]['fields'] = $fields;
				}
			}
		}
		
		//将表单提交的配置基本信息数据添加到已有配置中
		//$config_set = isset($config['config_set'])?$config['config_set']:false;
		// foreach($config_set_from_form as $k=>$v){
		// 	if(isset($config_set[$k])){
		// 		$config_set[$k] = $v;
		// 	}else{
		// 		$config_set[$k] = $v;
		// 	}
		// }
		//
		$config['config_set'] = $config_set_from_form;
		$config['route'] = [
			'route_path' 	=> $route_message['route_path'],
			'route_name' 	=> $route_message['route_name'],
			'controller' 	=> $route_message['namespace'].'\\'.$route_message['controller'],
			'method' 		=> $route_message['method'],
		];
		//dd($config);
		
		/*$config = '<?php return '.var_export($config, true).';?>'; */
		$config = json_encode($config, JSON_UNESCAPED_UNICODE);
		file_put_contents($config_path, $config);
	}
	
	
	
	/**
	 * 将$array2的元素按照一维键与$array1元素按照一维键合并
	 * 如果$array2中存在同名键，则将$array2对应键的值赋值给$array1
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		array 		$array1
	 * @param 		array 		$array2
	 * @return  	array 		将$array2合并到$array1后的数组
	 */
	private function mergeArray($array1, $array2)
	{
		if(!empty($array2)){
			//dd($array1, $array2);
			foreach($array1 as $k=>$v){
				if(isset($array2[$k])){
					$array2[$k]['fields'] = $this->mergeArray($array1[$k]['fields'], $array2[$k]['fields']);
					$array1[$k] = $array2[$k];
				}
			}
		}
			
		return $array1;
		
	}
	
	/**
	 * 设置菜单模型
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		$datatable_arr  			页面设计记录
	 * @param  		\Illuminate\Http\Request  	$request
	 * @param 		$route_message 				页面设计路由信息
	 * @param 		$path 						当前页面设计对应的各类文件路径
	 * @param 		$config_path 				当前页面设计对应配置文件的路径
	 * @return  	void
	 */
	private function chart_set($function_page, $request, $route_message, $path, $config_path)
	{
		$chart_arr['id'] 			= $function_page['id'];
		$chart_arr['title'] 		= $function_page['title'];
		$chart_arr['id_prefix'] 	= $function_page['id_prefix'];
		$chart_arr['pid'] 			= $function_page['pid'];
		$chart_arr['model'] 		= $function_page['model'];
		$chart_arr['function_type'] = $function_page['function_type'];
		$chart_arr['url'] 			= $function_page['url'];
		$chart_arr['method'] 		= $function_page['method'];
		
		$chart_set = [];
		//表单提交的已经设置的数据
		if($request->chart_set){
			$chart_set = $request->chart_set;
		}
		//新增行
		if($request->chart_add_set){
			$chart_add_set = $request->chart_add_set;
			if($chart_add_set['tag'] && $chart_add_set['title']){
				$chart_set[] = $chart_add_set;
			}
		}
		
		$chart_arr['chart_set'] = $chart_set;
		
		/*$chart_config = '<?php return '.var_export($chart_arr, true).';?>';*/
		$chart_config = json_encode($chart_arr, JSON_UNESCAPED_UNICODE);
		file_put_contents($config_path, $chart_config);
	}
	
	/**
	 * 统计图表属性设置
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		$datatable_arr  			页面设计记录
	 * @param  		\Illuminate\Http\Request  	$request
	 * @param 		$route_message 				页面设计路由信息
	 * @param 		$path 						当前页面设计对应的各类文件路径
	 * @param 		$config_path 				当前页面设计对应配置文件的路径
	 * @return  	void
	 */
	public function chartAttributeSet(Request $request){
		$function_page = FunctionPageRepository::where('id', $request->design_id)->first();
		
		if($function_page){
			$function_page = $function_page->toArray();
			
			//判断当前页面是存在对应的模型
			$module = ModuleRepository::where('id', $function_page['module_id'])->first();
			if($module){
				//判断当前页面是存在对应的系统
				$system = SystemRepository::where('id', $function_page['system_id'])->first();
				if($system){
					$path = $this->getPath($system);
					
					//去除不需要记录在配置中的页面设计中的字段
					unset($function_page['created_at']);
					unset($function_page['updated_at']);
					unset($function_page['deleted_at']);
				}else{
					return view('booleanTools.msg', [
						'msg' => "当前页面没有对应的系统！"
					]);
				}
			}else{
				return view('booleanTools.msg', [
					'msg' => "当前页面没有对应的系统模块！"
				]);
			}
		}
		
		//配置在对应系统中的文件路径
		if(isset($function_page['model'])?$function_page['model']:false){
			$model = $this->getModel($function_page['model']);
			$config_path = $path['brdt'].$model.$function_page['id'].'.json';
		}else{
			return view('booleanTools.msg', [
				'msg' => "当前配置没有对应的页面模型！"
			]);
		}
		
		if(file_exists($config_path)){
			$config = include($config_path);
		}else{
			return view('booleanTools.msg', [
				'msg' => "配置文件不存在！"
			]);
		}
		
		if($request->isMethod('post')){
			if(isset($config['chart_set'][$request->key]['attribute'])?$config['chart_set'][$request->key]['attribute']:false){
				$config['chart_set'][$request->key]['attribute'] = $request->attribute;
			}else{
				$config['chart_set'][$request->key]['attribute'] = [];
			}
			
			//将页面设计对应的统计图表 配置文件保存到数据库
			AutoGenerateRepository::updateOrInsert(
					['function_page_id' => $request->design_id],
					['config' => json_encode($config)]
				);
			
			$chart_config = '<?php return '.var_export($config, true).';?>';
			file_put_contents($config_path, $chart_config);
			
			return success("统计图表属性设置成功");
		}else{
			//获得指定图表的attribute设置
			if(isset($config['chart_set'][$request->key]['attribute'])?$config['chart_set'][$request->key]['attribute']:false){
				$attribute = $config['chart_set'][$request->key]['attribute'];
			}else{
				$attribute = [];
			}
			
			return view('lazykit.chart.attribute_set', [
				'attribute' => $attribute,			//页面设计 记录
				'x' 		=> $this->x(), 			//X轴定位
				'y' 		=> $this->y(), 			//Y轴定位
			]);
		}
	}
	
	/**
	 * 配置文件字段附加属性设置
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		\Illuminate\Http\Request $request
	 * @return  	\Illuminate\Http\Response
	 */
	public function configAttributeSet(Request $request)
	{
		if($request->isMethod('post')){
			$data = $request->post();
			unset($data['_token']);
			
			$conditions = [
				'design_id' => $request->design_id,
				'field' => $request->field,
			];
			
			$param = [
				'field_from' => $request->field_from,
				'attribute' => json_encode($data),
			];
			
			//新增字段属性设置记录，如果已存在，则修改
			$result = AttributeRepository::updateOrInsert($conditions, $param);
			if($result){
				//获得当前页面信息
				$function_page = FunctionPageRepository::where('id', $request->design_id)->first();
				
				//将字段属性设置写入Datatable配置文件
				$system = SystemRepository::where('id', $request->system_id)->first();
				
				if($system){
					$path = $this->getPath($system);
					$config_path = $path['brdt'].$this->getModel($function_page['model']).$request->design_id.'.json';
					
					if(file_exists($config_path)){
						$config = file_get_contents($config_path);
						$config = json_decode($config, true);
						$config['config_set'][$request->field_from]['fields'][$request->field]['attribute'] = $data;
						//dd($config);
						
						//将页面设计对应的统计图表 配置文件保存到数据库
						AutoGenerateRepository::updateOrInsert(
							['function_page_id' => $request->design_id],
							['config' 			=> json_encode($config)]
						);
						
						$config = '<?php return '.var_export($config, true).';?>';
						file_put_contents($config_path,$config);
					}else{
						exception_thrown(1001, '配置文件不存在');
					}
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
		
		$attribute_arr = AttributeRepository::where($conditions)->get();
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
			$attribute['validate'] = json_encode([]);
		}
		
		//dd($attribute);
		view()->share([
			'attribute_arr' 			=> $attribute,						//字段属性
			'validate_dic_arr' 			=> $this->validateDic(),			//字典：验证规则
			'data_input_form_dic_arr' 	=> $this->dataInputFormDic(),		//字典：数据输入方式选择
			//'event_type_dic_arr' 		=> $this->eventTypeDic(),			//字典：事件类型
			//'dic_type_dic_arr' 			=> $this->dicTypeDic(),			//字典：数据字典类型
			//'verify_dic_arr' 			=> $this->verifyDic(),				//字典：数据字典类型
			//'align_dic_arr' 			=> $this->alignDic(),				//字典：单元格排列方式
			'data_source_dic_arr' 		=> $this->dataSourceDic(),			//字典：单元格排列方式
			'request' 					=> $request
		]);
		
		return view('lazykit.config.attribute_set');
	}
	
	/**
	 * 生成数据表格配置
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		$datatable_arr  			页面设计记录
	 * @param  		\Illuminate\Http\Request  	$request
	 * @param 		$route_message 				页面设计路由信息
	 * @param 		$path 						当前页面设计对应的各类文件路径
	 * @param 		$config_path 				当前页面设计对应配置文件的路径
	 * @return  	void
	 */
	private function datatable_set($datatable_arr, $request, $route_message, $path, $config_path){
		//数据源设置
		if(isset($request->main_table)?$request->main_table:false){
			$param = [
				'main_table' 		=> $request->main_table,
				'associated_type' 	=> $request->associated_type,
				'associated_table' 	=> $request->associated_table,
				'external_field' 	=> $request->external_field,
			];
		}else{
			$param = [
				'inheritance' 		=> $request->inheritance,
				'inheritance_note' 	=> $request->inheritance_note,
			];
			
			unset($datatable_arr['main_table']);
			unset($datatable_arr['associated_type']);
			unset($datatable_arr['associated_table']);
			unset($datatable_arr['external_field']);
			unset($datatable_arr['datatable_set']);
		}
		
		if(isset($request->external_field)?$request->external_field:false){
			$param = [
				'external_field' 	=> $request->external_field,
			];
		}
		
		FunctionPageRepository::where('id', '=', $request->design_id)->update($param);
		
		//datatable 字段配置:排序
		$datatable_arr['datatable_set'] = array_sort($request->datatable_set,'sorting');
		foreach($datatable_arr['datatable_set'] as $k=>$v){
			//取设置的字段属性,用于表单生成
			$conditions = [
				['design_id', '=', $datatable_arr['id']],
				['field', '=', $v['field']],
			];
			$attribute_arr = AttributeRepository::where($conditions)->first();
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
		
		//将页面设计对应的datatable 配置文件保存到数据库
		AutoGenerateRepository::updateOrInsert(
			['function_page_id' => $datatable_arr['id']],
			['config' 			=> json_encode($datatable_arr)]
		);
		
		//生成对应系统的改页面设计对应的datatable 配置文件
		unset($datatable_arr['module_id']);
		unset($datatable_arr['system_id']);
		/*$datatable_config = '<?php return '.var_export($datatable_arr, true).';?>';*/
		$datatable_config = json_encode($datatable_arr, JSON_UNESCAPED_UNICODE);
		file_put_contents($config_path, $datatable_config);
		
		//生成主表对应的模型类及验证器类
		if(isset($datatable_arr['main_table'])?$datatable_arr['main_table']:false){
			$this->createRepository($datatable_arr['main_table'], $path);
		}
	}
	
	/**
	 * 获得获得可继承的数据表格
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access    	public
	 * @param 		App\Repositories\SystemRepository 	$system 	//当前操作的系统
	 * @return 		array          	返回可继承的数据表格
	 */
	public function getInheritanceDatatable($system){
		$data = FunctionPageRepository::where('system_id', $system->id)
					->where('model', 2)
					->get();
		if($data->count()){
			$data = $data->toArray();
		}else{
			$data = [];
		}
		//dd($data);
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
	// 	FunctionPageRepository::where('id', '=', $request->id)->update($param);
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
	 * @param 		App\Repositories\SystemRepository 	$system 	//要重连的系统
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
				$this->reconnectBrdtDB();
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
						$this->reconnectBrdtDB();
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
	 * @param 		App\Repositories\SystemRepository 	$system 	//要重连的系统
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
		$this->reconnectBrdtDB();
		
		$tables_arr = [];
		
		foreach($result as $k=>$v){
			$v = object_array($v);
			$table_name = $v['Tables_in_'.$database];
			$tables_arr[] = str_replace($prefix, '', $table_name);
		}
		
		return $tables_arr;
	}
	
	/**
	 * 数据表格字段附加属性设置
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
			$result = AttributeRepository::updateOrInsert($conditions, $param);
			if($result){
				//获得当前页面信息
				$datatable_arr = FunctionPageRepository::where('id', $request->design_id)->first();
				
				//将字段属性设置写入Datatable配置文件
				$system = SystemRepository::where('id', $request->system_id)->first();
				if($system){
					$path = $this->getPath($system);
					$config_path = $path['brdt'].$this->getModel($datatable_arr['model']).$request->design_id.'.json';
					
					if(file_exists($config_path)){
						$datatable_arr = require($config_path);
						$datatable_arr['datatable_set'][$request->field]['attribute'] = $data;
						//dd($datatable_config);
						
						$datatable_config = '<?php return '.var_export($datatable_arr, true).';?>';
						file_put_contents($config_path,$datatable_config);
					}
					
					//将页面设计对应的datatable 配置文件保存到数据库
					AutoGenerateRepository::updateOrInsert(
						['function_page_id' => $request->design_id],
						['config' 			=> json_encode($datatable_arr)]
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
		
		$attribute_arr = AttributeRepository::where($conditions)->get();
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
			'order_type_dic_arr' 		=> $this->orderType(),				//字典：排序方式
			//'dic_type_dic_arr' 			=> $this->dicTypeDic(),			//字典：数据字典类型
			//'verify_dic_arr' 			=> $this->verifyDic(),				//字典：数据字典类型
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
	 * @access 		private
	 * @param 		$model 					页面模型
	 * @return  	string 					页面模型前缀
	 */
	private function getModel($model)
	{
		$data = [
			2 => 'datatable_',
			3 => 'chart_',
			4 => 'config_',
			5 => 'datatable_',
		];
		
		return $model = $data[$model];
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
		$data = FunctionPageRepository::select('id as value', 'title as name', 'pid')
					->where('system_id', request()->system_id)
					->get();
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
	
	/**
	 * module字段的下拉选择
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @return  	array
	 */
	public function attributeModule()
	{
		$data = ModuleRepository::select('id as value', 'module_name as name')
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
		$system = SystemRepository::select('system_name', 'id')->get();
		
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
				
				$module = ModuleRepository::select('module_name', 'id')
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
		$data = SystemRepository::select('id as value', 'system_name as name')->get();
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
			['value' => 2, 		'name' => '数据表格按钮'],
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
		$function_page = FunctionPageRepository::get();
		
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
		$datatable_config = get_boolean_tools_config('datatable_'.$request->design_id);
		echo "<style>
				body{margin:0;}
				.sf-dump{min-height:100%;}
			 </style>";
		dd($datatable_config);
	}
	
	/**
	 * middleware字段的下拉选择
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	public function attributeMiddleware(){
		$middleware = MiddlewareRepository::get();
		
		$data = [];
		if($middleware->count()){
			$middleware = $middleware->toArray();
			foreach($middleware as $k=>$v){
				$data[$k]['name'] 	= $v['key'];
				$data[$k]['value'] 	= $v['id'];
			}
		}
		
		return $data;
	}
}