				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					@include ('blk.datatable.form.input_search_type')
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}" placeholder="yyyy-MM-dd">
					</div>
				</div>