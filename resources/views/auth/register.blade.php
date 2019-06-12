@extends('layouts.base')

@section('title', '注册')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/booleanTools/style/login.css')}}" media="all">
@endpush

@section('content')
@include('auth.nav')
<div class="layadmin-user-login layadmin-user-display-show" id="login">
	<div class="layadmin-user-login-main">
		<div class="layadmin-user-login-box layadmin-user-login-header">
			<h2>用户注册<span class="layui-badge" style="position: relative;top:-30px; margin-left: 10px;">beta</span></h2>
		</div>
		<div class="layadmin-user-login-box layadmin-user-login-body layui-form">
		<form action="" method="post">
			@csrf
			<div class="layui-form-item">
				<label class="layadmin-user-login-icon layui-icon layui-icon-username" for="login-name"></label>
				<input type="text" name="name" id="login-name" lay-verify="required" lay-verType="tips" placeholder="昵称 /  姓名" autocomplete="new-password" class="layui-input">
			</div>
			<div class="layui-form-item">
				<label class="layadmin-user-login-icon layui-icon layui-icon-component" for="login-email"></label>
				<input type="text" name="email" id="login-email" lay-verify="email" lay-verType="tips" placeholder="邮箱" autocomplete="new-password" class="layui-input">
			</div>
			<div class="layui-form-item">
				<label class="layadmin-user-login-icon layui-icon layui-icon-cellphone-fine" for="login-email"></label>
				<input type="text" name="phone" id="login-email" lay-verify="phone" lay-verType="tips" placeholder="手机号码" autocomplete="new-password" class="layui-input">
			</div>
			<div class="layui-form-item">
				<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="login-password"></label>
				<input type="password" name="password" id="login-password" lay-verify="required|pass" lay-verType="tips" placeholder="密码" autocomplete="new-password" class="layui-input">
			</div>
			<div class="layui-form-item">
				<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="login-password-confirm"></label>
				<input type="password" name="password_confirmation" id="login-password-confirm" lay-verify="required" lay-verType="tips" placeholder="确认密码" autocomplete="new-password" class="layui-input">
			</div>
			<div class="layui-form-item">
				<input type="checkbox" name="agreement" lay-skin="primary" lay-verType="tips" title="同意用户协议" checked>
			</div>
			<div class="layui-form-item">
				<button class="layui-btn layui-btn-fluid" lay-submit lay-filter="reg-submit">注 册</button>
			</div>
			<div class="layui-trans layui-form-item layadmin-user-login-other">
				<label>社交账号注册</label>
				<a href="javascript:;"><i class="layui-icon layui-icon-login-qq"></i></a>
				<a href="javascript:;"><i class="layui-icon layui-icon-login-wechat"></i></a>
				<a href="javascript:;"><i class="layui-icon layui-icon-login-weibo"></i></a>

				<a href="{{url('login')}}" class="layadmin-user-jump-change layadmin-link layui-hide-xs">用已有帐号登入</a>
				<a href="{{url('login')}}" class="layadmin-user-jump-change layadmin-link layui-hide-sm layui-show-xs-inline-block">登入</a>
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
	}).use(['index', 'jquery', 'form', 'element'], function(){
		var $ = layui.$,
			setter = layui.setter,
			admin = layui.admin,
			form = layui.form,
			router = layui.router();

		form.render();
		
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		//提交
		form.on('submit(reg-submit)', function(obj) {
			var field = obj.field;
			alert(field.password);alert(field.password_confirmation);
			//alert(JSON.stringify(field));
			//确认密码
			if (field.password !== field.password_confirmation) {
				return layer.msg('两次密码输入不一致');
			}

			//是否同意用户协议
			if (!field.agreement) {
				return layer.msg('你必须同意用户协议才能注册');
			}
			
			return true;
		});
	});
</script>
@endpush