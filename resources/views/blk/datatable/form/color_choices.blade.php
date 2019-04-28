				<div class="layui-form-item">
					<label class="layui-form-label title">{{$vo['title']}}</label>
					<div class="layui-input-inline" style="width: 120px;">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}-input" value="{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}" placeholder="请选择颜色">
					</div>
					<div class="layui-inline" style="left: -11px;">
						<div id="{{$vo['field']}}"></div>
					</div>
				</div>