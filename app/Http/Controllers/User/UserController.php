<?php
/**
 * 功能名称：系统用户管理
 * 该控制器类由Datatable生成器自动生成
 * @auther 		Buer Lazykit
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\BlkUsersRepository;

class UserController extends Controller
{
    /**
     * 系统用户管理
     * @access    	public
     * @author    	Buer Lazykit
     */
    public function index(Request $request)
    {
    	//新增修改用户数据处理password字段
    	if($request->isMethod('post') && ( $request->do == 'create' || $request->do == 'update' ) ){
    		$additional_config['create_param'] = $additional_config['update_param'] = [
    			'password' => Hash::make($request->password),
    		];
    	}
		
		create_datatable('datatable_42', [], $request);
    }
	
	//修改个人信息
	public function updateUser(Request $request)
	{
		$user = $request->user();
		$id = $user->id;
		$additional_config = [
			'allow_update_fields' => ['name', 'phone', 'email']
		];
		
		create_update_form('datatable_42', $additional_config, $request, $id);
	}
	
	//修改用户密码
	public function updateUserPassword(Request $request)
	{
		if($request->isMethod('post')){
			//判断原密码是否正确
			if(password_verify($request->password, $request->user()->password)) {
				//记录登录时间
				BlkUsersRepository::where('id', '=', $request->user()->id)
					->update(['password' => Hash::make($request->new_password)]);
				
				return success("密码修改成功");
			}else{ 
				return error("您输入的原登录密码错误");
			}
		}
		
		return view('user.update_password');
	}
}