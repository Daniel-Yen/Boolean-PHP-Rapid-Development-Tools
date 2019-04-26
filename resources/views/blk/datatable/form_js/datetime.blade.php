			{{-- 日期时间选择器 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'datetime'
			});
			@if (isset($search_conditions_dic_arr))
			laydate.render({
				elem: '#{{$vo['field']}}_end',
				type: 'datetime'
			});
			@endif