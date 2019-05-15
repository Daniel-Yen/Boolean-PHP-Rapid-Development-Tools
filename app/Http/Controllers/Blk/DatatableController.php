<?php
/**
 |------------------------------------------------------------
 | [Boolean Lazyer Kit]布尔懒人工具包·PHP快速开发平台
 |------------------------------------------------------------
 | 作者：倒车的螃蟹<yh15229262120@qq.com>
 | 官网：http://blk.buersoft.cn
 | 手册：http://manual.buersoft.cn/blk
 | 版本：V3.0
 |------------------------------------------------------------
 */

namespace App\Http\Controllers\Blk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DatatableController extends Controller
{
	/**
	 * 生成数据表格页面
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		string     	$config_name 		配置名称
	 * @param 		array     	$additional_config 			代码中定义的数据表格附加配置
	 * 	$additional_config = [
	 *		1、【已实现】允许修改的字段
	 *		'allow_update_fields' => ['field1', 'field2', 'field3'],
	 *		2、【已实现】定义要隐藏的行内操作按钮
	 *		'allow_create_fields' => ['field1', 'field2', 'field3'],
	 *		3、【已实现】定义要查询的字段，此定义会覆盖数据表格生成器datatable_set中字段的read属性设置，查询和查看将仅基于此设置
	 *		'allow_read_fields' => ['field1', 'field2', 'field3'],
	 *		4、【已实现】查询条件,$value_end可选
	 *		'conditions' => [
	 *			[$field, $search_type, $value, [$value_end]],
	 *		],
	 *		5、【已实现】附加的新增数据,会被合并到表单提交的数据中，相同key的数据会覆盖表单提交的数据
	 *		'create_param' => [
	 *			'field1' => 'value1',
	 *		]
	 *		6、【已实现】附加的修改数据,会被合并到表单提交的数据中
	 *		'update_param' => [
	 *			'field1' => 'value1',
	 *		]
	 *		7、【已实现】自定义data数据来源,返回数据为二维数组，每行记录的key与数据表格生成器datatable_set中字段的field属性一致
	 *		'data_source_method' => 'dataSource',
	 *		8、【未实现】自定义删除页面，操作成功返回：json_encode(['code' => 0, 'msg' => "删除成功"])
	 *		'delete_page' => url('data_source_method'),
	 *		9、【已实现】自定义新增页面
	 *		'create_page' => 'blk.datatable.form',  
	 *		10、【已实现】自定义修改页面
	 *		'update_page' => 'blk.datatable.form',	
	 *	];
	 * @param  		\Illuminate\Http\Request  $request
	 * @return 		mixed
	 */
    public function createDatatable($config_name, $additional_config = [], $request)
    {
    	//根据datatable名称获得模型配置
    	$datatable_config = $this->getDatatableConfig($config_name, $additional_config);
    	//dd($datatable_config);
		if(empty($datatable_config)){
			exception_thrown(1001, '配置文件不存在');
		}
		
		if( $request->do == "create") {
			$dom = $this->getDataFieldSet($datatable_config, 'create', $additional_config);
			//dd($dom);
			if($request->isMethod('post')){
				$request->validate([]);
				
				//dd($request->post());
				$param = $this->getAllowField($dom, $request->post());
				//dump($param); die();
				
				//5、附加的新增数据
				if(isset($additional_config['create_param'])?$additional_config['create_param']:false){
					foreach($additional_config['create_param'] as $k=>$v){
						$param[$k] = $v;
					}
				}
				
				if(isset($datatable_config['datatable_set']['created_at'])){
					$param['created_at'] = date('Y-m-d H:i:s', time());
				}
				
				//这么直接插入记录created_at
				$datatable_config['modelClass']::insert($param);
				
				if(isset($request->blk_success)?$request->blk_success == 'success':false){
					echo success("添加成功");
					die();
				}else{
					datatable_success("添加成功");
				}
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
			//cache($config_name, $template);
			echo $template;
		}elseif( $request->do == "update") {
			if( $request->ac == "celledit") {
				//修改单元格
				$result = $datatable_config['modelClass']::where('id', $request->id)->update([$request->field => $request->value]);
				if($result){
					echo json_encode(['code' => 0, 'msg' => "单元格修改成功", 'refresh' => 'no']);
				}else{
					echo json_encode(['code' => 1, 'msg' => "单元格修改失败", 'refresh' => 'no']);
				}
				die();
			}
			
			$dom = $this->getDataFieldSet($datatable_config, 'update', $additional_config);
			if($request->isMethod('post')){
				$request->validate([]);
				
				//dd($request->post());
				$param = $this->getAllowField($dom, $request->post());
				//dump($param); die();
				//6、附加的修改数据
				if(isset($additional_config['update_param'])){
					if($additional_config['update_param']){
						foreach($additional_config['update_param'] as $k=>$v){
							$param[$k] = $v;
						}
					}
				}
				
				//dd($param);
				$datatable_config['modelClass']::where('id', $request->id)->update($param);
				//dd(DB::getQueryLog());
				
				if(isset($request->blk_success)?$request->blk_success == 'success':false){
					echo success("修改成功");
					die();
				}else{
					datatable_success("修改成功");
				}
			}
			
			//获得要修改的记录
			$data_arr = $datatable_config['modelClass']::where('id', $request->id)->get();
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
			//cache($config_name, $template);
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
		}elseif( $request->do == "import") {
			if(isset($request->ac)){
				switch($request->ac){
					//下载导入摸板
					case 'download':
						$this->downloadImportTpl($datatable_config);
						die();
						break;
					//提取提交的数据
					case 'data':
						$data = $this->getCsvLines($_FILES['file']['tmp_name'], 100, 1, $datatable_config);
						$data = array_filter($data);
						//dd($data);
						view()->share([
							'datatable_set' => $datatable_config['datatable_set'],
							'data' 			=> $data,
							'step'			=> 2
						]);
						break;
					//将数据保存到数据库
					case 'save':
						$data = json_decode($_POST['DATA'], true);
						$num_insert = 0;
						foreach($data as $k=>$v){
							$datatable_config['modelClass']::insert($v);
							//echo $zhibiao->getLastSql();
							$num_insert++;
						}
						
						view()->share([
							'data' 			=> $data,
							'num_insert' 	=> $num_insert,
							'step'			=> 3
						]);
						break;
				}
			}else{
				view()->share([
					'title' => $datatable_config['title'],
					'step'	=> 1
				]);
			}
			
			echo view('blk.datatable.import');
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
				//DB::connection()->enableQueryLog();
				
				//获得要查询的字段
				$read = $this->getDataFieldSet($datatable_config, 'read', $additional_config);
				//dd($read);
				$fields_arr['id'] = 'id';
				if(isset($datatable_config['other_set']['is_tree'])){
					$fields_arr['pid'] = 'pid';
					$fields_arr['title'] = 'title';
				}
				foreach($read as $k=>$v){
					$fields_arr[$k] = $k;
				}
				$fields = join(',', $fields_arr);
				//dd($fields);
				$data = $datatable_config['modelClass']::select($fields_arr);
				
				//获得post查询条件
				if($request->isMethod('post')){
					$conditions = [];
					
					$search = $request->post();
					foreach($datatable_config['datatable_set'] as $k=>$v){
						if(isset($search[$k])?$search[$k]:false){
							$field = $k;
							$search_type = $search[$k.'_search_type'];
							$value = $search[$k];
							if(isset($search[$k.'_end'])){
								$value_end = $search[$k.'_end'];
							}else{
								$value_end = '';
							}
							
							if($field && $search_type && $value){
								if($value_end){
									$conditions[] = [$field, $search_type, $value, $value_end];
								}else{
									$conditions[] = [$field, $search_type, $value];
								}
							}
							
						}
					}
					//4、附加查询条件
					if(isset($additional_config['conditions'])?$additional_config['conditions']:false && $conditions){
						$conditions = array_merge($conditions, $additional_config['conditions']);
					}
				}else{
					$conditions = isset($additional_config['conditions'])?$additional_config['conditions']:[];
				}
				//dd($conditions,1);
				
				//绑定查询条件
				foreach($conditions as $k=>$v){
					if(isset($v['0'])){ $field 			= $v['0']; }else{ $field 		= ''; }
					if(isset($v['1'])){ $search_type 	= $v['1']; }else{ $search_type 	= ''; }
					if(isset($v['2'])){ $value 			= $v['2']; }else{ $value 		= ''; }
					if(isset($v['3'])){ $value_end 		= $v['3']; }else{ $value_end 	= ''; }
					if($search_type == 'like'){
						$data = $data->when($field, function ($query) use ($field, $search_type, $value) {
									return $query->where($field, $search_type, '%'.$value.'%');
								});
					}else if($search_type == 'between'){
						if($value && $value_end){
							$data = $data->when($field, function ($query) use ($field, $value, $value_end) {
									return $query->whereBetween($field, [$value, $value_end]);
								});
						}
					}else if(in_array($search_type, ['=', '<>', '>', '<'])){
						$data = $data->when($field, function ($query) use ($field, $search_type, $value) {
									return $query->where($field, $search_type, $value);
								});
					}else if($search_type == 'in'){
						$data = $data->when($field, function ($query) use ($field, $value) {
									return $query->whereIn($field, $value);
								});
					}else if($search_type == 'null'){
						$data = $data->when($field, function ($query) use ($field) {
									return $query->whereNull($field);
								});
					}else if($search_type == 'notnull'){
						$data = $data->when($field, function ($query) use ($field) {
									return $query->whereNotNull($field);
								});
					}else if($search_type == 'date'){
						$data = $data->when($field, function ($query) use ($field, $value) {
									return $query->whereDate($field, $value);
								});
					}else if($search_type == 'date'){
						$data = $data->when($field, function ($query) use ($field, $value) {
									return $query->whereDate($field, $value);
								});
					}else if($search_type == 'mouth'){
						$data = $data->when($field, function ($query) use ($field, $value) {
									return $query->whereMonth($field, $value);
								});
					}else if($search_type == 'day'){
						$data = $data->when($field, function ($query) use ($field, $value) {
									return $query->whereDay($field, $value);
								});
					}else if($search_type == 'year'){
						$data = $data->when($field, function ($query) use ($field, $value) {
									return $query->whereYear($field, $value);
								});
					}else if($search_type == 'time'){
						$data = $data->when($field, function ($query) use ($field, $value) {
									return $query->whereTime($field, '=', $value);
								});
					}
				}
				//dd($data->toSql());
				
				//处理回收站查询已删除记录
				if($request->ac == "recycle"){
					$data = $data->onlyTrashed();
				}
				
				//如果为树结构则不分页查询
				if(isset($datatable_config['other_set']['is_tree'])){
					$data = $data->get();
					//如果是回收站则不输出树结构
					if($data->first()){
						$data = $data->toArray();
						//如果是回收站则不输出树结构
						if($request->ac != "recycle"){
							$tree = new TreeController($data);
							$data = $tree->listToDatatableTree();
						}
						$data = $this->dicToChar($data, $datatable_config);
					}else{
						$data = [];
					}
					$count = count($data);
				}else{
					$page_number = isset($request->limit)?$request->limit:$datatable_config['other_set']['limit'];
					//dd($data);
					$count = $data->count();
					//dd($count);
					$data = $data->paginate($page_number);
					
					//如果查询到数据则输出数组
					if($data->first()){
						$data = $data->toArray();
						$data = $this->dicToChar($data['data'], $datatable_config);
					}else{
						$data = [];
					}
				}
				//print_r(DB::getQueryLog());die();
				
				return datatable_callback_json(0, '数据读取成功', $count, $data);
			}
		}elseif( $request->do == "open" || $request->do == "recycle" ) {     //open参数是在Permission中间件中赋的值
			//回收站不可进行基于数据的任何操作，删除行内按钮
			if($request->do == "recycle" && isset($datatable_config['line_button'])){
				unset($datatable_config['line_button']);
			}
			
			$template = '';
			if($template && 0){
				echo $template;
			}else{
				$read = $this->getDataFieldSet($datatable_config, 'read', $additional_config);
				//只有回收站才显示删除时间字段
				if( $request->do  != 'recycle'){
					unset($read['deleted_at']['read']);
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
					'search' 	=> $this->getDataFieldSet($datatable_config, 'search', $additional_config), 		//搜索字段
					'cols' 		=> $this->cols($read, $datatable_config),						//表头
					'read' 								=> $read,														//字段
					'datatable_config' 					=> $datatable_config,					//数据表格配置
					'do' 								=> $request->do,
					'parse_url_query' 					=> $parse_url_query,
					'search_conditions_dic_arr' 		=> $this->searchConditionsDic(),		//字典：按钮打开方式
					'data_input_form_to_input_dic_arr' 	=> $this->dataInputFormToInputDic(),	//字典：按钮打开方式
					'data_input_form_between_dic_arr' 	=> $this->dataInputFormBetweenDic(),	//字典：支持区间搜索的字段
					'data_input_form_like_dic_arr' 		=> $this->dataInputFormLikeDic(),		//字典：支持模糊匹配的字段
					'data_input_form_only_like_dic_arr' => $this->dataInputFormOnlyLikeDic(),	//字典：支持模糊匹配的字段
					'data_input_form_only_equal_dic_arr'=> $this->dataInputFormOnlyEqualDic(),	//字典：支持模糊匹配的字段
				]);
				
				$content = view('blk.datatable.body');
				$template = response($content)->getContent();
				//cache($config_name, $template);
				echo $template;
			}
		}else{
			//获得当前url对应按钮的操作方法
			$method = '';
			if(isset($request->from)){
				if($request->from == 'line'){
					$method = $datatable_config['line_button'][$request->do]['method'];
				}elseif($request->from == 'cell'){
					$method = $datatable_config['datatable_set'][$request->field]['method'];
				}
			}else{
				$method = $datatable_config['new_head_menu'][$request->do]['method'];
			}
			
			//执行按钮关联的方法
			$result = $this->getDataByMethod($method, $datatable_config);
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
	 * @param  		string 		$config_name 			数据表格配置名称
	 * @param 		array 		$additional_config		代码中定义的数据表格附加配置
	 * @return 		array       返回处理后的Datatable数据表格的配置文件
	 */
	private function getDatatableConfig($config_name, $additional_config = [])
	{
		$datatable_config = get_blk_config($config_name);
		//dd($datatable_config);
		if(!empty($datatable_config)){
			//处理模型中的继承关系
			if(isset($datatable_config['inheritance'])?$datatable_config['inheritance']:false){
				$inheritance_datatable_config = get_blk_config('datatable_'.$datatable_config['inheritance']);
				
				$datatable_config['datatable_set'] = $inheritance_datatable_config['datatable_set'];
				//$datatable_config['other_set']['line_button_area_width'] = $inheritance_datatable_config['other_set']['line_button_area_width'];
				$datatable_config['main_table'] = $inheritance_datatable_config['main_table'];
			}
			
			//1、定义要隐藏的头部操作按钮
			// if(isset($additional_config['hide_head_menu'])){
			// 	if($additional_config['hide_head_menu'][0] == 'all'){
			// 		$datatable_config['head_menu'] = [];
			// 	}else{
			// 		foreach($additional_config['hide_head_menu'] as $v){
			// 			unset($datatable_config['head_menu'][$v]);
			// 		}
			// 	}
			// }
			
			//2、定义要隐藏的行内操作按钮
			// if(isset($additional_config['hide_line_menu'])){
			// 	if($additional_config['hide_line_menu'][0] == 'all'){
			// 		$datatable_config['line_button'] = [];
			// 	}else{
			// 		foreach($additional_config['hide_line_menu'] as $v){
			// 			unset($datatable_config['line_button'][$v]);
			// 		}
			// 	}
			// }
			
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
			$datatable_config['create_page'] = isset($additional_config['create_page'])?$additional_config['create_page']:'blk.datatable.form';
			
			//10、自定义修改页面
			$datatable_config['update_page'] = isset($additional_config['update_page'])?$additional_config['update_page']:'blk.datatable.form';
			//dd($datatable_config);
			
			//附加标题
			$additional_window_title = [];
			
			//获取字段属性设置
			foreach($datatable_config['datatable_set'] as $k=>$v){
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
				
				//附加标题
				if(isset($v['attribute']['window_title'])?$v['attribute']['window_title']:false){
					$additional_window_title[] = $v['field'];
				}
				
				$datatable_config['datatable_set'][$k] = array_merge($v,$attribute);
			}
				
			//附加标题
			$datatable_config['additional_window_title'] = $additional_window_title;
			//dd($datatable_config);
			
			//获得数据模型
			if(isset($datatable_config['main_table'])){
				//根据模型配置取的表名称并实例化表对应的模型 new $datatable_config['modelClass']
				$class_name = studly_case($datatable_config['main_table']).'Repository';
				$datatable_config['modelClass'] = 'App\Repositories\\'.$class_name;
			}
			
			//获得当前数据表格的路由命名
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
					if(strpos($v['method'], '@')){
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
					if(strpos($v['method'], '@')){
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
	 * data_input_form 在搜索时需要改变为input的字段
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array
	 */
	private function dataInputFormToInputDic(){
		return [
			'textarea',
			'single_photo_upload',
			'photos_upload',
			'single_file_upload',
			'files_upload',
			'date_scope',
			'year_scope',
			'year_mouth_scope',
			'time_scope',
			'datetime_scope',
			'layui_editer',
			'layui_editer_simple',
			'editormd',
			'color_choices'
		];
	}
	
	/**
	 * data_input_form 支持区间搜索的字段
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	private function dataInputFormBetweenDic(){
		return [
			'input',
			'year',
			'year_mouth',
			'date',
			'time',
			'datetime'
		];
	}
	
	/**
	 * data_input_form 支持模糊匹配的字段
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	private function dataInputFormLikeDic(){
		return [
			'input',
			'textarea',
			'layui_editer',
			'layui_editer_simple',
			'editormd',
		];
	}
	
	/**
	 * data_input_form 仅支持模糊匹配的字段
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	private function dataInputFormOnlyLikeDic(){
		return [
			'textarea',
			'layui_editer',
			'layui_editer_simple',
			'editormd',
			'single_photo_upload',
			'photos_upload',
			'single_file_upload',
			'files_upload',
		];
	}
	
	/**
	 * data_input_form 仅支持等于
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	private function dataInputFormOnlyEqualDic(){
		return [
			'select',
			'multiple_select',
			'tree_select',
			'cascade_select',
		];
	}
	
	/**
	 * 获得增、删、改、查、导入、导出需要的字段及字段属性
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		array 		$datatable_config 			数据表格的配置文件
	 * @param  		string 		$type 						$type参数的值为：create，update，read，search，import，export
	 * @param 		array     	$additional_config 			代码中定义的数据表格附加配置
	 * @return 		array                      				返回值为$type需要的字段
	 */
	private function getDataFieldSet($datatable_config, $type, $additional_config){
		$dom_arr = [];
		//获得数据表字段
		foreach($datatable_config['datatable_set'] as $k=>$v){
			//如果字段指定type属性有值为on则继续
			if(isset($v[$type])?$v[$type]:false){
				$dom_arr[$v['field']] = $v;
			}
			
			//如果$additional_config传入了允许create/update/read的字段,则剔除不在数组中的字段
			if(isset($additional_config['allow_'.$type.'_fields'])?$additional_config['allow_'.$type.'_fields']:false){
				if(!in_array($v['field'], $additional_config['allow_'.$type.'_fields'])){
					unset($dom_arr[$v['field']]);
				}
			}
			
			//新增修改时如果字段不在主表中则跳过
			if(in_array($type, ['create','update'])){
				//剔除不在数据表中的字段
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
		//dd($dom_arr);
		
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
					if(strpos($value, ',')){
						$arr = explode(',',$value);
						$dic= [];
						foreach($arr as $v1){
							$dic_v = isset($dic_arr[$key][$v1])?$dic_arr[$key][$v1]:'';
							if(!empty($dic_v)){
								$dic[] = $dic_v;
							}
						}
						$dic_value = join('，', $dic);
					}else if(strpos($value, '/')){
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
		if(strpos($method, '->')){
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
		//dd($datatable_config);
		foreach($dom as $k=>$v){
			if(isset($v['read'])){
				if($v['read'] == 'on'){
					$line_arr = [];
					$line_arr['field'] = $v['field'];
					//$line_arr['edit'] = 'text';
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
					if(isset($v['edit'])){
						if(!empty($v['edit'])){
							$line_arr['edit'] = 'text';
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
					if(isset($v['event'])){
						if(!empty($v['event'])){
							$line_arr['event'] = $v['field'].'Event';
							$line_arr['style'] = 'cursor: pointer; color:#129cf7;';
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
	private function validateRulesDic()
	{
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
	
	/**
	 * 搜索条件字段
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	private function searchConditionsDic()
	{
		return [
			'=' 		=> '等于',
			'<>' 		=> '不等于',
			'>' 		=> '大于',
			'<' 		=> '小于',
			'like' 		=> '模糊匹配',
			'between' 	=> '区间',
		];
	}
	
	/**
	 * 下载导入模板
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		array 		$datatable_config 	数据表格的配置文件
	 * @return 		file                       
	 */
	private function downloadImportTpl($datatable_config)
	{
		header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel;charset=utf-8');
        header('Pragma: no-cache');
        header('Expires: 0');
		$filename = '【'.$datatable_config['title'].'】导入摸板.csv';  //文件名
        $filename = urlencode($filename);
        $filename = str_replace("+", "%20", $filename);
        header('Content-Disposition: attachment; filename=' . $filename);

        $content = '';
		foreach($datatable_config['datatable_set'] as $k=>$v){
			if(isset($v['import'])?$v['import'] == 'on':false){
				 $content .= iconv('UTF-8', 'GBK', $v['title']) . ",";
			}
		}
		$content .= "\n";
		echo $content;
	}
	
	/**
     * 读取CSV文件
     *
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		private
     * @param 		int 		$lines 			读取行数
     * @param 		int 		$offset 		起始行数
     * @return 		array|bool
     */
    public function getCsvLines($csv_file = '', $lines = 0, $offset = 0, $datatable_config = []) {
        if (!$fp = fopen($csv_file, 'r')) {
            return false;
        }
        $j = 0;
        $data = [];
        while (($j < $lines) && !feof($fp)) {
            if($j >= $offset){
				$fget_data= fgetcsv($fp);
				$fget_data = eval('return '.iconv('gbk','utf-8',var_export($fget_data,true)).';');
				if($fget_data){
					$data[] = $fget_data;
				}
			}else{
				//指针下移一行
				fgetcsv($fp);
			}
			$j++;
        }
        fclose($fp);
		
		foreach($data as $key=>$value){
			$i = 0;
			foreach($datatable_config['datatable_set'] as $k=>$v){
				if(isset($v['import'])?$v['import'] == 'on':false){
					 $data_arr[$key][$v['field']] = $value[$i];
					 $i++;
				}
			}
		}
		
        return $data_arr;
    }
}