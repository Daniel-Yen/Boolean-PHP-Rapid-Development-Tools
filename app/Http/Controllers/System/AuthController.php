<?php
/**
 * 功能名称：用户组管理
 * 该控制器类由Datatable生成器自动生成
 * @auther 		Buer Lazykit
 */

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlkMenuModel;
use App\Models\UserGroupModel;

class AuthController extends Controller
{
    /**
     * 用户组管理
     * @access    	public
     * @author    	Buer Lazykit
     */
    public function userGroup(Request $request)
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
		
		$data = BlkMenuModel::get();
		if($data->count()){
			$data = $data->toArray();
			//转换为树结构
			$tree = new \App\Http\Controllers\Common\TreeController($data);
			$data = $tree->listToDatatableTree();
		}else{
			$data = [];
		}
		
		foreach($data as $k=>$v){
			if($v['model'] == 2){
				$datatable_config = get_datatable_config('datatable_'.$v['id']);
				if($datatable_config){
					//dd($datatable_config);
					$button = [];
					if(isset($datatable_config['head_menu'])){
						$button = $datatable_config['head_menu'];
					}
					unset($button['search']);
					if(isset($datatable_config['new_head_menu'])){
						$button = array_merge($button, $datatable_config['new_head_menu']);
					}
				}
				$data[$k]['button'] = $button;
			}
		}
		//dd($data);
		
		$user_group = UserGroupModel::where('id', request()->id)->first();
		//dd(json_decode($user_group->rules, true));
		
		return view('system.permissions', [
			'data' => $data,
			'rules' => json_decode($user_group->rules, true)
		]);
	}
	
	/**
	 * 保存用户组权限
	 * @access    	private
	 * @author    	Buer Lazykit
	 */
	private function permissionsAdd($post)
	{
		$rules = $post['rules'];
		$rules_arr = [];
		foreach($rules as $k=>$v){
			$button = [];
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
		UserGroupModel::where('id', request()->id)->update($param);
	}
}