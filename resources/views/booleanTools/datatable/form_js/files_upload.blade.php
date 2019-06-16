			{{-- 多文件列表 --}}
			var {{$vo['field']}}View = $('#{{$vo['field']}}'),
			uploadListIns{{$vo['field']}} = upload.render({
				elem: '#files_upload_{{$vo['field']}}',
				url: '{{$datatable_config['route_name']}}?do=layui_upload&time={{time()}}',
				accept: 'file',
				multiple: true,
				auto: false,
				bindAction: '#files_upload_{{$vo['field']}}Action',
				choose: function(obj) {
					var files = this.files = obj.pushFile(); {{-- 将每次选择的文件追加到文件队列 --}}
					{{-- 读取本地文件 --}}
					obj.preview(function(index, file, result) {
						var tr = $(['<tr id="upload-' + index + '">', '<td>' + file.name + '</td>', '<td>' + (file.size / 1014).toFixed(
								1) + 'kb</td>', '<td>等待上传</td>', 
							'<td><span class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</span> <span class="layui-btn layui-btn-xs demo-reload layui-hide">重传</span>', '</td>', '</tr>'
						].join(''));
					
						{{-- 单个重传 --}}
						tr.find('.demo-reload').on('click', function() {
							obj.upload(index, file);
						});
					
						{{-- 删除 --}}
						tr.find('.demo-delete').on('click', function() {
							delete files[index]; {{-- 删除对应的文件 --}}
							tr.remove();
							uploadListIns{{$vo['field']}}.config.elem.next()[0].value = ''; {{-- 清空 input file 值，以免删除后出现同名文件不可选 --}}
						});
					
						{{$vo['field']}}View.append(tr);
					});
				},
				done: function(res, index, upload) {
					if (res.code == 0) { {{-- 上传成功 --}}
						var tr = {{$vo['field']}}View.find('tr#upload-' + index),
							tds = tr.children();
						tds.eq(0).html('<a href="{{$filedomain}}'+res.data.src+'">'+res.data.name+'</a>');
						tds.eq(2).html('<span style="color: #5FB878;">上传成功</span><textarea class="layui-hide" name="{{$vo['field']}}['+res.data.id+']">'+JSON.stringify(res.data)+'</textarea>');
						tds.eq(3).html(''); {{-- 清空操作 --}}
						return delete this.files[index]; {{-- 删除文件队列已经上传成功的文件 --}}
					}
					this.error(index, upload);
				},
				error: function(index, upload) {
					var tr = {{$vo['field']}}View.find('tr#upload-' + index),
						tds = tr.children();
					tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
					tds.eq(3).find('.demo-reload').removeClass('layui-hide'); {{-- 显示重传 --}}
				}
			});