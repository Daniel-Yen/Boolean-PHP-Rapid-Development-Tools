@extends('layouts.base')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/editormd/css/editormd.css')}}" media="all">
<link rel="stylesheet" href="{{file_path('/include/formSelects-v4.css')}}" media="all">
<style type="text/css">
	.layui-table-tool {background-color: #FFFFFF;}
	.layui-table-view {margin: 0;}
	.layui-form-label { overflow: hidden; height: 10px; line-height: 20px;}
	.layui-upload-img {width: 150px; margin: 0 10px 15px 0;}
</style>
@endpush

@section('content')
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<form class="layui-form" method="post" action="">
				@csrf
				@foreach ($dom as $key=>$vo)
				@switch($vo['data_input_form'])
				@case('input')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<input type="text" name="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" placeholder="请输入{{$vo['title']}}" autocomplete="off" class="layui-input">
					</div>
				</div>
				@break
				@case('textarea')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<textarea name="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" placeholder="请输入{{$vo['title']}}" autocomplete="off" class="layui-textarea">{{$data_arr[$vo['field']]}}</textarea>
					</div>
				</div>
				@break
				@case('select')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						@if ( isset($vo['dic_data']['code'])?$vo['dic_data']['code'] == 0:false )
						<select name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" xm-select-skin="default" xm-select="{{$vo['field']}}" xm-select-radio>
							<option value="">请选择</option>
						</select>
						@else
						<div class="layui-form-mid layui-word-aux"><span class="layui-badge">{{$vo['dic_data']['msg']}}</span></div>
						@endif
					</div>
				</div>	
				@break
				@case('tree_select')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						@if ( isset($vo['dic_data']['code'])?$vo['dic_data']['code'] == 0:false )
						<select name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" xm-select-skin="default" xm-select="{{$vo['field']}}" xm-select-radio>
							<option value="">请选择</option>
						</select>
						@else
						<div class="layui-form-mid layui-word-aux"><span class="layui-badge">{{$vo['dic_data']['msg']}}</span></div>
						@endif
					</div>
				</div>	
				@break
				@case('multiple_select')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						@if ( isset($vo['dic_data']['code'])?$vo['dic_data']['code'] == 0:false )
						<select name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" xm-select-skin="default" xm-select="{{$vo['field']}}">
							<option value="">请选择</option>
						</select>
						@else
						<div class="layui-form-mid layui-word-aux"><span class="layui-badge">{{$vo['dic_data']['msg']}}</span></div>
						@endif
					</div>
				</div>	
				@break
				@case('cascade_select')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						@if ( isset($vo['dic_data']['code'])?$vo['dic_data']['code'] == 0:false )
						<select name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" xm-select-skin="default" xm-select="{{$vo['field']}}" xm-select-radio>
							<option value="">请选择</option>
						</select>
						@else
						<div class="layui-form-mid layui-word-aux"><span class="layui-badge">{{$vo['dic_data']['msg']}}</span></div>
						@endif
					</div>
				</div>	
				@break
				@case('layui_editer')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<textarea class="layui-textarea" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" style="display: none">
							{{$data_arr[$vo['field']]}}
						</textarea>
					</div>
				</div>
				@break
				@case('layui_editer_simple')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<textarea class="layui-textarea" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" style="display: none">
							{{$data_arr[$vo['field']]}}
						</textarea>
					</div>
				</div>
				@break
				@case('editormd')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<div id="layout">
							<div id="editormd">
								<textarea name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" style="display:none;">
									{{$data_arr[$vo['field']]}}
								</textarea>
							</div>
						</div>
					</div>
				</div>
				@break
				@case('single_photo_upload')
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
				@break
				@case('photos_upload')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-block">
						<div class="layui-upload">
							<button type="button" class="layui-btn" id="photos_upload_{{$vo['field']}}">多图片上传</button>
							<div class="layui-upload-list" id="main{{$vo['field']}}">
								@if (empty($data_arr))
								@foreach ($data_arr[$vo['field']] as $vo)
								<img class="layui-upload-img" src="{{$vo['src']}}" id="pic{{$vo['field']}}">
								<textarea class="layui-hide" name="{{$vo['field']}}[{{$vo['id']}}]"> @json($vo) </textarea>
								@endforeach
								@endif
							</div>
						</div>
					</div>
				</div>
				@break
				@case('single_file_upload')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
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
				@break
				@case('files_upload')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
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
				@break
				@case('year')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" placeholder="yyyy">
					</div>
				</div>
				@break
				@case('year_mouth')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" placeholder="yyyy-MM">
					</div>
				</div>
				@break
				@case('date')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" placeholder="yyyy-MM-dd">
					</div>
				</div>
				@break
				@case('time')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" placeholder="HH:mm:ss">
					</div>
				</div>
				@break
				@case('datetime')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" placeholder="yyyy-MM-dd HH:mm:ss">
					</div>
				</div>
				@break
				@case('date_scope')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" placeholder=" - ">
					</div>
				</div>
				@break
				@case('year_scope')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" placeholder=" - ">
					</div>
				</div>
				@break
				@case('year_mouth_scope')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" placeholder=" - ">
					</div>
				</div>
				@break
				@case('time_scope')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" placeholder=" - ">
					</div>
				</div>
				@break
				@case('datetime_scope')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-inline">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}" value="{{$data_arr[$vo['field']]}}" placeholder=" - " style="width:380px;">
					</div>
				</div>
				@break
				@case('color_choices')
				<div class="layui-form-item">
					<label class="layui-form-label">{{$vo['title']}}</label>
					<div class="layui-input-inline" style="width: 120px;">
						<input type="text" class="layui-input" name="{{$vo['field']}}" lay-verify="lazykit_{{$vo['field']}}" lay-verType="tips" id="{{$vo['field']}}-input" value="{{$data_arr[$vo['field']]}}" placeholder="请选择颜色">
					</div>
					<div class="layui-inline" style="left: -11px;">
						<div id="{{$vo['field']}}"></div>
					</div>
				</div>
				@break
				@endswitch
				@endforeach
				<div class="layui-form-item">
					<label class="layui-form-label">&nbsp;</label>
					<div class="layui-input-block">
						<button class="layui-btn" lay-submit="" lay-filter="demo2">提交</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script src="{{file_path('/include/editormd/examples/js/jquery.min.js')}}"></script>
<script src="{{file_path('/include/editormd/editormd.js')}}"></script>
<script>
	$(function() {
		var testEditor = editormd("editormd", {
			width: "100%",
			height: 640,
			markdown: "",
			path: '{{file_path('/include/editormd/lib/')}}',
			//dialogLockScreen : false,   // 设置弹出层对话框不锁屏，全局通用，默认为 true
			//dialogShowMask : false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为 true
			//dialogDraggable : false,    // 设置弹出层对话框不可拖动，全局通用，默认为 true
			//dialogMaskOpacity : 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为 0.1
			//dialogMaskBgColor : "#000", // 设置透明遮罩层的背景颜色，全局通用，默认为 #fff
			imageUpload: true,
			imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
			imageUploadURL: "./php/upload.php?test=dfdf",
	
			/*
			 上传的后台只需要返回一个 JSON 数据，结构如下：
			 {
			    success : 0 | 1,           // 0 表示上传失败，1 表示上传成功
			    message : "提示的信息，上传成功或上传失败及错误信息等。",
			    url     : "图片地址"        // 上传成功时才返回
			 }
			 */
		});
	});

	layui.config({
		base: '{{file_path('/include/')}}',
	}).extend({
		index: 'lib/index', //主入口模块
		formSelects: 'formSelects-v4'
	}).use(['jquery', 'form', 'layer', 'eleTree', 'layedit', 'laydate', 'element', 'slider', 'table','colorpicker', 'upload', 'formSelects'], function() {
			var $ = layui.$,
				form = layui.form,
				layer = layui.layer,
				eleTree = layui.eleTree, //树下拉选择
				layedit = layui.layedit,
				laydate = layui.laydate,
				element = layui.element,
				slider = layui.slider,
				table = layui.table,
				upload = layui.upload,
				formSelects = layui.formSelects,
				colorpicker = layui.colorpicker;
				
			@include ('blk.datatable.create_js')
			
			
		});
</script>
@endpush
