				<div class="layui-form-item">
					<label class="layui-form-label title">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<textarea name="{{$vo['field']}}" value="{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" placeholder="请输入{{$vo['title']}}" autocomplete="off" class="layui-textarea">{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}</textarea>
					</div>
				</div>