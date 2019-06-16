<?php
namespace App\Http\Controllers\BooleanTools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Repositories\AttachmentRepository;

class FileProcessing extends Controller
{
    /**
     * DataGrid处理layui文件上传,返回值为被上传文件在数据库中的记录的json结构
     *
     * @access    public
     *
     * @author    倒车的螃蟹<yh15229262120@qq.com> 
     * @param  Request  $request
     * @param     string                   		返回json字符串给layui上传组件
     */
    public function layuiUpload(){
    	if(request()->hasFile('file')){
    		// 获取表单上传文件
    		$file = request()->file('file');
    		//print_r($file);
    		//echo $filename=$file->getClientOriginalName();
    		//Storage::makeDirectory($directory);
    		$realpath = $file->getRealPath();
    		$md5 = md5_file($realpath);
    		$file_name = $file->getClientOriginalName();
    		$saveDir = 'public/form/'.date('Y').'/'.date('m').'/'.date('d').'/'.$md5;
    		//用原文件名保存文件到磁盘,这样文件另存或者直接打开的时候就能直接显示原文件名,这样做是为了不经过服务器下载文件,同时避免指定时间段内相同文件名的同个文件被重复上传
    		$path = Storage::disk('local')->putFileAs($saveDir, $file, $file_name, 'public');
    		
    		//$allow_ext = ;
    		$allow_ext = collect(config('booleantools.ext'));
    		$allow_ext = $allow_ext->flatten();
    		//print_r($allow_ext); die();
    		$allow_ext = $allow_ext->map(function ($item, $key) {
    			return strtolower($item);
    		});
    		$allow_ext = $allow_ext->all();
    		
    		//print_r($allow_ext->all());
    		$entension = $file->getClientOriginalExtension();	// 扩展名
    		//print_r($entension); print_r($allow_ext); die();
    		if (!in_array(strtolower($entension), $allow_ext)) {
    			echo self::layui_callback_json(4, '不支持的扩展名为 “'.$entension.'” 的文件'); die();
    		}
    		//文件存目录
    // 		$puth = DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'attachments';
    // 		$info = $file->move($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.$puth);
    // 		//print_r($info);
    		//echo $file->getClientMimeType(); die();
    		$files = [];
    		if($file->isValid()){
    			$ext = $file->getClientOriginalExtension();
    			$files = [
    				'uid' 			=> request()->user()['id'],
    				'name' 			=> str_replace('.'.$ext, '', $file_name),
    				'src' 			=> str_replace('public', 'storage', $path),
    				'thumb' 		=> '',
    				'mime' 			=> $file->getClientMimeType(),
    				'ext' 			=> $ext,
    				'size' 			=> $file->getClientSize(),
    				'md5' 			=> $md5,
    				'sorting' 		=> '0',
    				'status' 		=> '0',									//默认设置上传图片状态为无用
    				'created_at' 	=> date('Y-m-d H:i:s', request()->time),
    				'updated_at' 	=> date('Y-m-d H:i:s', time()),
    			];
    			//dd($conditions, $param);
    			//新增字段属性设置记录，如果已存在，则修改 ,返回值为新增或修改记录的id
    			$id = AttachmentRepository::insertGetId($files);
    			if($id){
    				$file_id = ['id' => $id];
    				//$files = AttachmentRepository::where('id', '=', $id)->first();
    				$files = array_merge($file_id, $files);
    				//print_r($files);
    				//$files = object_array($files);
    				//print_r($files); die();
    				//echo AttachmentRepository::getLastSql();
    				//$files['src'] = $files['path'];
    				//unset($files['path']);
    				//print_r($files);
    				echo self::layui_callback_json(0, '上传成功', $files); die();
    			}else{
    				echo self::layui_callback_json(1, '上传文件写入数据库失败', $files); die();
    			}
    		}else{
    			echo self::layui_callback_json(2, '文件无效', $files); die();
    		}
    	}else{
    		// 上传失败获取错误信息
    		//echo $file->getError();
    		echo self::layui_callback_json(3, '未获得上传的文件', $files); die();
    	}
    }
	
	/**
	 * DataGrid处理layui文件上传,返回值为被上传文件在数据库中的记录的json结构
	 *
	 * @access    public
	 *
	 * @author    倒车的螃蟹<yh15229262120@qq.com> 
	 * @param  Request  $request
	 * @param     string                   		返回json字符串给layui上传组件
	 */
	public function kindediterUpload(){
		if(request()->hasFile('file')){
			// 获取表单上传文件
			$file = request()->file('file');
			//print_r($file);
			//echo $filename=$file->getClientOriginalName();
			//Storage::makeDirectory($directory);
			$realpath = $file->getRealPath();
			$md5 = md5_file($realpath);
			$file_name = $file->getClientOriginalName();
			$saveDir = 'public/form/'.date('Y').'/'.date('m').'/'.date('d').'/'.$md5;
			//用原文件名保存文件到磁盘,这样文件另存或者直接打开的时候就能直接显示原文件名,这样做是为了不经过服务器下载文件,同时避免指定时间段内相同文件名的同个文件被重复上传
			$path = Storage::disk('local')->putFileAs($saveDir, $file, $file_name, 'public');
			
			//$allow_ext = ;
			$allow_ext = collect(config('booleantools.ext'));
			$allow_ext = $allow_ext->flatten();
			//print_r($allow_ext); die();
			$allow_ext = $allow_ext->map(function ($item, $key) {
				return strtolower($item);
			});
			$allow_ext = $allow_ext->all();
			
			//print_r($allow_ext->all());
			$entension = $file->getClientOriginalExtension();	// 扩展名
			//print_r($entension); print_r($allow_ext); die();
			if (!in_array(strtolower($entension), $allow_ext)) {
				echo json_encode(['error' => 4, 'message' => '不支持的扩展名为 “'.$entension.'” 的文件']); die();
			}
			//文件存目录
	// 		$puth = DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'attachments';
	// 		$info = $file->move($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.$puth);
	// 		//print_r($info);
			//echo $file->getClientMimeType(); die();
			$files = [];
			if($file->isValid()){
				$ext = $file->getClientOriginalExtension();
				$files = [
					'uid' 			=> request()->user()['id'],
					'name' 			=> str_replace('.'.$ext, '', $file_name),
					'src' 			=> str_replace('public', 'storage', $path),
					'thumb' 		=> '',
					'mime' 			=> $file->getClientMimeType(),
					'ext' 			=> $ext,
					'size' 			=> $file->getClientSize(),
					'md5' 			=> $md5,
					'sorting' 		=> '0',
					'status' 		=> '0',									//默认设置上传图片状态为无用
					'created_at' 	=> date('Y-m-d H:i:s', request()->time),
					'updated_at' 	=> date('Y-m-d H:i:s', time()),
				];
				//dd($conditions, $param);
				//新增字段属性设置记录，如果已存在，则修改 ,返回值为新增或修改记录的id
				$id = AttachmentRepository::insertGetId($files);
				if($id){
					$file_id = ['id' => $id];
					//$files = AttachmentRepository::where('id', '=', $id)->first();
					$files = array_merge($file_id, $files);
					//print_r($files);
					//$files = object_array($files);
					//print_r($files); die();
					//echo AttachmentRepository::getLastSql();
					//$files['src'] = $files['path'];
					//unset($files['path']);
					//print_r($files);
					echo json_encode(['error' => 0, 'url' => '/'.$files['src'] ]); die();
				}else{
					echo json_encode(['error' => 1, 'message' => '上传文件写入数据库失败']); die();
				}
			}else{
				echo json_encode(['error' => 2, 'message' => '文件无效']); die();
			}
		}else{
			// 上传失败获取错误信息
			//echo $file->getError();
			echo json_encode(['error' => 3, 'message' => '未获得上传的文件']); die();
		}
	}
	
	/*
	 * 请求laravel/storage/app/data/下的文件资源
     *
	 * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function showFile(Request $request){
        $disk       = $request->disk;
        $subjection = $request->subjection;
        //把传来的数据用'/'分割
        $fileName   = explode('/',$subjection);                           
        if(count($fileName) != 2) return redirect('showemptyview');
        //取出文件的名字
        $fileName = $fileName[1]; 
        //判断请求的文件是否存在
        if(!file_exists(storage_path('app/data/'.$disk.'/'.$subjection))){
        //返回给用户空资源的视图
            return redirect('showemptyview');                                        
        }
        $temp_path  = tempnam(sys_get_temp_dir(), $fileName);
        file_put_contents($temp_path, Storage::disk($disk)->get($subjection));
        $downResponse = new BinaryFileResponse($temp_path);
        return $downResponse;
    }
	
    /*
	 * 从Storage文件下，下载文件
	 *
     * @auther 		倒车的螃蟹<yh15229262120@qq.com> 
     * @access 		public
     * @param 		Request 	$request
     * @return 		BinaryFileResponse
     */
    public function download($request){
		$file = AttachmentRepository::where('md5', '=', $request->md5)->first();
		//dd($file);
		if($file){
			$file = $file->toArray();
			//dd($file);
			
			//获得文件地址
			$path = storage_path($file['src']);
			return response()->download($path, $file['name']);
		}else{
			exception_thrown(1002, '文件不存在');
		}
    }
	
	/**
	 * 用于给DataGrid新增、修改时文件上传接口发挥数据
	 *
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
		
		return json_encode($result);
	}
}