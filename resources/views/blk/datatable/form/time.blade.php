				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					@include ('blk.datatable.form.input_search_type')
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" readonly="readonly" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}" placeholder="HH:mm:ss">
					</div>
					@if (isset($search_conditions_dic_arr))
					<div class="layui-input-inline layui-hide padding-left-0" id="between_{{$vo['field']}}_end">
						<input type="text" class="layui-input" name="{{$vo['field']}}_end" readonly="readonly" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}_end" value="{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}" placeholder="HH:mm:ss">
					</div>
					@endif
				</div>