<?php
/**
 * 功能名称：系统管理
 * @auther 		Buer Lazykit
 */

namespace App\Http\Controllers\Lazykit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Lazykit\CreateRouteMenu;
use App\Repositories\SystemRepository;
use App\Repositories\MenuRepository;

class SystemController extends Controller
{
    /**
     * 创建路由、菜单、模型、验证器等
     */
    use Create;
	
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
	
	/**
	 * 系统管理
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		\Illuminate\Http\Request $request
	 * @return  	mixed
	 */
	public function middlewareManagement(Request $request)
	{
		create_datatable('datatable_81', [], $request);
	}
}