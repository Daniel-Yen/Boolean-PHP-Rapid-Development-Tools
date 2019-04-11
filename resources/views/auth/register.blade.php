@extends('layouts.base')

@section('title', '注册')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/style/login.css')}}" media="all">
@endpush

@section('content')
@include('auth.nav')
<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login">
	<div class="layadmin-user-login-main">
		<div class="layadmin-user-login-box layadmin-user-login-header">
			<h2>用户注册<span class="layui-badge" style="position: relative;top:-30px; margin-left: 10px;">beta</span></h2>
		</div>
		<div class="layadmin-user-login-box layadmin-user-login-body layui-form">
			<div class="layui-form-item">
				<label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-name"></label>
				<input type="text" name="name" id="LAY-user-login-name" lay-verify="required" placeholder="昵称 /  姓名" class="layui-input">
			</div>
			<div class="layui-form-item">
				<label class="layadmin-user-login-icon layui-icon layui-icon-mail" for="LAY-user-login-email"></label>
				<input type="text" name="email" id="LAY-user-login-email" lay-verify="email" placeholder="邮箱" class="layui-input">
			</div>
			<div class="layui-form-item">
				<div class="layui-row">
					<div class="layui-col-xs7">
						<label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
						<input type="text" name="vercode" id="LAY-user-login-vercode" lay-verify="required" placeholder="验证码" class="layui-input">
					</div>
					<div class="layui-col-xs5">
						<div style="margin-left: 10px;">
							<button type="button" class="layui-btn layui-btn-primary layui-btn-fluid" id="LAY-user-getsmscode">获取验证码</button>
						</div>
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
				<input type="password" name="password" id="LAY-user-login-password" lay-verify="pass" placeholder="密码" class="layui-input">
			</div>
			<div class="layui-form-item">
				<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password-confirm"></label>
				<input type="password" name="password-confirm" id="LAY-user-login-password-confirm" lay-verify="required" placeholder="确认密码" class="layui-input">
			</div>
			<div class="layui-form-item">
				<input type="checkbox" name="agreement" lay-skin="primary" title="同意用户协议" checked>
			</div>
			<div class="layui-form-item">
				<button class="layui-btn layui-btn-fluid" lay-submit lay-filter="LAY-user-reg-submit">注 册</button>
			</div>
			<div class="layui-trans layui-form-item layadmin-user-login-other">
				<label>社交账号注册</label>
				<a href="javascript:;"><i class="layui-icon layui-icon-login-qq"></i></a>
				<a href="javascript:;"><i class="layui-icon layui-icon-login-wechat"></i></a>
				<a href="javascript:;"><i class="layui-icon layui-icon-login-weibo"></i></a>

				<a href="{{url('login')}}" class="layadmin-user-jump-change layadmin-link layui-hide-xs">用已有帐号登入</a>
				<a href="{{url('login')}}" class="layadmin-user-jump-change layadmin-link layui-hide-sm layui-show-xs-inline-block">登入</a>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	layui.config({
		base: '{{file_path('/include/')}}' //静态资源所在路径
	}).extend({
		index: 'lib/index' //主入口模块
	}).use(['index', 'jquery', 'form', 'element'], function(){
		var $ = layui.$,
			setter = layui.setter,
			admin = layui.admin,
			form = layui.form,
			router = layui.router();

		form.render();

		//提交
		form.on('submit(LAY-user-reg-submit)', function(obj) {
			var field = obj.field;

			//确认密码
			if (field.password !== field.password-confirm) {
				return layer.msg('两次密码输入不一致');
			}

			//是否同意用户协议
			if (!field.agreement) {
				return layer.msg('你必须同意用户协议才能注册');
			}

			//请求接口
			admin.req({
				url: layui.setter.base + 'json/user/reg.js' //实际使用请改成服务端真实接口
					,
				data: field,
				done: function(res) {
					layer.msg('注册成功', {
						offset: '15px',
						icon: 1,
						time: 1000
					}, function() {
						location.hash = '/user/login'; //跳转到登入页
					});
				}
			});

			return false;
		});
	});
</script>
@endpush