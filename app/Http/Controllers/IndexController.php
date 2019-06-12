<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Repositories\MenuRepository;
use App\Repositories\UserGroupRepository;

class IndexController extends Controller
{
	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	/**
	 * 首页框架
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param 		string     	$datatable_config_name 		配置名称
	 * @param 		array   	$additional_config 			调用数据表格生成器自定义的附加配置参数
	 */
	public function index()
	{
		$user = request()->user();
		//dd($user);
		//获得当前登录用户的用户组
		$user_group = UserGroupRepository::whereIn('id', explode(',', $user->user_group))->get();
		//取的当前登录用户所属用户组的权限
		$menu = [];
		if($user_group->count()){
			//根据用户组获取用户权限
			$rules_arr = $this->getRules($user_group);
			//dd($rules_arr);
			
			if($rules_arr){
				//根据当前用户的用户组权限取的菜单
				$menu = $this->getMenu($rules_arr);
				
				//获得菜单的树结构
				$tree = new \App\Http\Controllers\BooleanTools\TreeController($menu);
				$menu = $tree->listToTree();
				//dd($menu);
			}else{
				return redirect('no_permission');
			}
		}
		
		return view('index', [
			'menu' => $menu,
		]);
	}
	
	public function getRules($user_group){
		$rules_arr = [];
		foreach($user_group as $v){
			$rules = json_decode($v->rules, true);
			foreach($rules as $k=>$v){
				$rules_arr[] = $k;
			}
		}
		
		return $rules_arr;
	}
	
	public function getMenu($rules_arr){
		//dd($rules_arr);
		$menu_arr = DB::table('menu')
						->whereIn('url', $rules_arr)
						->get()
						->map(function ($value) {return (array)$value;})
						->toArray();
		//dd($menu_arr);
		$menu = [];
		if(!empty($menu_arr)){
			$ids = [];
			foreach($menu_arr as $k=>$v){
				if($v['pid']){
					$ids[] = $v['pid'];
				}
			}
			//获取上级菜单
			$menu_arr_1 = DB::table('menu')
								->whereIn('id', $ids)
								->get()
								->map(function ($value) {return (array)$value;})
								->toArray();
			if(!empty($menu_arr_1)){
				$menu = array_merge($menu_arr, $menu_arr_1);
				$ids = [];
				foreach($menu_arr_1 as $k=>$v){
					if($v['pid']){
						$ids[] = $v['pid'];
					}
				}
				//获取上级菜单的上级菜单
				$menu_arr_2 = DB::table('menu')
									->whereIn('id', $ids)
									->get()
									->map(function ($value) {return (array)$value;})
									->toArray();
				if(!empty($menu_arr_2)){
					$menu = array_merge($menu, $menu_arr_2);
				}
			}
		}
		
		$check_menu = [];
		foreach($menu as $k=>$v){
			$check_menu[$v['id']] = $v;
		}
		return $check_menu;
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