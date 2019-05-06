@extends('blk.datatable.base')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/editormd/css/editormd.css')}}" media="all">
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
			<br/>
			<form class="layui-form" method="post" enctype="multipart/form-data" action="">
				@csrf
				<div class="layui-form-item">
					<label class="layui-form-label title">原密码</label>
					<div class="layui-input-inline">
						<input type="text" name="password" value="" lay-verify="lazykit_password" lay-verType="tips" placeholder="请输入原密码" autocomplete="password" onfocus="this.type='password'" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label title">新密码</label>
					<div class="layui-input-inline">
						<input type="text" name="new_password" value="" lay-verify="lazykit_new_password" lay-verType="tips" placeholder="请输入新密码" autocomplete="off" onfocus="this.type='password'" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label title">重复新密码</label>
					<div class="layui-input-inline">
						<input type="text" name="repeat_new_password" value="" lay-verify="lazykit_repeat_new_password" lay-verType="tips" placeholder="请再次输入原密码" autocomplete="off" onfocus="this.type='password'" class="layui-input">
					</div>
				</div>
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
		base: '{{file_path('/include/blk/lib/')}}',
	}).use(['jquery', 'form', 'element'], function() {
			var $ = layui.$,
				form = layui.form,
				element = layui.element;
			
		});
</script>
@endpush
