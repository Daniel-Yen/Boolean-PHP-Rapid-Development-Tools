				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<div id="layout">
							<div id="editormd">
								<textarea name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" style="display:none;">
									{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}
								</textarea>
							</div>
						</div>
					</div>
				</div>