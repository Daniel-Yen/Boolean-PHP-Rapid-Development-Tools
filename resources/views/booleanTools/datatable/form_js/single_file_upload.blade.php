			{{-- 单个文件上传 --}}
			upload.render({
				elem: '#single_file_upload_{{$vo['field']}}',
				url: '{{$datatable_config['route_name']}}?do=layui_upload&time={{time()}} ',
				accept: 'file',
				done: function(res) {
					console.log(res)
					{{-- 如果上传失败 --}}
					if (res.code > 0) {
						layer.msg(res.msg);
					}else{
						{{-- 上传成功 --}}
						var html = '<a href="'+res.data.src+'">'+res.data.name+'</a><textarea class="layui-hide" name="{{$vo['field']}}['+res.data.id+']">'+JSON.stringify(res.data)+'</textarea>';
						$("#main{{$vo['field']}}").html(html);
						layer.msg(res.msg);
					}
				}
			});