<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\BlkUsersRepository;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

	/**
     * 注册页面
	 *
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @param  		\Illuminate\Http\Request $request
	 * @return  	\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
		//用户注册
		if($request->isMethod('post')){
			return $this->registerUser($request);
		}
		
		return view('auth.login');
    }
	
	/**
     * 处理用户注册
	 *
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @param  		\Illuminate\Http\Request $request
     * @return 		mixed
     */
    public function registerUser($request)
    {
        $validator = $this->validator($request->post());
		
		if ($validator->fails()) {
            $errors = $validator->errors();
			foreach ($errors->all() as $message) {
				return error('注册失败', $message);
			}
        }
		
		$user = $this->create($request->post());
		if($user){
			//注册成功直接登录系统
			Auth::login($user);
			
			//记录登录时间
			BlkUsersRepository::where('id', '=', $request->user()->id)
				->update(['login_time' => date('Y-m-d H:i:s', time())]);
				
			return redirect('/');
		}else{
			return error("您输入的登录账号错误");
		}
    }
	
	/**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' 		=> ['required', 'string', 'max:255'],
            'email' 	=> ['required', 'string', 'email', 'max:255', 'unique:blk_users'],
            'phone' 	=> ['required', 'string', 'max:20', 'unique:blk_users'],
            'password' 	=> ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  	array  $data
     * @return 	App\Repositories\BlkUsersRepository
     */
    protected function create(array $data)
    {
        return BlkUsersRepository::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
