<?php
/**
 * 功能名称：用户组管理
 * 该控制器类由Datatable生成器自动生成
 * @auther 		Buer Lazykit
 */

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}