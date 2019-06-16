<?php
/**
 |------------------------------------------------------------
 | [Boolean-PHP-Rapid-Development-Tools] 布尔快速开发工具
 |------------------------------------------------------------
 | 作者：倒车的螃蟹<yh15229262120@qq.com>
 | 官网：http://brdt.buersoft.cn
 | 手册：http://manual.buersoft.cn/brdt
 | 版本：V3.0.0
 |------------------------------------------------------------
 */

namespace App\Http\Controllers\BooleanTools;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
	/**
	 * 清除缓存
	 *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		string     	$config_name 			//配置文件名称
	 * @return 		mixed
	 */
    public function clear()
    {
    	//Cache::flush();
    	
		echo json_encode(['code' => 0, 'msg' => '缓存已经清空']);
	}
}