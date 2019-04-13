<?php
/**
 * 功能名称：系统用户管理
 * 该控制器类由Datatable生成器自动生成
 * @auther 		Buer Lazykit
 */

namespace App\Http\Controllers\Ucenter;

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
    	create_datatable('datatable_37', [], $request);
    }
}