@extends('blk.datatable.base')

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
			<form class="layui-form" method="post" enctype="multipart/form-data" action="">
				@csrf
				@include ('blk.datatable.form_input')
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
		index: 'lib/index',
		formSelects: 'formSelects-v4'
	}).use(['jquery', 'form', 'layer', 'layedit', 'laydate', 'element', 'slider', 'table','colorpicker', 'upload', 'formSelects'], function() {
			var $ = layui.$,
				form = layui.form,
				layer = layui.layer,
				layedit = layui.layedit,
				laydate = layui.laydate,
				element = layui.element,
				slider = layui.slider,
				table = layui.table,
				upload = layui.upload,
				colorpicker = layui.colorpicker,
				formSelects = layui.formSelects;
				
			@include ('blk.datatable.form_js')
			
			
		});
</script>
@endpush
