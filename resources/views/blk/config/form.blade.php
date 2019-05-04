@extends('blk.datatable.base')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/blk/style/formSelects-v4.css')}}" media="all">
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
			<br/>
			<form class="layui-form" method="post" enctype="multipart/form-data" action="">
				@csrf
				<div class="layui-tab" lay-filter="config">
					<ul class="layui-tab-title">
						@if (isset($config['config_set'])?$config['config_set']:false)
						@foreach ($config['config_set'] as $ko)
						<li @if ($loop->first) class="layui-this" @endif lay-id="{{$ko['tag']}}">{{$ko['name']}}</li>
						@endforeach
						@endif
					</ul>
					<div class="layui-tab-content">
						<br/>
						@if (isset($config['config_set'])?$config['config_set']:false)
						@foreach ($config['config_set'] as $value)
						<div class="layui-tab-item @if ($loop->first)  layui-show @endif ">
						    @foreach ($value['fields'] as $key=>$vo)
						    @include ('blk.datatable.form.'.$vo['data_input_form'])
						    @endforeach
							<div class="layui-form-item">
								<label class="layui-form-label">&nbsp;</label>
								<div class="layui-input-block">
									<button class="layui-btn" lay-submit="" lay-filter="demo2">提交</button>
								</div>
							</div>
						</div>
						@endforeach
						@endif
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
		base: '{{file_path('/include/blk/lib/')}}',
	}).extend({
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
			
		{{-- 表单控件初始化 --}}
		@if (isset($config['config_set'])?$config['config_set']:false)
		@foreach ($config['config_set'] as $value)
		@foreach ($value['fields'] as $key=>$vo)
		@include ('blk.datatable.form_js.'.$vo['data_input_form'])
		@endforeach
		@endforeach
		@endif
	});
</script>
@endpush
