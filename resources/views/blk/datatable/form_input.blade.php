				@foreach ($dom as $key=>$vo)
				@include ('blk.datatable.form.'.$vo['data_input_form'])
				@endforeach