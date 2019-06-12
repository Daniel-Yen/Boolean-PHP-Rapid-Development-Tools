			{{-- layui精简版编辑器 --}}
			var {{$vo['field']}} = layedit.build('{{$vo['field']}}', {
				tool: ['face', 'link', 'unlink', '|', 'left', 'center', 'right'],
				height: 100
			});