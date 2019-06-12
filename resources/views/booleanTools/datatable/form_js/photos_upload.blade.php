			{{-- 多图片上传 --}}
			upload.render({
				elem: '#photos_upload_{{$vo['field']}}',
				url: '{{$datatable_config['route_name']}}?do=layui_upload&time={{time()}} ',
				multiple: true,
				before: function(obj) {
					{{-- 预读本地文件示例，不支持ie8 --}}
					obj.preview(function(index, file, result) {
						//$('#main{{$vo['field']}}').append('<img src="' + result + '" alt="' + file.name + '" class="layui-upload-img">')
					});
				},
				done: function(res) {
					{{-- 如果上传失败 --}}
					if (res.code > 0) {
						layer.msg(res.msg);
					}else{
						{{-- 上传成功 --}}
						var html = '<img class="layui-upload-img" src="'+res.data.src+'" id="pic{{$vo['field']}}"><textarea class="layui-hide" name="{{$vo['field']}}['+res.data.id+']">'+JSON.stringify(res.data)+'</textarea>';
						$("#main{{$vo['field']}}").append(html);
						layer.msg(res.msg);
					}
				}
			});