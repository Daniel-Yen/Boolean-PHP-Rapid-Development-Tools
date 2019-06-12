				<div class="layui-form-item">
					<label class="layui-form-label title">{{$vo['title']}}</label>
					@include ('booleanTools.datatable.form.input_search_type')
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" readonly="readonly" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}" placeholder="yyyy-MM-dd">
					</div>
					@if (isset($search_conditions_dic_arr))
					<div class="layui-input-inline @if(isset($vo['search'])?$vo['search'] != 'between':false) layui-hide  @endif padding-left-0" id="between_{{$vo['field']}}_end">
						<input type="text" class="layui-input" name="{{$vo['field']}}_end" readonly="readonly" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}_end" value="{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}" placeholder="yyyy-MM-dd">
					</div>
					@endif
				</div>