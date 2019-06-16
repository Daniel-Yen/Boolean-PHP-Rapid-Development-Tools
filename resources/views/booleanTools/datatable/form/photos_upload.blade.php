				<div class="layui-form-item">
					<label class="layui-form-label title">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<div class="layui-upload">
							<button type="button" class="layui-btn" id="photos_upload_{{$vo['field']}}">多图片上传</button>
							<div class="layui-upload-list" id="main{{$vo['field']}}">
								@if (!empty($data_arr))
								@foreach ($data_arr[$vo['field']] as $eo)
								<div class="layui-upload-img-main">
								<img class="layui-upload-img" src="{{$filedomain}}{{$eo['src']}}" id="pic{{$vo['field']}}{{$eo['id']}}">
								<p></p>
								<textarea class="layui-hide" name="{{$vo['field']}}[{{$eo['id']}}]"> @json($eo) </textarea>
								<span onclick="this.parentNode.remove();" class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</span> &nbsp;
								</div>
								@endforeach
								@endif
							</div>
						</div>
					</div>
				</div>