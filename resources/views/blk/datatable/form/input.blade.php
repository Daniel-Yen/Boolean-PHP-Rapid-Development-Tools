				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					@include ('blk.datatable.form.input_search_type')
					<div class="layui-input-block">
						<input type="text" name="{{$vo['field']}}" value="{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" placeholder="请输入{{$vo['title']}}" autocomplete="off" class="layui-input">
					</div>
					@if (in_array($vo['data_input_form'], $data_input_form_between_dic_arr))
					<div class="layui-input-block layui-hide" id="between_{{$vo['field']}}_end">
						<input type="text" name="{{$vo['field']}}_end" value="{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" placeholder="请输入{{$vo['title']}}" autocomplete="off" class="layui-input">
					</div>
					@endif
				</div>