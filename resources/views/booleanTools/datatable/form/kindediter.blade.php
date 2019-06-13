				<div class="layui-form-item">
					<label class="layui-form-label title">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<textarea name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" style="width:100%;height:400px;">
							{{isset($data_arr[$vo['field']])?$data_arr[$vo['field']]:''}}
						</textarea>
					</div>
				</div>
				<script>
				    KindEditor.ready(function(K) {
						var options = {
							cssPath : '{{file_path('/include/booleanTools/layui/css/layui.css')}}',
							cssData : 'body {padding:10px;}',
							filterMode : true
						};
						var editor = K.create('textarea[name="{{$vo['field']}}"]', options);
				    });   
				</script>