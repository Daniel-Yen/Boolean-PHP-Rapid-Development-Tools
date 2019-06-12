			{{-- 单图上传 --}}
			var uploadInst_{{$vo['field']}} = upload.render({
				elem: '#single_photo_upload_{{$vo['field']}}',
				url: '{{$datatable_config['route_name']}}?do=layui_upload&time={{time()}} ',
				before: function(obj) {
					{{-- 预读本地文件示例，不支持ie8 --}}
					obj.preview(function(index, file, result) {
						//$('#pic{{$vo['field']}}').attr('src', result); //图片链接（base64）
					});
				},
				done: function(res) {
					{{-- 如果上传失败 --}}
					if (res.code > 0) {
						layer.msg(res.msg);
					}else{
						{{-- 上传成功 --}}
						{{-- layer.msg(res.data.src); --}}
						var html = '<img class="layui-upload-img" src="'+res.data.src+'" id="pic{{$vo['field']}}"><p id="text{{$vo['field']}}"></p><textarea class="layui-hide" name="{{$vo['field']}}['+res.data.id+']">'+JSON.stringify(res.data)+'</textarea>';
						$("#main{{$vo['field']}}").html(html);
						layer.msg(res.msg);
					}
				}
			});