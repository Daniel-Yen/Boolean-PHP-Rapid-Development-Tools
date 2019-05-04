<?php
/**
 | 配置文件：单个配置文件 
 | 该控制器类由 Boolean Lazyer Kit 页面设计器自动生成
 |
 | @auther 		BLK
 | @datetime 	2019-05-02 17:57:30
 */

namespace App\Http\Controllers\Lazykit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * 单个配置文件
     *
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @param  		\Illuminate\Http\Request $request
     * @return  	mixed
     */
    public function index(Request $request)
    {
    	create_config('config_77', $request);
    }
	
	/**
	 * middleware字段的下拉选择
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @return 		array                       
	 */
	public function attributeMiddleware(){
		$data = [
			['value' => '1', 'name' => '身份验证'],
			['value' => '2', 'name' => '身份验证 & 权限控制'],
		];
		
		return $data;
	}
	
	/**
	 * 多种输入方式的配置
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		public
	 * @param  		\Illuminate\Http\Request $request
	 * @return  	mixed
	 */
	public function inputType(Request $request)
	{
		create_config('config_78', $request);
	}
}