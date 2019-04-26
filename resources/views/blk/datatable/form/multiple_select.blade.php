				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					@include ('blk.datatable.form.input_search_type')
					<div class="layui-input-block search-block">
						@if ( isset($vo['dic_data']['code'])?$vo['dic_data']['code'] == 0:false )
						<select name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" xm-select-skin="default" xm-select="{{$vo['field']}}" xm-select-direction="down">
							<option value="">请选择</option>
						</select>
						@else
						<div class="layui-form-mid layui-word-aux"><span class="layui-badge">{{$vo['dic_data']['msg']}}</span></div>
						@endif
					</div>
				</div>