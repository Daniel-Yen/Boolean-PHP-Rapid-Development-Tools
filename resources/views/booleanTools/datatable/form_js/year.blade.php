			{{-- 年选择器 --}}
			laydate.render({
				elem: '#{{$vo['field']}}',
				type: 'year'
			});
			@if (isset($search_conditions_dic_arr))
			laydate.render({
				elem: '#{{$vo['field']}}_end',
				type: 'year'
			});
			@endif