@extends('layouts.base')

@section('title', '登录')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/blk/style/login.css')}}" media="all">
@endpush

@section('content')
<div style="padding:30px;">
	<img width="400" src="{{file_path('/include/images/logo.png')}}" />
</div>
<div style="background-image:url({{file_path('/include/images/banner.png')}}); border-top:4px solid rgb(0,170,136); height:445px; background-position:bottom;">
	<div class="layadmin-user-login-main" style="margin-top:30px; background-color:#fff;">
		<br/>
		<div class="layadmin-user-login-box layadmin-user-login-header">
			<h2>绩效考核管理系统<span class="layui-badge" style="position: relative;top:-30px;">2.0 beta</span></h2>
		</div>
		<div class="layadmin-user-login-box layadmin-user-login-body layui-form">
			<form action="" method="post">
				@csrf
				<div class="layui-form-item">
					<label class="layadmin-user-login-icon layui-icon layui-icon-username" for="email"></label>
					<input type="text" name="username" id="username" lay-verify="required" value="{{ old('email') }}" placeholder="姓名" autocomplete="new-password" class="layui-input">
				</div>
				<div class="layui-form-item">
					<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="password"></label>
					<input type="password" name="password" id="password" lay-verify="required" placeholder="密码" autocomplete="new-password" class="layui-input">
				</div>
				<!-- <div class="layui-form-item">
					<div class="layui-row">
						<div class="layui-col-xs7">
							<label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="vercode"></label>
							<input type="text" name="vercode" id="vercode" lay-verify="required" placeholder="图形验证码" autocomplete="new-password" class="layui-input">
						</div>
						<div class="layui-col-xs5">
							<div style="margin-left: 10px;">
								<img src="{}?rand={{time()}}" lay-filter="vercode" style="height: 37px;" class="layadmin-user-login-codeimg" id="vercode">
							</div>
						</div>
					</div>
				</div> 
				<div class="layui-form-item" style="margin-bottom: 20px;">
					<input type="checkbox" name="remember" lay-skin="primary" title="记住密码">
					<a href="{{url('password/reset')}}" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">忘记密码？</a>
				</div>-->
				<div class="layui-form-item">
					<button class="layui-btn layui-btn-fluid" lay-submit lay-filter="submit">登 入</button>
				</div>
			</form>
			<div class="layui-trans layui-form-item layadmin-user-login-other">
				
			</div>
		</div>
	</div>
	<div style="text-align:center;">
		CopyRight © 2018 sxggzyfw.com 陕西省公共资源交易服务有限公司 All Rights Reserved
	</div>
</div>
@endsection

@push('scripts')
<script>
	if (window!=top){
		top.location.href =window.location.href;
	}

	layui.config({
	    base: '{{file_path('/include/blk/lib/')}}',
	}).extend({
	    index: 'index',
	}).use(['index', 'jquery', 'form', 'element'], function(){
		var form = layui.form;
        var element = layui.element;
        var $ = layui.$;
		
        $(document).on('click', '#vercode', function(data) {
            $(this).attr('src', 'captcha.html?rand={:time()}');
        });
	});
</script>
@endpush