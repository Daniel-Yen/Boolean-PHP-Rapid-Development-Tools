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
	
	@if (isset($search_conditions_dic_arr))
	<style type="text/css">
		.search-type{width:100px; padding:0; height:auto; text-align:center;}
		.layui-input-block{margin-left:220px; width:300px;}
		.layui-input-inline{padding-left:10px;}
	</style>
	@endif
	
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