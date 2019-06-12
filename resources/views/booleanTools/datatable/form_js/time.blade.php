			{{-- 时间选择器 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'time'
			});
			@if (isset($search_conditions_dic_arr))
			laydate.render({
				elem: '#{{$vo['field']}}_end',
				type: 'time'
			});
			@endif