				<div class="layui-form-item">
					<label class="layui-form-label title">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<button type="button" class="layui-btn" id="single_file_upload_{{$vo['field']}}"><i class="layui-icon"></i>上传文件</button> &nbsp; &nbsp; &nbsp;
						<span id="main{{$vo['field']}}">
							@if (empty($data_arr))
							@foreach ($data_arr[$vo['field']] as $vo)
							<a href="{{$vo['src']}}">{{$vo['name']}}</a>
							<textarea class="layui-hide" name="{{$vo['field']}}[{{$vo['id']}}]"> @json($vo) </textarea>
							@endforeach
							@endif
						</span>
					</div>
				</div>