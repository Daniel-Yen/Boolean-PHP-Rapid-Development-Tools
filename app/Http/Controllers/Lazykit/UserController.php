<?php
/**
 * 功能名称：用户表
 * 该控制器类由Datatable生成器自动生成
 * @auther 		Buer Lazykit
 */

namespace App\Http\Controllers\Lazykit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 用户表
     * @access    	public
     * @author    	Buer Lazykit
     */
    public function index(Request $request)
    {
    	create_datatable('datatable_2', [], $request);
    }
}