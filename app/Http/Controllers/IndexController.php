<?php

namespace App\Http\Controllers;

use App\Repositories\BlkMenuRepository;
use App\Repositories\UserGroupRepository;

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
		//获得当前登录用户的用户组
		$user_group = UserGroupRepository::whereIn('id', explode(',', $user->user_group))->get();
		//取的当前登录用户所属用户组的权限
		if($user_group->count()){
			$rules_arr = [];
			foreach($user_group as $v){
				$rules = json_decode($v->rules, true);
				foreach($rules as $k=>$v){
					$rules_arr[] = $k;
				}
			}
		}
		
		$menu = [];
		if($rules_arr){
			$menu_arr = BlkMenuRepository::whereIn('url', $rules_arr)->get();
			if($menu_arr->first()){
				$menu_arr = $menu_arr->toArray();
				$ids = [];
				foreach($menu_arr as $k=>$v){
					if($v['pid']){
						$ids[] = $v['pid'];
					}
				}
				//获取上级菜单
				$menu_arr_1 = BlkMenuRepository::whereIn('id', $ids)->get();
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
					$menu_arr_2 = BlkMenuRepository::whereIn('id', $ids)->get();
					if($menu_arr_2->first()){
						$menu_arr_2 = $menu_arr_2->toArray();
						$menu = array_merge($menu, $menu_arr_2);
					}
				}
			}
			//dd($menu);
			//$menu = BlkMenuRepository::get()->toArray();;
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