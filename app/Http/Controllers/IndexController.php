<?php

namespace App\Http\Controllers;

use App\Models\BlkMenuModel;
use App\Models\UserGroupModel;

class IndexController extends Controller
{
	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index()
	{
		$user = request()->user();
		//dd($user);
		$user_group = UserGroupModel::whereIn('id', explode(',', $user->user_group))->first();
		$rules = json_decode($user_group->rules, true);
		foreach($rules as $k=>$v){
			$rules_arr[] = $k;
		}
		//dd($rules_arr);
		$menu = [];
		if($rules_arr){
			$menu_arr = BlkMenuModel::whereIn('url', $rules_arr)->get();
			if($menu_arr->first()){
				$menu_arr = $menu_arr->toArray();
				$ids = [];
				foreach($menu_arr as $k=>$v){
					if($v['pid']){
						$ids[] = $v['pid'];
					}
				}
				//获取上级菜单
				$menu_arr_1 = BlkMenuModel::whereIn('id', $ids)->get();
				if($menu_arr_1->first()){
					$menu_arr_1 = $menu_arr_1->toArray();
					$menu = array_merge($menu_arr, $menu_arr_1);
					$ids = [];
					foreach($menu_arr_1 as $k=>$v){
						if($v['pid']){
							$ids[] = $v['pid'];
						}
					}
					//获取上级菜单的上级菜单
					$menu_arr_2 = BlkMenuModel::whereIn('id', $ids)->get();
					if($menu_arr_2->first()){
						$menu_arr_2 = $menu_arr_2->toArray();
						$menu = array_merge($menu, $menu_arr_2);
					}
				}
			}
			//dd($menu);
			//$menu = BlkMenuModel::get()->toArray();;
			$tree = new \App\Http\Controllers\Common\TreeController($menu);
			$menu = $tree->listToTree();
			//dd($menu);
		}else{
			return redirect('no_permission');
		}
		
		return view('index', [
			'menu' => $menu,
		]);
	}
	
	public function welcome(){
		return view('welcome');	
	}
	
	public function noPermission()
	{
		return view('datatable.msg', [
			'msg' => '没有操作权限',
		]);		
	}
}