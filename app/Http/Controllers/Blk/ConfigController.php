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
    		$config['modelClass']::where('id', $request->id)->update($param);
    		//dd(DB::getQueryLog());
    		datatable_success("保存成功");
    	}
    	
    	//获得要修改的记录
    	// $data_arr = $config['modelClass']::where('id', $request->id)->lockForUpdate()->get();
    	// if($data_arr->first()){
    	// 	$data_arr = $data_arr->first()->toArray();
    	// }
		
    	//dd($config);
    	view()->share([
    		'config' => $config,
    		//'data_arr' => $data_arr,
    	]);
    	
    	$content = view('blk.config.form');
    	$template = response($content)->getContent();
    	//cache($config_name, $template);
    	echo $template;
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
					
					$config['config_set'][$key]['fields'][$k] = array_merge($v,$attribute);
				}
			}
		}
		
		//dd($config);
		return $config;
	}
}