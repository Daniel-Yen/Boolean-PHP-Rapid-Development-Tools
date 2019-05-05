<?php
/**
 * 功能名称：系统用户管理
 * 该控制器类由Datatable生成器自动生成
 * @auther 		Buer Lazykit
 */

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 系统用户管理
     * @access    	public
     * @author    	Buer Lazykit
     */
    public function index(Request $request)
    {
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
}