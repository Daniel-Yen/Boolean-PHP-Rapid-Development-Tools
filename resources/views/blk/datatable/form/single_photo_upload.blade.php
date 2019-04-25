				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<div class="layui-upload">
							<button type="button" class="layui-btn" id="single_photo_upload_{{$vo['field']}}">上传图片</button>
							<div class="layui-upload-list" id="main{{$vo['field']}}">
								@if (empty($data_arr))
								@foreach ($data_arr[$vo['field']] as $vo)
								<img class="layui-upload-img" src="{{$vo['src']}}" id="pic{{$vo['field']}}">
								<p id="text{{$vo['field']}}"></p>
								<textarea class="layui-hide" name="{{$vo['field']}}[{{$vo['id']}}]"> @json($vo) </textarea>
								@endforeach
								@endif
							</div>
						</div>
					</div>
				</div>