<?php
/**
 * DataTable数据表格生成器
 * @auther 		倒车的螃蟹<yh15229262120@qq.com>
 * @param 		$additional_config = [				代码中定义的数据表格附加配置
 */

namespace App\Http\Controllers\Blk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Repositories\BlkAttributeRepository;

class DatatableGenerateController extends Controller
{
	/**
	 * datatable模型, 调用它用助手函数：datatable
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		string     	$datatable_config_name 		配置名称
	 * @param 		array     	$additional_config 			附加配置
	 * @param  		\Illuminate\Http\Request  $request
	 * @return 		mixed
	 */
    public function createDatatable($datatable_config_name, $additional_config = [], $request)
    {
    	//根据datatable名称获得模型配置
    	$datatable_config = $this->getDatatableConfig($datatable_config_name, $additional_config);
    	//dd($datatable_config);
		if(empty($datatable_config)){
			exception_thrown(1001, '配置文件不存在');
		}
		
		if( $request->do == "create") {
			$dom = $this->getDataFieldSet($datatable_config, 'create');
			//dd($dom);
			if($request->isMethod('post')){
				$request->validate([]);
				
				//dd($request->post());
				$param = $this->getAllowField($dom, $request->post());
				//dump($param); die();
				//5、附加的新增数据
				if(isset($additional_config['create_param'])){
					if($additional_config['create_param']){
						foreach($additional_config['create_param'] as $k=>$v){
							$param[$k] = $v;
						}
					}
				}
				
				if(isset($datatable_config['datatable_set']['created_at'])){
					$param['created_at'] = date('Y-m-d H:i:s', time());
				}
				
				//这么直接插入记录created_at
				$datatable_config['modelClass']::insert($param);
				datatable_success("保存成功");
			}
			
			//避免新增与修改使用同样模板页面导致新增时模板变量未定义,给$data_arr中的字段定义空值
			$data_arr = [];
			foreach($dom as $k=>$vo){
				if(in_array($vo['data_input_form'], ['single_photo_upload', 'photos_upload', 'single_file_upload', 'files_upload'])){
					$data_arr[$k] = [];
				}else{
					$data_arr[$k] = '';
				}
			}
			
			view()->share([
				'dom' => $dom,
				'data_arr' => $data_arr,
				'datatable_config' => $datatable_config,		//数据表格配置
				'validate_rules_dic_arr' => $this->validateRulesDic(),
			]);
			
			$content = view($datatable_config['create_page']);
			$template = response($content)->getContent();
			//cache($datatable_config_name, $template);
			echo $template;
		}elseif( $request->do == "update") {
			$dom = $this->getDataFieldSet($datatable_config, 'update');
			if($request->isMethod('post')){
				$request->validate([]);
				
				//dd($request->post());
				$param = $this->getAllowField($dom, $request->post());
				//dump($param); die();
				//6、附加的修改数据
				if(isset($additional_config['create_param'])){
					foreach($additional_config['create_param'] as $k=>$v){
						$param[$k] = $v;
					}
				}
				//dd($param);
				$datatable_config['modelClass']::where('id', $request->id)->update($param);
				//dd(DB::getQueryLog());
				datatable_success("保存成功");
			}
			
			//获得要修改的记录
			$data_arr = $datatable_config['modelClass']::where('id', $request->id)->lockForUpdate()->get();
			if($data_arr->first()){
				$data_arr = $data_arr->first()->toArray();
			}
			//dd($data_arr);
			//处理记录中的特殊格式
			foreach($dom as $key=>$vo){
				//处理layui上传的图片
				if(in_array($vo['data_input_form'], ['single_photo_upload', 'photos_upload', 'single_file_upload', 'files_upload'])){
					if($data_arr[$vo['field']]){
						$data_arr[$vo['field']] = json_decode($data_arr[$vo['field']],true);
					}else{
						$data_arr[$vo['field']] = [];
					}
				}
			}
			//dd($dom);
			view()->share([
				'dom' => $dom,
				'data_arr' => $data_arr,
				'datatable_config' => $datatable_config,		//数据表格配置
				'validate_rules_dic_arr' => $this->validateRulesDic(),
			]);
			
			$content = view($datatable_config['update_page']);
			$template = response($content)->getContent();
			//cache($datatable_config_name, $template);
			echo $template;
		}elseif( $request->do == "delete") {
			//按条件删除数据
			//dd($request->ac);
			//echo $request->ac; die();
			//DB::connection()->enableQueryLog();
			$data = $datatable_config['modelClass']::whereIn( 'id', json_decode( $request->ids ) );
			//dd($data);
			//判断是否有软删除,数据表中有"deleted_at"字段则软删除,如果没有则强制删除
			if( isset( $datatable_config['datatable_set']['deleted_at'] ) ){
				//如果在回收站则强制删除
				if( $request->ac == 'recycle' ){
					$result = $data->forceDelete();
					//dd(DB::getQueryLog());
				}else{
					$result = $data->delete();
					//dd(DB::getQueryLog());
				}
			}else{
				$result = $data->forceDelete();
			}
			//dd($result);
			if($result){
				echo json_encode(['code' => 0, 'msg' => "删除成功", 'refresh' => 'yes']);
			}else{
				echo json_encode(['code' => 1, 'msg' => "删除失败", 'refresh' => 'no']);
			}
		}elseif( $request->do == "recovery") {
			//恢复数据
			$result = $datatable_config['modelClass']::whereIn( 'id', json_decode( $request->ids ) )->restore();
			if($result){
				echo json_encode(['code' => 0, 'msg' => "数据恢复成功", 'refresh' => 'yes']);
			}else{
				echo json_encode(['code' => 1, 'msg' => "数据恢复失败", 'refresh' => 'no']);
			}
		}elseif( $request->do == "layui_upload") {
			//处理layui文件上传,返回值为被上传文件在数据库中的记录的json结构
			FileProcessing::layuiUpload();
		}elseif( $request->do == "data") {
			//如果有外部数据源,则读取
			if($datatable_config['data_source_method']){
				$result = $this->getDataByMethod($datatable_config['data_source_method'], $datatable_config);
				if($result['code'] == 0){
					return datatable_callback_json(0, '数据读取成功', count($result['data']), $result['data']);
				}else{
					echo json_encode($result);
				}
			}else{
				$conditions = [];
				//dd($request->post());
				
				//4、查询条件
				if(isset($additional_config['conditions'])){
					$conditions = array_merge($conditions, $additional_config['conditions']);
				}
				//dd($conditions);
				//DB::connection()->enableQueryLog();
				if(isset($datatable_config['other_set']['is_tree'])){
					if($request->ac == "recycle"){
						$rows_arr = $datatable_config['modelClass']::where($conditions)->onlyTrashed()->get();
					}else{
						$rows_arr = $datatable_config['modelClass']::where($conditions)->get();
					}
					if($rows_arr->first()){
						$rows_arr = $rows_arr->toArray();
						//如果是回收站则不输出树结构
						if($request->ac != "recycle"){
							$tree = new TreeController($rows_arr);
							$rows_arr = $tree->listToDatatableTree();
						}
						$rows_arr = $this->dicToChar($rows_arr, $datatable_config);
					}else{
						$rows_arr = [];
					}
					//dd(DB::getQueryLog());
					
					//dd($rows_arr);
					return datatable_callback_json(0, '数据读取成功', count($rows_arr), $rows_arr);
				}else{
					if($request->ac == "recycle"){
						$rows_arr = $datatable_config['modelClass']::where($conditions)->onlyTrashed()->paginate(30);
					}else{
						$rows_arr = $datatable_config['modelClass']::where($conditions)->paginate(30);
					}
					if($rows_arr->first()){
						$rows_arr = $rows_arr->toArray();
						$data_arr = $this->dicToChar($rows_arr['data'], $datatable_config);
					}else{
						$data_arr = [];
					}
					//dd($rows_arr);
					//dd(DB::getQueryLog());
					return datatable_callback_json(0, '数据读取成功', count($data_arr), $data_arr);
				}
			}
		}elseif( $request->do == "open" || $request->do == "recycle" ) {     //open参数是在Permission中间件中赋的值
			//回收站删除行内按钮
			if($request->do == "recycle" && isset($datatable_config['line_button'])){
				unset($datatable_config['line_button']);
			}
			
			$template = '';
			if($template && 0){
				echo $template;
			}else{
				$dom = $this->getDataFieldSet($datatable_config, 'read');
				//只有回收站才显示删除时间字段
				if( $request->do  != 'recycle'){
					unset($dom['deleted_at']['read']);
				}
				
				//print_r($cols_arr);
				//echo json_encode($cols_arr);
				//获得目录
				if(isset($datatable_config['directory']['has'])){
					//如果包含'->'则为指定控制器的方法,没有则为当前控制器的方法,
					$datatable_config['left_tree'] = $this->getDataByMethod($datatable_config['directory']['method'], $datatable_config);
				}
				
				//获得要传递的url参数
				$url_with_query = $request->fullUrl();
				$parse_url = parse_url($url_with_query);
				if(isset($parse_url['query'])?$parse_url['query']:false){
					$parse_url_query = $parse_url['query'].'&';
				}else{
					$parse_url_query = '';
				}
				
				//dd($parse_url['query']);
				//http_build_query();
				
				view()->share([
					'search' => $this->getDataFieldSet($datatable_config, 'search'), 		//搜索字段
					'cols' => $this->cols($dom, $datatable_config),							//表头
					'dom' => $dom,															//字段
					'datatable_config' => $datatable_config,								//数据表格配置
					'do' => $request->do,
					'parse_url_query' => $parse_url_query,
				]);
				
				$content = view('blk.datatable.body');
				$template = response($content)->getContent();
				//cache($datatable_config_name, $template);
				echo $template;
			}
		}else{
			//行内按钮与头部按钮处理
			if(isset($request->from)?$request->from == 'line':false){
				$button_menu_config = $datatable_config['line_button'][$request->do]['method'];
			}else{
				$button_menu_config = $datatable_config['new_head_menu'][$request->do]['method'];
			}
			
			//执行按钮绑定的方法
			$result = $this->getDataByMethod($button_menu_config, $datatable_config);
			//dd($result);
			if($result['code'] == 0){
				echo $result['data'];
			}else{
				echo $result['msg'];
			}
		}
    }
	
	/**
	 * 将数据表格配置与数据表格附加配置合并并取得字典数据字典
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		string 		$datatable_config_name 			数据表格配置名称
	 * @param 		$additional_config = [						代码中定义的数据表格附加配置
	 *		1、【已实现】定义要隐藏的头部操作按钮
	 *		'hide_head_menu' => ['create', 'update'],
	 *		2、定义要隐藏的行内操作按钮
	 *		'hide_line_menu' => ['anniu1', 'anniu2'],
	 *		3、定义要查询的字段，此定义会覆盖数据表格生成器datatable_set中字段的read属性设置，查询和查看将仅基于此设置
	 *		'fields' => ['field1', 'field2', 'field3'],
	 *		4、【已实现】查询条件
	 *		'conditions' => [
	 *			['module', '=', request()->module()],
	 *		],
	 *		5、【已实现】附加的新增数据,会被合并到表单提交的数据中，相同key的数据会覆盖表单提交的数据
	 *		'create_param' => [
	 *			'field1' => 'value1',
	 *		]
	 *		6、【已实现】附加的修改数据,会被合并到表单提交的数据中
	 *		'update_param' => [
	 *			'field1' => 'value1',
	 *		]
	 *		7、【已实现】自定义data数据来源,遵循tp5 的url生成规则，返回数据为二维数组，每行记录的key与数据表格生成器datatable_set中字段的field属性一致
	 *		'data_source_method' => url('data_source_method'),
	 *		8、【已实现】自定义删除页面，遵循tp5 的url生成规则，操作成功返回：json_encode(['code' => 0, 'msg' => "删除成功"])
	 *		'delete_page' => url('data_source_method'),
	 *		9、【已实现】自定义新增页面，应用示例：$this->fetch('common@datatable/create');
	 *		'create_page' => 'common@datatable/create',  
	 *		10、【已实现】自定义修改页面，
	 *		'update_page' => 'common@datatable/create',
	 *		11、【已实现】自定义搜索页面，应用示例：$this->fetch('common@datatable/create');
	 *		'search_page' => 'common@datatable/search',  
	 *		
	 *	];
	 * @return 		array       返回处理后的Datatable数据表格的配置文件
	 */
	private function getDatatableConfig($datatable_config_name, $additional_config = [])
	{
		$datatable_config = get_datatable_config($datatable_config_name);
		//dd($datatable_config);
		if(!empty($datatable_config)){
			//处理模型中的继承关系
			if(isset($datatable_config['inheritance'])?$datatable_config['inheritance']:false){
				$inheritance_datatable_config = get_datatable_config('datatable_'.$datatable_config['inheritance']);
				
				$datatable_config['datatable_set'] = $inheritance_datatable_config['datatable_set'];
				//$datatable_config['other_set']['line_button_area_width'] = $inheritance_datatable_config['other_set']['line_button_area_width'];
				$datatable_config['main_table'] = $inheritance_datatable_config['main_table'];
				$datatable_config['main_table'] = $inheritance_datatable_config['main_table'];
			}
			
			//1、定义要隐藏的头部操作按钮
			if(isset($additional_config['hide_head_menu'])){
				if($additional_config['hide_head_menu'][0] == 'all'){
					$datatable_config['head_menu'] = [];
				}else{
					foreach($additional_config['hide_head_menu'] as $v){
						unset($datatable_config['head_menu'][$v]);
					}
				}
			}
			
			//2、定义要隐藏的行内操作按钮
			if(isset($additional_config['hide_line_menu'])){
				if($additional_config['hide_line_menu'][0] == 'all'){
					$datatable_config['line_button'] = [];
				}else{
					foreach($additional_config['hide_line_menu'] as $v){
						unset($datatable_config['line_button'][$v]);
					}
				}
			}
			
			//7、更换数据源
			if(isset($additional_config['data_source_method'])){
				$datatable_config['data_source_method'] = $additional_config['data_source_method'];
			}else{
				$datatable_config['data_source_method'] = '';
			}
			
			//8、自定义删除页面
			if(isset($additional_config['delete_page'])){
				$datatable_config['delete_page'] = $additional_config['delete_page'];
			}else{
				$datatable_config['delete_page'] = '';
			}
			
			//9、自定义新增页面
			$datatable_config['create_page'] = isset($additional_config['create_page'])?$additional_config['create_page']:'blk.datatable.create';
			
			//10、自定义修改页面
			$datatable_config['update_page'] = isset($additional_config['update_page'])?$additional_config['update_page']:'blk.datatable.create';
			//dd($datatable_config);
			
			//获取字段属性设置
			foreach($datatable_config['datatable_set'] as $k=>$v){
				//取设置的字段属性,用于表单生成
// 				$conditions = [
// 					['design_id', '=', $datatable_config['id']],
// 					['field', '=', $v['field']],
// 				];
// 				$attribute_arr = BlkAttributeRepository::where($conditions)->first();
				
				if(isset($v['attribute'])){
					$attribute = $v['attribute'];
					//$attribute_arr = $attribute_arr->toArray();
					//$attribute = json_decode($attribute_arr['attribute'], true);
					//根据属性配置获取下拉选择的数据源
					if(isset($attribute['data_input_form'])?in_array($attribute['data_input_form'], ['select', 'tree_select', 'multiple_select', 'cascade_select']):false){
						if(isset($attribute['data_source_type']) && isset($attribute['data_source'])?$attribute['data_source']:false){
							if($attribute['data_source_type'] == 'method'){
								$attribute['dic_data'] = $this->getDataByMethod($attribute['data_source'], $datatable_config);
							}else if($attribute['data_source_type'] == 'json'){
								$attribute['dic_data'] = ['code' => 0, 'msg' => '数据获取成功', 'data' => json_decode($attribute['data_source'], true)];
							}else if($attribute['data_source_type'] == 'sql'){
								$result = DB::select($attribute['data_source']);
								//dd(object_array($result));
								$attribute['dic_data'] = ['code' => 0, 'msg' => '数据获取成功', 'data' => object_array($result)];
							}else{
								$attribute['dic_data'] = ['code' => 1, 'msg' => '请设置下拉选择数据源'];
							}
						}else{
							$attribute['dic_data'] = ['code' => 1, 'msg' => '请设置字段属性'];
						}
						//dd($attribute);
					}
				}else{
					//如果字段没有设置属性,则默认该字段输入方式为input单行文本
					$attribute = [
						'data_input_form' => 'input'
					];
				}
				
				$datatable_config['datatable_set'][$k] = array_merge($v,$attribute);
				//dd($datatable_config);
			}
			
			//获得数据模型
			if(isset($datatable_config['main_table'])){
				//根据模型配置取的表名称并实例化表对应的模型 new $datatable_config['modelClass']
				$class_name = studly_case($datatable_config['main_table']).'Repository';
				$datatable_config['modelClass'] = 'App\Repositories\\'.$class_name;
			}
			
			//获得路由命名
			$datatable_config['route_name'] = '/'.request()->path();
			
			//判断有权限的按钮
			//dd(request()->rules,$datatable_config['head_menu']);
			$lazykit_rules = request()->lazykit_rules['button']['value'];
			//dd($lazykit_rules);
			//头部菜单权限
			if(isset($datatable_config['head_menu'])){
				foreach($datatable_config['head_menu'] as $k=>$v){
					if(!in_array($k, $lazykit_rules)){
						unset($datatable_config['head_menu'][$k]);
					}
				}
			}
			
			//头部附加菜单权限
			if(isset($datatable_config['new_head_menu'])){
				foreach($datatable_config['new_head_menu'] as $k=>$v){
					//根据权限判断可用按钮
					if(!in_array($k, $lazykit_rules) && $k != 'search'){
						unset($datatable_config['new_head_menu'][$k]);
					}
					
					//判断按钮对应的操作地址
					if(Str::contains($v['method'], '@')){
						$arr = explode('@',$v['method']);
						$datatable_config['new_head_menu'][$k]['route'] = '/'.$arr['1'];
					}
				}
			}
			
			//行内菜单权限
			if(isset($datatable_config['line_button'])){
				foreach($datatable_config['line_button'] as $k=>$v){
					//根据权限判断可用按钮
					if(!in_array($k, $lazykit_rules) && $k != 'search'){
						unset($datatable_config['line_button'][$k]);
					}
					
					//判断按钮对应的操作地址
					if(Str::contains($v['method'], '@')){
						$arr = explode('@',$v['method']);
						$datatable_config['line_button'][$k]['route'] = '/'.$arr['1'];
					}
				}
			}
		}
		
		//dd($datatable_config);
		return $datatable_config;
	}
	
	/**
	 * 在新增、修改之前剔除数据库中未定义的字段
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		array 		$dom 			指定类型（create、update、read 等）的字段属性
	 * @param 		array 		$post 			待新增或者修改的数据
	 * @return 		array 						返回剔除数据库中未定义字段的数据
	 */
	private function getAllowField($dom,$post){
		$param = [];
		//dd($post);
		foreach($dom as $key=>$vo){
			$file_input = ['single_photo_upload', 'photos_upload', 'single_file_upload', 'files_upload'];
			if(isset($post[$key])){
				//将上传字段的json记录转为数组
				if(in_array($vo['data_input_form'], $file_input)){
					if($post[$key]){
						foreach($post[$key] as $k=>$v){
							$post[$key][$k] = json_decode($v);
						}
						$param[$key] = json_encode($post[$key]);
					}
				}else{
					$param[$key] = strlen($post[$key])>0?$post[$key]:'';
				}
			}else{
				//int型字段
				if(in_array($vo['field_type'], ['int', 'bigint', 'big', 'mediumint', 'integer', 'tinyint', 'smallint', 'float', 'double', 'decimal'])){
					$param[$key] = 0;
				}else{
					$param[$key] = '';
				}
			}
		}
		//dd($param);
		return $param;
	}
	
	/**
	 * 获得增、删、改、查、导入、导出需要的字段及字段属性
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		array 		$datatable_config 			数据表格的配置文件
	 * @param  		string 		$type 						$type参数的值为：create，update，read，search，import，export
	 * @return 		array                      				返回值为$type需要的字段
	 */
	private function getDataFieldSet($datatable_config, $type){
		$dom_arr = [];
		//获得数据表字段
		foreach($datatable_config['datatable_set'] as $k=>$v){
			//如果字段指定type属性有值为on则继续
			if(isset($v[$type])){
				if($v[$type] == 'on'){
					$dom_arr[$v['field']] = $v;
				}
			}
			
			//新增修改时如果字段不在数据库表中则跳过
			if(in_array($type, ['create','update'])){
				$table_fields_arr = Schema::getColumnListing($datatable_config['main_table']);
				if(!in_array($v['field'], $table_fields_arr)){
					unset($dom_arr[$v['field']]);
				}
			}
		}
		//dump($dom_arr);
		
		//将左固定字段放最前面,右固定字段放最后面,否则layui显示会有bug
		$fields_arr = $fields_left_arr = $fields_right_arr = [];
		foreach($dom_arr as $k=>$v){
			if($v['fixed'] == 'left'){
				$fields_left_arr[$k] = $v;
			}elseif($v['fixed'] == 'right'){
				$fields_right_arr[$k] = $v;
			}else{
				$fields_arr[$k] = $v;
			}
		}
		$dom_arr = array_merge($fields_left_arr, $fields_arr, $fields_right_arr);
		
		return $dom_arr?$dom_arr:[];
	}
	
	/**
	 * 字典转换
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		array 		$rows_arr 		待处理的数据集
	 * @param  		array 		$datatable_config 	数据表格的配置文件
	 * @return 		array
	 */
	private function dicToChar($rows_arr, $datatable_config){
		$dic_arr = $this->getDicList($datatable_config);
		//dd($dic_arr);
		//循环替换数组元素键值
		foreach($rows_arr as $k=>$v){
			foreach($v as $key=>$value){
				//判断字段是否在字典数组中,如果有则替换字段为在字典中的值
				if(isset($dic_arr[$key])?!empty($dic_arr[$key]):false){
					//字典在数据库中存储格式 1、 1,2、 1/2/3 
					if(Str::contains($value, ',')){
						$arr = explode(',',$value);
						$dic= [];
						foreach($arr as $v1){
							$dic_v = isset($dic_arr[$key][$v1])?$dic_arr[$key][$v1]:'';
							if(!empty($dic_v)){
								$dic[] = $dic_v;
							}
						}
						$dic_value = join('，', $dic);
					}else if(Str::contains($value, '/')){
						$arr = explode('/',$value);
						$dic = [];
						foreach($arr as $v1){
							$dic_v = isset($dic_arr[$key][$v1])?$dic_arr[$key][$v1]:'';
							if(!empty($dic_v)){
								$dic[] = $dic_v;
							}
						}
						$dic_value = join(' / ', $dic);
					}else{
						$dic_value = isset($dic_arr[$key][$value])?$dic_arr[$key][$value]:'';
					}
					$v[$key] = $dic_value;
				}
			}
			$rows_arr[$k] = $v;
		}
		return $rows_arr;
	}
	
	/**
	 * 获得字典的一维数组
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		array 		$datatable_config 	数据表格的配置文件
	 * @return 		array
	 */
	private function getDicList($datatable_config){
		$dic_arr = [];
		//从配置文件中读取字典数组
		foreach($datatable_config['datatable_set'] as $k=>$v){
			if(isset($v['dic_data']['code'])?$v['dic_data']['code'] == 0:false){
				$result = $this->getDic($v['dic_data']['data']);
				$data = [];
				foreach($result as $v){
					if(isset($v['value']) && isset($v['name'])){
						$data[$v['value']] = $v['name'];
					}
				}
				
				$dic_arr[$k] = $data;
			}
		}
		return $dic_arr;
	}
	
	/**
	 * 获得字典的一维数组
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		array 		$dic_data 		从配置中读取的字典数据集（一般是树结构）
	 * @return 		array
	 */
	private function getDic($dic_data){
		$result = array();
		if(is_array($dic_data)){
			foreach($dic_data as $v){
				$arr = array();
				if(isset($v['value'])){
					$arr['value'] = $v['value']; 
					$arr['name'] = $v['name']; 
					$result[] = $arr;
					//$result[$v['value']] = $v['name'];
					if(isset($v['children'])?!empty($v['children']):false){
						$children_result = $this->getDic($v['children']);
						$result = array_merge($result,$children_result);
					}
				}
			}
		}
		
		return $result;
	}
	
	/**
	 * 获得控制器方法返回的数据
	 *
	 * 如果没有控制器，则方法默认控制器为生成数据表格控制器
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		string 		$method 					控制器及控制器方法 App\Http\Controllers\Lazykit\DatatableController->leftDirectory
	 * @param  		array 		$datatable_config 			数据表格的配置文件
	 * @return 		object                      			返回值为数据表模型实例化的对象
	 */
	private function getDataByMethod($method, $datatable_config){
		if(Str::contains($method, '->')){
			$arr = explode('->',$method);
			$controller = $arr['0'];
			$method = $arr['1'];
		}else{
			$controller = $datatable_config['route']['controller'];
			//dd($controller);
		}
		//dd($controller);
		
		//判断类是否存在
		if (class_exists($controller)) {
			$class = new $controller;
			
			//判断方法是否存在
			if(method_exists($class, $method)){
				$data = ['code' => 0, 'msg' => '数据获取成功', 'data'=>$class->$method()];
			}else{
				$msg = "请在控制器“".$controller."”中创建方法“".$method."”";
				$data = ['code' => 1, 'msg' => $msg];
			}
		}else{
			$msg = "控制器“".$controller."”不存在，请创建并添加“".$method."”方法";
			$data = ['code' => 1, 'msg' => $msg];
		}
		
		//dd($data);
		return $data;
	}
	
	/**
	 * 处理Datatable表头
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		array 		$dom 				指定类型（create、update、read 等）的字段属性
	 * @param  		array 		$datatable_config 	数据表格的配置文件
	 * @return 		json                      	返回类似json的layui数据表格表头
	 */
	private function cols($dom, $datatable_config)
	{
		$cols_arr = [];
		//显示复选的条件,1、非外部数据源;2、有修改、新增按钮
		$isupdate = isset($datatable_config['head_menu']['update']['must'])?$datatable_config['head_menu']['update']['must'] == 'on':false;
		$isdelete = isset($datatable_config['head_menu']['delete']['must'])?$datatable_config['head_menu']['delete']['must'] == 'on':false;
		if($datatable_config['data_source_method'] == '' && ( $isupdate || $isdelete ) ){
			$cols_arr[] = array('type' => 'checkbox', 'fixed' => 'left');
		}
		foreach($dom as $k=>$v){
			if(isset($v['read'])){
				if($v['read'] == 'on'){
					$line_arr = [];
					$line_arr['field'] = $v['field'];
					$line_arr['title'] = $v['title'];
					if(isset($v['width'])){
						if(!empty($v['width'])){
							$line_arr['width'] = $v['width'];
						}else{
							if($v['field'] == 'id'){
								$line_arr['width'] = 60;
							}else{
								$line_arr['width'] = 150;
							}
						}
					}
					if(isset($v['sort'])){
						if(!empty($v['sort'])){
							$line_arr['sort'] = $v['sort'];
						}
					}
					if(isset($v['align'])){
						if(!empty($v['align'])){
							$line_arr['align'] = $v['align'];
						}
					}
					if(isset($v['fixed'])){
						if(!empty($v['fixed'])){
							$line_arr['fixed'] = $v['fixed'];
						}
					}
					if(isset($v['cell_style_template'])){
						if(!empty($v['cell_style_template'])){
							$line_arr['templet'] ='#'. $v['field'].'Tpl';
						}
					}
					$cols_arr[] = $line_arr;
				}
			}
		}
		
		//没有行操作按钮不显示
		if(isset($datatable_config['line_button'])?!empty($datatable_config['line_button']):false){
			$cols_arr[] = array('fixed' => 'right', 'title' => '操作', 'toolbar' => '#buer-table-bar', 'width' => $datatable_config['other_set']['line_button_area_width']);
		}
		$cols = json_encode($cols_arr);
		//dd($cols);
		
		return $cols;
	}
	
	/**
	 * 验证规则
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                      		返回验证规则
	 */
	private function validateRulesDic(){
		return $data = [
			'bail' 			=> '第一次验证失败后停止运行验证规则',
			'required' 		=> '不能为空',
			'alpha' 		=> '必须完全由字母构成',
			'string' 		=> '必须以字符串开始',
			//'alpha_dash' 	=> '字段可能包含字母、数字，以及破折号 (-) 和下划线 ( _ )',
			'alpha_num' 	=> '必须是完全是字母、数字',
			'date' 			=> '必须是有效的日期',
			'email' 		=> '必须为正确格式的电子邮件地址',
			'image' 		=> '必须是图片 (jpeg, png, bmp, gif, 或 svg)',
			'integer' 		=> '必须是整数',
			'numeric' 		=> '必须是数字',
			'ip' 			=> '必须是 IP 地址',
			'ipv4' 			=> '必须是 IPv4 地址',
			'ipv6' 			=> '必须是 IPv6 地址',
			'json' 			=> '必须是有效的 JSON 字符串',
			'url' 			=> '必须是有效的 URL',
		];
	}
}