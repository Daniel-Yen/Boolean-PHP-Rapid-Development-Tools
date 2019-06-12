			{{-- 颜色选择 --}}
			colorpicker.render({
				elem: '#{{$vo['field']}}',
				color: '#1c97f5',
				done: function(color) {
					$('#{{$vo['field']}}-input').val(color);
				}
			});