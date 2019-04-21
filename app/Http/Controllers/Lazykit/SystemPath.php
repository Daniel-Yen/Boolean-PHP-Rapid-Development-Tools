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
     * 数据字典：数据表关联类型
     *
	 * @author    	倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
     * @param  		App\Repositories\BlkSystemRepository $system
     * @return 		string                       
     */
    private function getPath($system){
		//dd($menu_data);routes
		$path = [
			'laravel' => [
				'datatable' => $system->file_path.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Datatable'.DIRECTORY_SEPARATOR,
				//'datatable_name' => $menu_data['model'].'_'.$menu_data['id'],
				'repository' => $system->file_path.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Repositories'.DIRECTORY_SEPARATOR,
				'request' => $system->file_path.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Requests'.DIRECTORY_SEPARATOR,
				'route' => $system->file_path.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR,
				//'route_name' => 'auto_generate.php'
				'controller' => $system->file_path.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR,
			]
		];
		
		return $path[$system->framework];
	}
	
}
