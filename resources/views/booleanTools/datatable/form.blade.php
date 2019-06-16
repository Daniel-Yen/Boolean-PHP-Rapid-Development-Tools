@extends('booleanTools.datatable.base')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/booleanTools/kindeditor/themes/default/kindediter-layui.css')}}" media="all">
<link rel="stylesheet" href="{{file_path('/include/booleanTools/style/formSelects-v4.css')}}" media="all">
<style type="text/css">
	.layui-table-tool {background-color: #FFFFFF;}
	.layui-table-view {margin: 0;}
	.layui-form-label { overflow: hidden; height: 10px; line-height: 20px;}
	.layui-upload-img-main {margin: 0 10px 15px 0;}
	.layui-upload-img-main .layui-upload-img {margin-bottom: 10px; max-height: 200px; max-width: 100%;}
</style>
<script charset="utf-8" src="{{file_path('/include/booleanTools/kindeditor/kindeditor-all.js')}}"></script>
<script charset="utf-8" src="{{file_path('/include/booleanTools/kindeditor/lang/zh-CN.js')}}"></script>
@endpush

@section('content')
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<br/>
			<br/>
			<form class="layui-form" method="post" enctype="multipart/form-data" action="">
				@csrf
				@foreach ($dom as $key=>$vo)
				@include ('booleanTools.datatable.form.'.$vo['data_input_form'])
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
<script>
	layui.config({
		base: '{{file_path('/include/booleanTools/lib/')}}',
	}).extend({
		index: 'index',
		formSelects: 'modules/formSelects-v4'
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
		
		
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		{{-- 表单控件初始化 --}}
		@foreach ($dom as $key=>$vo)
		@include ('booleanTools.datatable.form_js.'.$vo['data_input_form'])
		@endforeach
	});
</script>
@endpush
