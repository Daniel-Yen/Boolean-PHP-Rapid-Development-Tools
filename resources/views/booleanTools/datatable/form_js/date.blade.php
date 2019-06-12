			{{-- 日期选择器 --}}
			laydate.render({
				elem: '#{{$vo['field']}}'
			});
			@if (isset($search_conditions_dic_arr))
			laydate.render({
				elem: '#{{$vo['field']}}_end'
			});
			@endif