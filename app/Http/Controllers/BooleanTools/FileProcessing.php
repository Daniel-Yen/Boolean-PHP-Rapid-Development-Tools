<?php
namespace app\common\controller;

use think\Controller;
use app\common\model\AttachmentRepository;

class FileProcessing
{
    /**
	 * DataGrid处理layui文件上传,返回值为被上传文件在数据库中的记录的json结构
	 * @access    public
	 * @author    倒车的螃蟹<yh15229262120@qq.com> 
	 * @param     string                   		返回json字符串给layui上传组件
	 */
	public function layuiUpload(){
		// 获取表单上传文件 例如上传了001.jpg
		$file = request()->file('file');
		dd($file);
		//文件存目录
		$puth = DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'attachments';
		$info = $file->move($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.$puth);
		//print_r($info);
		$file_arr = [];
		if($info){
			if($info->getInfo('error') == 0){
				$conditions = [
					['uid', '=', 1],
					['status', '=', 0],
					['sha1', '=', $info->sha1()],
					['create_time', '=', input('get.time')],
				];
				
				$param = [
					'uid' 			=> 1,
					'father_id' 	=> '',
					'name' 			=> $info->getInfo('name'),
					'module' 		=> request()->module(),
					'path' 			=> $puth.DIRECTORY_SEPARATOR.$info->getSaveName(),
					'thumb' 		=> '',
					'mime' 			=> $info->getMime(),					//$info->getInfo('type')
					'ext' 			=> $info->getExtension(),
					'size' 			=> $info->getInfo('size'),
					'md5' 			=> $info->md5(),
					'sha1' 			=> $info->sha1(),
					'sorting' 		=> '0',
					'status' 		=> '0',									//默认设置上传图片状态为无用
					'create_time' 	=> input('get.time'),
					'update_time' 	=> time()
				];
				
				//新增字段属性设置记录，如果已存在，则修改 ,返回值为新增或修改记录的id
				$id = AttachmentRepository::createOrUpdate($conditions, $param);
				//echo AttachmentRepository::getLastSql();
				if($id){
					//获得当前已上传的文件列表并返回
// 					$conditions = [
// 						['uid', '=', 1],
// 						['status', '=', 0],
// 						['create_time', '=', input('get.time')]
// 					];
					
					$file_arr = AttachmentRepository::getDataById($id);
					//echo AttachmentRepository::getLastSql();
					$file_arr['src'] = $file_arr['path'];
					unset($file_arr['path']);
					//print_r($file_arr);
					echo self::layui_callback_json($info->getInfo('error'), '上传成功', $file_arr);
				}else{
					echo self::layui_callback_json(1000, '上传失败', $file_arr);
				}
			}else{
				echo self::layui_callback_json($info->getInfo('error'), $file->getError(), $file_arr);
			}
		}else{
			// 上传失败获取错误信息
			//echo $file->getError();
			echo self::layui_callback_json($info->getInfo('error'), $file->getError(), $file_arr);
		}
	}
	
	/**
	 * 用于给DataGrid新增、修改时文件上传接口发挥数据
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
	 * @access 		private
	 * @param 		integer		$code 			0代表提供给layui的数据正常
	 * @param 		string		$msg 			提示信息
	 * @param 		array 		$rows_arr 		要返回的数据
	 * @return 		string | json 				返回提交给layui数据表格的数据
	 */
	private function layui_callback_json($code = 0, $msg = "", $rows_arr=[])
	{
		$result = [
			'code' => $code,
			'msg' => $msg,
			'data' => $rows_arr
		];
		exit(json_encode($result));
	}
}