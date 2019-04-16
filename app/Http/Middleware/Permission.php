<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\UserGroupRepository;
use App\Repositories\UserRepository;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
		//dd($user);
		
		//获得当前登录用户的用户组
		$user_group = UserGroupRepository::whereIn('id', explode(',', $user->user_group))->get();
		//取的当前登录用户所属用户组的权限
		if($user_group->count()){
			$rules = [];
			foreach($user_group as $v){
				$rules_arr = json_decode($v->rules, true);
				$rules = array_merge($rules, $rules_arr);
			}
		}
		
		//$rules = json_decode($user_group->rules, true);
		//dd($rules);
		//判断在当前用户所属用户组的$rules权限集合中是否有当前页面的授权,如果有则赋值给$lazykit_rules,如果没有则给$lazykit_rules赋值一个空数组
		$lazykit_rules = isset($rules[$request->path()])?$rules[$request->path()]:[];
		//dd($lazykit_rules);
		
		//$status == 0代表无操作权限
		$status = 0;
		//$lazykit_rules不为空表示当前页面有授权,
		if(!empty($lazykit_rules)){
			//$lazykit_rules['button']['key']存在代表当前验证规则是对Datatable的权限验证
			if(isset($lazykit_rules['button']['key'])){
				$key = $lazykit_rules['button']['key'];
				//dd($request->$key);
				//如果$request->$key == 'data',则判断当前Datatable是否有open权限,如果有则表示有权限读取数据
				//获取url中的参数$key,如果参数不存在则赋值为open
				if(empty($request->$key)){
					$request->offsetSet('do', 'open');
				}
				
				//基于$request->$key参数判断是否有Datatable中的功能按钮操作权限
				if(in_array($request->$key, $lazykit_rules['button']['value'])){
					$status = 1;
				}
			}
			//将当前规则赋值到Request
			$request->offsetSet('lazykit_rules', $lazykit_rules);
			//$request->offsetSet('lazykit_rules_all', $rules);				//所有
		}
		
		if($status == 0){
			return redirect('no_permission');
		}
		
		return $next($request);
    }
}
