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
use App\Repositories\BlkConfigRepository;

class ConfigController extends Controller
{
	/**
	 * 生成配置文件页面
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		string     	$config_name 			//配置文件名称
	 * @return 		mixed
	 */
    public function createConfig($config_name, $request)
    {
    	//根据datatable名称获得模型配置
		$config = $this->getConfig($config_name);
		//dd($config);
		
    	if($request->isMethod('post')){
    		$request->validate([]);
    		
    		//dd($request->config);
			
    		//将页面设计对应的datatable 配置文件保存到数据库
			foreach($request->config as $k=>$v){
				BlkConfigRepository::updateOrInsert(
					['tag' 		=> $k],
					['config' 	=> json_encode($v)]
				);
			}
    		//dd(DB::getQueryLog());
    		echo success("保存成功");
			die();
    	}
    	
		//从配置文件获取配置的标签
		$ids = [];
		foreach($config['config_set'] as $k=>$v){
			$ids[] = $k;
		}
		//dd($ids);
		
    	//获得要配置的值
    	$config_arr = BlkConfigRepository::whereIn('tag', $ids)->get();
    	if($config_arr->first()){
    		$config_arr = $config_arr->toArray();
			$data_arr = [];
			foreach($config_arr as $k=>$v){
				$v['config'] = json_decode($v['config'], true);
				foreach($v['config'] as $key=>$value)
				$data_arr['config['.$v['tag'].']['.$key.']'] = $value;
			}
    	}
		
		//dd($config);
		//$data_arr = $this->dicToChar($data_arr, $config);
		//dd($data_arr);
		
    	//dd($config);
    	view()->share([
    		'config' => $config,
    		'data_arr' => $data_arr,
    	]);
    	
    	$content = view('blk.config.form');
    	$template = response($content)->getContent();
    	//cache($config_name, $template);
    	echo $template;
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
	private function dicToChar($rows_arr, $config){
		$dic_arr = $this->getDicList($config);
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
	 * @param  		array 		$config 	数据表格的配置文件
	 * @return 		array
	 */
	private function getDicList($config){
		$dic_arr = [];
		//从配置文件中读取字典数组
		foreach($config['config_set'] as $k=>$v){
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
	 * 将数据表格配置与数据表格附加配置合并并取得字典数据字典
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		string 		$config_name 	数据表格配置名称
	 * @return 		array       				返回处理后的配置文件页面的配置文件
	 */
	private function getConfig($config_name)
	{
		$config = get_blk_config($config_name);
		//dd($config);
		if(!empty($config)){
			//获取字段属性设置
			foreach($config['config_set'] as $key=>$value){
				foreach($value['fields'] as $k=>$v){
					$v['field'] = 'config['.$key.']['.$v['field'].']';
					if(isset($v['attribute'])){
						$attribute = $v['attribute'];
						//$attribute_arr = $attribute_arr->toArray();
						//$attribute = json_decode($attribute_arr['attribute'], true);
						//根据属性配置获取下拉选择的数据源
						if(isset($attribute['data_input_form'])?in_array($attribute['data_input_form'], ['select', 'tree_select', 'multiple_select', 'cascade_select']):false){
							if(isset($attribute['data_source_type']) && isset($attribute['data_source'])?$attribute['data_source']:false){
								if($attribute['data_source_type'] == 'method'){
									$attribute['dic_data'] = $this->getDataByMethod($attribute['data_source'], $config);
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
					
					unset($v['attribute']);
					
					$config['config_set'][$key]['fields'][$k] = array_merge($v,$attribute);
				}
			}
		}
		
		//dd($config);
		return $config;
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
	 * 获得配置值
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		string 		$key 			格式：配置.字段
	 * @return 		string
	 */
	private function getConfigValue($key)
	{
		$config_arr = BlkConfigRepository::where('tag', '=', $ids)->get();
		if($config_arr->first()){
			$config_arr = $config_arr->first()->toArray();
			$data_arr = [];
			foreach($config_arr as $k=>$v){
				$v['config'] = json_decode($v['config'], true);
				foreach($v['config'] as $key=>$value)
				$data_arr['config['.$v['tag'].']['.$key.']'] = $value;
			}
		}
	}
}