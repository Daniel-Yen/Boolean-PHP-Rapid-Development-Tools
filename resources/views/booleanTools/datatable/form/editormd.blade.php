				<div class="layui-form-item">
					<label class="layui-form-label title">{{$vo['title']}}</label>
				</div>
				<div class="layui-form-item">
					<div id="layout">
						<div id="editormd" style="z-index: 888;">
							<textarea name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" style="display:none;">
								{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}
							</textarea>
						</div>
					</div>
				</div>