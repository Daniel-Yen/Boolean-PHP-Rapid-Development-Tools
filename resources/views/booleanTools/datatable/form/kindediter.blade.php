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
							uploadJson : '{{$datatable_config['route_name']}}?do=kindediter_upload&time={{time()}}',
							//fileManagerJson : '../php/file_manager_json.php',
							allowFileManager : false,
							filterMode : true,
							filePostName : 'file'
						};
						var editor = K.create('textarea[name="{{$vo['field']}}"]', options);
				    });   
				</script>