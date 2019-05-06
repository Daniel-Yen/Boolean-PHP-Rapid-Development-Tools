<?php
/**
 * 功能名称：用户组管理
 * 该控制器类由Datatable生成器自动生成
 * @auther 		Buer Lazykit
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\BlkUserGroupRepository;

class UserGroupController extends Controller
{
    /**
     * 用户组管理
     * @access    	public
     * @author    	Buer Lazykit
     */
    public function index(Request $request)
    {
    	create_datatable('datatable_43', [], $request);
    }
	
	/**
	 * 用户组权限
	 * @access    	public
	 * @author    	Buer Lazykit
	 */
	public function permissions()
	{
		if(request()->isMethod('post')){
			//dd(request()->post());
			$this->permissionsAdd(request()->post());
			return success("用户组权限设置成功");
		}
		
		$data = DB::table('blk_permissions')
					->get()
					->map(function ($value) {return (array)$value;})
					->toArray();
		//dump($data);
		if($data){
			//转换为树结构
			$tree = new \App\Http\Controllers\Blk\TreeController($data);
			$data = $tree->listToDatatableTree();
		}else{
			$data = [];
		}
		
		foreach($data as $k=>$v){
			//增加一个命名为open的授权
			$view['open'] = [
				'text' => '查看'
			];
			
			$button = [];
			
			if($v['model'] == '2' || $v['model'] == '5'){
				$datatable_config = get_blk_config('datatable_'.$v['id']);
				if($datatable_config){
					//dd($datatable_config);
					//头部菜单按钮
					if(isset($datatable_config['head_menu'])){
						// foreach($datatable_config['head_menu'] as $k1=>$v1){
						// 	if($v1['must'] != 'on'){
						// 		unset($datatable_config['head_menu'][$k1]);
						// 	}
						// }
						$head_menu = $datatable_config['head_menu'];
					}else{
						$head_menu = [];
					}
					//unset($button['search']);
					
					//头部附加菜单按钮
					if(isset($datatable_config['new_head_menu'])){
						// foreach($datatable_config['new_head_menu'] as $k1=>$v1){
						// 	if($v1['must'] != 'on'){
						// 		unset($datatable_config['new_head_menu'][$k1]);
						// 	}
						// }
						$head_menu = array_merge($head_menu, $datatable_config['new_head_menu']);
					}
					
					$data[$k]['nodes']['head_menu'] = [
						'title' => '头部菜单',
						'node'  => $head_menu
					];
					
					//行内按钮
					if(isset($datatable_config['line_button'])){
						$data[$k]['nodes']['line_button'] = [
							'title' => '行内按钮',
							'node'  => $datatable_config['line_button']
						];	
					}
					
					//单元格事件
					$event = [];
					if(isset($datatable_config['datatable_set'])){
						foreach($datatable_config['datatable_set'] as $k1=>$v1){
							if(isset($v1['attribute']['event'])?$v1['attribute']['event'] == 'on':false){
								$event[$v1['field'].'Event']['text'] = $v1['title'];
							}
						}
						
						if(!empty($event)){
							$data[$k]['nodes']['cell_event'] = [
								'title' => '单元格事件',
								'node'  => $event
							];
						}
					}
				}
			}
			
			//$button = array_merge($permission, $button);
			
			//$data[$k]['button'] = $button;	
		}
		//dd($data);
		
		$user_group = BlkUserGroupRepository::where('id', request()->user_group_id)->first();
		//dd(json_decode($user_group->rules, true));
		if($user_group){
			$rules = json_decode($user_group->rules, true);
		}else{
			$rules = '';
		}
		
		return view('user.permissions', [
			'view' => $view,
			'data' => $data,
			'rules' => $rules
		]);
	}
	
	/**
	 * 保存用户组权限
	 * @access    	private
	 * @author    	Buer Lazykit
	 */
	private function permissionsAdd($post)
	{
		$rules = isset($post['rules'])?$post['rules']:[];
		$rules_arr = [];
		foreach($rules as $k=>$v){
			$button = [];
			//因为所有按钮操作权限的前提是要有打开页面的权限并读取页面数据，所以选择了其他按钮权限没有选定查看权限,默认添加查看权限及数据查看权限
			$button[] = 'open';
			$button[] = 'data';
			foreach($v as $key=>$value){
				$button[] = $key;
				
			}
			$rules_arr[$k]['button'] = [
				'key' 	=> 'do',
				'value' => $button,
			];
		}
		//dd($rules_arr);
		$param = [
			'rules' => json_encode($rules_arr),
		];
		//dd($param);
		BlkUserGroupRepository::where('id', request()->user_group_id)->update($param);
	}
}