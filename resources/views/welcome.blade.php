@extends('layouts.base')

@section('title', '首页')

@push('css')

@endpush

@section('content')
<div class="layui-fluid">
	<div class="layui-row layui-col-space15" style="backgroud-color:#000;">
		<div class="layui-col-sm6 layui-col-md3">
			<div class="layui-card">
				<div class="layui-card-header">
					系统数量
					<span class="layui-badge layui-bg-blue layuiadmin-badge">周</span>
				</div>
				<div class="layui-card-body layuiadmin-card-list">
					<p class="layuiadmin-big-font">9,999,666</p>
					<p>
						总计访问量
						<span class="layuiadmin-span-color">88万 <i class="layui-inline layui-icon layui-icon-flag"></i></span>
					</p>
				</div>
			</div>
		</div>
		<div class="layui-col-sm6 layui-col-md3">
			<div class="layui-card">
				<div class="layui-card-header">
					下载
					<span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span>
				</div>
				<div class="layui-card-body layuiadmin-card-list">
					<p class="layuiadmin-big-font">33,555</p>
					<p>
						新下载
						<span class="layuiadmin-span-color">10% <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
					</p>
				</div>
			</div>
		</div>
		<div class="layui-col-sm6 layui-col-md3">
			<div class="layui-card">
				<div class="layui-card-header">
					收入
					<span class="layui-badge layui-bg-green layuiadmin-badge">年</span>
				</div>
				<div class="layui-card-body layuiadmin-card-list">
		
					<p class="layuiadmin-big-font">999,666</p>
					<p>
						总收入
						<span class="layuiadmin-span-color">*** <i class="layui-inline layui-icon layui-icon-dollar"></i></span>
					</p>
				</div>
			</div>
		</div>
		<div class="layui-col-sm6 layui-col-md3">
			<div class="layui-card">
				<div class="layui-card-header">
					活跃用户
					<span class="layui-badge layui-bg-orange layuiadmin-badge">月</span>
				</div>
				<div class="layui-card-body layuiadmin-card-list">
		
					<p class="layuiadmin-big-font">66,666</p>
					<p>
						最近一个月
						<span class="layuiadmin-span-color">15% <i class="layui-inline layui-icon layui-icon-user"></i></span>
					</p>
				</div>
			</div>
		</div>
		<div class="layui-col-sm12">
			<div class="layui-card">
				<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
				  <ul class="layui-tab-title">
					<li class="layui-this">讨论区</li>
					<li>工单</li>
					<li>版本更新</li>
					<li>使用手册</li>
				  </ul>
				  <div class="layui-tab-content" style="height: 100px;">
					<div class="layui-tab-item layui-show">内容不一样是要有，因为你可以监听tab事件（阅读下文档就是了）</div>
					<div class="layui-tab-item">内容2</div>
					<div class="layui-tab-item">内容3</div>
				  </div>
				</div> 
			</div>
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
}).use('index', 'sample');
</script>
@endpush