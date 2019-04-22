<?php
/**
 * 功能名称：获取路径
 * @auther 		boolean Lazykit
 */

namespace App\Http\Controllers\Lazykit;

//use App\Repositories\BlkSystemRepository;

trait SystemPath
{
    /**
     * 获得各类路径及模板
     *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
     * @param  		App\Repositories\BlkSystemRepository $system
     * @return 		array                       
     */
    private function getPath($system){
		//dd($menu_data);routes
		$path = [
			'laravel' => [
				'datatable' => $system->file_path.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Datatable'.DIRECTORY_SEPARATOR,
				//'datatable_name' => $menu_data['model'].'_'.$menu_data['id'],
				'repository' => $system->file_path.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Repositories'.DIRECTORY_SEPARATOR,
				'repository_tpl' => $this->getRepositoryTpl('laravel'),
				'request' => $system->file_path.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Requests'.DIRECTORY_SEPARATOR,
				'route' => $system->file_path.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR,
				//'route_name' => 'auto_generate.php'
				'controller' => $system->file_path.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR,
				'controller_tpl' => $this->getControllerTpl('laravel'),
			]
		];
		
		return $path[$system->framework];
	}
	
	/**
	 * 获得不同框架对应的Controller模板
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		string 		$framework	 	框架名称
	 * @return 		string                       
	 */
	private function getControllerTpl($framework){
		$tpl['laravel'] = '<?php
/**
 * 数据表格：{menu_title} 
 * 该控制器类由 Boolean Lazy Kit 页面设计器自动生成
 *
 * @auther 	Blk
 */

namespace App\Http\Controllers\{module};

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class {NewController} extends Controller
{
    /**
     * {menu_title}
     *
     * @author    	倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @param  		\Illuminate\Http\Request $request
     * @return  	mixed
     */
    public function {method}(Request $request)
    {
    	create_datatable(\'datatable_{id}\', [], $request);
    }
}';
		return $tpl[$framework];
	}
	
	/**
	 * 获得不同框架对应的数据模型模板
	 *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param  		string 		$framework	 	框架名称
	 * @return 		string                       
	 */
	private function getRepositoryTpl($framework){
		$tpl['laravel'] = '<?php
/**
 * 数据表：{table_name}
 * 该模型类由Datatable生成器自动生成
 * @auther 		杨鸿<yh15229262120@qq.com>
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class {New}Repository extends Model 
{
	//软删除Trait
	use SoftDeletes;
	//表名称
	protected $table = \'{table_name}\';
	//主键
	protected $primaryKey = \'id\';
	
	protected $datas = [\'deleted_at\'];
}';
		return $tpl[$framework];
	}	
}
