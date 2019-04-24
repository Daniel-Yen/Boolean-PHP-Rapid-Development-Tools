		@foreach ($dom as $key=>$vo)
		@switch ($vo['data_input_form'])
		@case ('input')

		@break
		@case ('textarea')

		@break
		@case ('select')
			@if ( isset($vo['dic_data']['code'])?$vo['dic_data']['code'] == 0:false )
			formSelects.data('{{$vo['field']}}', 'local', {
				arr: @json($vo['dic_data']['data'])
			});
			formSelects.value('{{$vo['field']}}', [{{$data_arr[$vo['field']]}}]);
			@endif
		@break
		@case ('tree_select')
			@if ( isset($vo['dic_data']['code'])?$vo['dic_data']['code'] == 0:false )
			formSelects.data('{{$vo['field']}}', 'local', {
				arr: @json($vo['dic_data']['data'])
			});
			formSelects.value('{{$vo['field']}}', [{{$data_arr[$vo['field']]}}]);
			@endif
		@break
		@case ('multiple_select')
			@if ( isset($vo['dic_data']['code'])?$vo['dic_data']['code'] == 0:false )
			formSelects.data('{{$vo['field']}}', 'local', {
				arr: @json($vo['dic_data']['data'])
			});
			formSelects.value('{{$vo['field']}}', [{{$data_arr[$vo['field']]}}]);
			@endif
		@break
		@case ('cascade_select')
			@if ( isset($vo['dic_data']['code'])?$vo['dic_data']['code'] == 0:false )
			formSelects.data('{{$vo['field']}}', 'local', {
				arr: @json($vo['dic_data']['data']),
				linkage: true	//开启联动模式
			});
			formSelects.value('{{$vo['field']}}', ['{{$data_arr[$vo['field']]}}']);
			@endif
		@break
		@case ('year')
			{{-- 年选择器 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'year'
			});
		@break
		@case ('year_mouth')
			{{-- 年月选择器 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'month'
			});
		@break
		@case ('date')
			{{-- 日期选择器 --}}
			laydate.render({
				elem: '#{{$vo['field']}}'
			});
		@break
		@case ('time')
			{{-- 时间选择器 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'time'
			});
		@break
		@case ('datetime')
			{{-- 日期时间选择器 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'datetime'
			});
		@break
		@case ('date_scope')
			{{-- 日期范围 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				range: true
			});
		@break
		@case ('year_scope')
			{{-- 年范围 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'year',
				range: true
			});
		@break
		@case ('year_mouth_scope')
			{{-- 年月范围 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'month',
				range: true
			});
		@break
		@case ('time_scope')
			{{-- 时间范围 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'time',
				range: true
			});
		@break
		@case ('datetime_scope')
			{{-- 日期时间范围 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'datetime',
				range: true
			});
		@break
		@case ('color_choices')
			{{-- 颜色选择 start --}}
			colorpicker.render({
				elem: '#{{$vo['field']}}',
				color: '#1c97f5',
				done: function(color) {
					$('#{{$vo['field']}}-input').val(color);
				}
			});
			{{-- 颜色选择 end --}}
		@break
		@case ('single_file_upload')
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
		@break
		@case ('photos_upload')
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
		@break
		@case ('single_photo_upload')
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
		@break		
		@case ('files_upload')
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
									1) + 'kb</td>', '<td>等待上传</td>', '<td>',
								'<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>',
								'<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>', '</td>', '</tr>'
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
							tds.eq(0).html('<a href="'+res.data.src+'">'+res.data.name+'</a>');
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
		@break
		@case ('layui_editer')
			{{-- layui编辑器 --}}
			var {{$vo['field']}} = layedit.build('{{$vo['field']}}');
		@break
		@case ('layui_editer_simple')
			{{-- layui精简版编辑器 --}}
			var {{$vo['field']}} = layedit.build('{{$vo['field']}}', {
				tool: ['face', 'link', 'unlink', '|', 'left', 'center', 'right'],
				height: 100
			});
		@break
		@case ('editormd')
			
		@break
		@endswitch
		@endforeach
