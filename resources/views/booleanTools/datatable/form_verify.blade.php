		//自定义验证规则
		form.verify({
		@foreach ($dom as $key=>$vo)
			@if (isset($vo['validate']))
			lazykit_{{$vo['field']}}: function(value){
				@foreach (explode(',', $vo['validate']) as $y)
				@switch ($y)
				@case ('required')
				if(value.length == 0){
					return '{{$vo['title'].$validate_rules_dic_arr[$y]}}';
				}
				@break
				@endswitch
				@endforeach
			}
			@endif
		@endforeach
		});