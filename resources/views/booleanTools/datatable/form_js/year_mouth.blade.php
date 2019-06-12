			{{-- 年月选择器 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'month'
			});
			@if (isset($search_conditions_dic_arr))
			laydate.render({
				elem: '#{{$vo['field']}}_end',
				type: 'month'
			});
			@endif