				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					@include ('blk.datatable.form.input_search_type')
					<div class="layui-input-block">
						<input type="text" name="{{$vo['field']}}" value="{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" placeholder="请输入{{$vo['title']}}" autocomplete="off" class="layui-input">
					</div>
				</div>