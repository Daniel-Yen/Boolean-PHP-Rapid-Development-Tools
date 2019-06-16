				<div class="layui-form-item">
					<label class="layui-form-label title">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<div class="layui-upload">
							<button type="button" class="layui-btn layui-btn-normal" id="files_upload_{{$vo['field']}}">选择多文件</button>
							<div class="layui-upload-list">
								<table class="layui-table">
									<thead>
										<tr>
											<th>文件名</th>
											<th>大小</th>
											<th>状态</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody id="{{$vo['field']}}">
										@if (!empty($data_arr))
										@foreach ($data_arr[$vo['field']] as $eo)
										<tr>
											<td>
												<a target="_blank" href="{{$filedomain}}{{$eo['src']}}">{{$eo['name']}}</a>
												<textarea class="layui-hide" name="{{$vo['field']}}[{{$eo['id']}}]"> @json($eo) </textarea>
											</td>
											<td>{{$eo['size']}}</td>
											<td>已上传文件</td>
											<td>
												<span onclick="this.parentNode.parentNode.remove();" class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</span>
											</td>
										</tr>
										@endforeach
										@endif
									</tbody>
								</table>
							</div>
							<button type="button" class="layui-btn" id="files_upload_{{$vo['field']}}Action">开始上传</button> &nbsp; <span style="color:red">多文件上传在选择文件后点击开始上传才真正完成上传</span>
						</div>
					</div>
				</div>