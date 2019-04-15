<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserGroupModel;
use App\Models\UserModel;

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
		$user_group = UserGroupModel::whereIn('id', explode(',', $user->user_group))->first();
		$rules = json_decode($user_group->rules, true);
		if(isset($rules['/'.$request->path()])){
			//将当前规则赋值到Request
			$request->offsetSet('rules', $rules['/'.$request->path()]);
		}else{
			return redirect('no_permission');
			
		}
		//dd($request->rules);
		return $next($request);
    }
}
