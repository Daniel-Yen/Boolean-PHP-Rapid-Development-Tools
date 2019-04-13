<?php
/**
 * 功能名称：系统信息
 * 该控制器类由Datatable生成器自动生成
 * @auther 		Buer Lazykit
 */

namespace App\Http\Controllers\;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnvironmentController extends Controller
{
    /**
     * 系统信息
     * @access    	public
     * @author    	Buer Lazykit
     */
    public function server(Request $request)
    {
    	create_datatable('datatable_23', [], $request);
    }
}