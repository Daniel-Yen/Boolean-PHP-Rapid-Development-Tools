			@if ( isset($vo['dic_data']['code'])?$vo['dic_data']['code'] == 0:false )
			formSelects.data('{{$vo['field']}}', 'local', {
				arr: @json($vo['dic_data']['data'])
			});
			formSelects.value('{{$vo['field']}}', [{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}]);
			@endif