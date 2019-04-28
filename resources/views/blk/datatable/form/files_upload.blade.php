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
										@if (empty($data_arr))
										@foreach ($data_arr[$vo['field']] as $vo)
										<tr>
											<td><a href="{{$vo['src']}}">{{$vo['name']}}</a></td>
											<td>{{$vo['size']}}</td>
											<td>已上传文件</td>
											<td>
												<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>
											</td>
										</tr>
										@endforeach
										@endif
									</tbody>
								</table>
							</div>
							<button type="button" class="layui-btn" id="files_upload_{{$vo['field']}}Action">开始上传</button>
						</div>
					</div>
				</div>