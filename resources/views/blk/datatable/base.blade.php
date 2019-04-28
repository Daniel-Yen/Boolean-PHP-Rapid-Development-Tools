<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="background-color:#fff;">
<head>
  <meta charset="utf-8">
  <title>@yield('title')</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="{{file_path('/include/layui/css/layui.css')}}" media="all">
  <link rel="stylesheet" href="{{file_path('/include/style/admin.css')}}" media="all">
  <link rel="stylesheet" href="{{file_path('/include/eleTree.css')}}" media="all">
  <link rel="stylesheet" href="{{file_path('/include/cascader.css')}}" media="all">
  
	@stack('css')
	
	<style type="text/css">
		.title{width:130px; height:20px; line-height:25px;}
		.layui-input-block{margin-left:160px;}
		@if (isset($search_conditions_dic_arr))
		.search-type{width:100px; padding:0; height:auto; text-align:center;}
		.layui-form-item .layui-input-inline{width:274px;}
		.layui-input-block{width:274px; margin-left:10px; float:left; display:inline-block; vertical-align:middle;}
		.layui-input-inline{padding-left:10px;}
		.layui-input-search{float:left;}
		.search-type input{text-align:center; padding-left:0;}
		.padding-left-0{padding-left:0;}
		.search-block{width:555px}
		@endif
	</style>
	
  <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
	@yield('content')
	<script src="{{file_path('/include/layui/layui.js')}}"></script>
	@stack('scripts')
</body>
</html>