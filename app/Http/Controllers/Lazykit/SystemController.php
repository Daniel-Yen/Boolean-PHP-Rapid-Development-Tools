<?php
/**
 * 功能名称：系统管理
 * @auther 		Buer Lazykit
 */

namespace App\Http\Controllers\Lazykit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Lazykit\CreateRouteMenu;
use App\Repositories\BlkSystemRepository;
use App\Repositories\BlkMenuRepository;

class SystemController extends Controller
{
    /**
     * 创建路由与菜单
     */
    use CreateRouteMenu;
	
	/**
     * 系统管理
     *
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @param  		\Illuminate\Http\Request $request
     * @return  	mixed
     */
    public function index(Request $request)
    {
    	create_datatable('datatable_45', [], $request);
    }

}