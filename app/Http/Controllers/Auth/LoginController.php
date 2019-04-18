<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BlkUsersRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
	
	/**
     * 登录页面
     * @param  \Illuminate\Http\Request $request
	 * @return 
     */
    public function login(Request $request)
    {
//      $pwd = "123456";
// 		$hash = password_hash($pwd, PASSWORD_DEFAULT);
// 		echo $hash;
// 		if (password_verify('123456','$2y$10$4kAu4FNGuolmRmSSHgKEMe3DbG5pm3diikFkiAKNh.Sf1tPbB4uo2')) {
// 			echo "密码正确";
// 		} else { 
// 			echo "密码错误";
// 		}
		
		//dd(1);
		//用户登录验证
		if($request->isMethod('post')){
			return $this->checkLogin($request);
		}
		
		return view('auth.login');
    }
	
	/**
     * 处理登录认证
     * @param  \Illuminate\Http\Request $request
     * @return 
     */
    public function checkLogin($request)
    {
        //\Illuminate\Support\Facades\DB::connection()->enableQueryLog();
		$user = BlkUsersRepository::where('status', '=', '1')
				->where(function ($query) use ($request) {
					$query->where('phone', '=', $request->username)
						  ->orWhere('email', '=', $request->username);
				})
				->first();
			
		//dd(\Illuminate\Support\Facades\DB::getQueryLog());
		//dd($user);
		if($user){
			//dd($user->password);
			//dd($request->password);
			$hash = password_hash($request->password, PASSWORD_DEFAULT);
			//dd($hash);
			if(password_verify($request->password, $user->password)) {
				Auth::login($user);
				return redirect('/');
				//$user = $request->user();
				//dd($user);
			}else{ 
				return error("您输入的登录密码错误");
			}
		}else{
			return error("您输入的登录账号错误");
		}
    }
}