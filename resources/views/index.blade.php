@extends('layouts.base')

@section('title', '布尔快速开发工具')

@push('css')

@endpush

@section('content')
<div id="LAY_app">
	<div class="layui-layout layui-layout-admin">
		<div class="layui-header">
			<!-- 头部区域 -->
			<ul class="layui-nav layui-layout-left">
				<li class="layui-nav-item layadmin-flexible" lay-unselect>
					<a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
						<i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
					</a>
				</li>
				<li class="layui-nav-item layui-hide-xs" lay-unselect>
					<a href="http://lazykit.buersoft.cn/" target="_blank" title="前台">
						<i class="layui-icon layui-icon-website"></i>
					</a>
				</li>
				<li class="layui-nav-item" lay-unselect>
					<a href="javascript:;" layadmin-event="refresh" title="刷新">
						<i class="layui-icon layui-icon-refresh-3"></i>
					</a>
				</li>
				<!-- <li class="layui-nav-item layui-hide-xs" lay-unselect>
					<input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach"
					 lay-action="template/search.html?keywords=">
				</li> -->
			</ul>
			<ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
				<li class="layui-nav-item" lay-unselect>
					<a lay-href="app/message/index.html" layadmin-event="message" lay-text="消息中心">
						<i class="layui-icon layui-icon-notice"></i>
						<!-- 如果有新消息，则显示小圆点 -->
						<span class="layui-badge-dot"></span>
					</a>
				</li>
				<li class="layui-nav-item layui-hide-xs" lay-unselect>
					<a href="javascript:;" layadmin-event="theme">
						<i class="layui-icon layui-icon-theme"></i>
					</a>
				</li>
				<li class="layui-nav-item layui-hide-xs" lay-unselect>
					<a href="javascript:;" layadmin-event="fullscreen">
						<i class="layui-icon layui-icon-screen-full"></i>
					</a>
				</li>
				<li class="layui-nav-item" lay-unselect>
					<a href="javascript:;">
						<cite>{{ Auth::user()->name }}</cite>
					</a>
					<dl class="layui-nav-child" style="text-align: center;">
						<dd><a lay-href="{{url('user/user/update_user')}}">个人资料</a></dd>
						<dd><a lay-href="{{url('user/user/update_user_password')}}">修改密码</a></dd>
						<hr>
						<dd><a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{route('logout')}}">退出</a></dd>
					</dl>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					    @csrf
					</form>
				</li>

				<li class="layui-nav-item layui-hide-xs" lay-unselect>
					<a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
				</li>
				<li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
					<a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
				</li>
			</ul>
		</div>

		<!-- 侧边菜单 -->
		<div class="layui-side layui-side-menu">
			<div class="layui-side-scroll">
				<div class="layui-logo" lay-href="{{url('/welcome')}}">
					<span>
						<h3>布尔快速开发工具</h3>
					</span>
				</div>

				<ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
					@foreach ($menu as $v)
					<li data-name="home" class="layui-nav-item @if($loop->first) layui-nav-itemed @endif ">
						<a href="javascript:;" lay-tips="{{$v['title']}}" lay-direction="2">
							<i class="layui-icon layui-icon-home"></i>
							<cite>{{$v['title']}}</cite>
						</a>
						@if (isset($v['children']))
						<dl class="layui-nav-child">
							@foreach ($v['children'] as $y)
							<dd data-name="nav{{$y['id']}}">
								@if (isset($y['children']))
								<a href="javascript:;">{{$y['title']}}</a>
								<dl class="layui-nav-child">
									@foreach ($y['children'] as $h)
									<dd data-name="nav{{$h['id']}}"><a lay-href="{{$h['url']}}">{{$h['title']}}</a></dd>
									@endforeach
								</dl>
								@else
								<a lay-href="{{$y['url']}}">{{$y['title']}}</a>
								@endif
							</dd>
							@endforeach
						</dl>
						@endif
					</li>
					@endforeach
				</ul>
			</div>
		</div>

		<!-- 页面标签 -->
		<div class="layadmin-pagetabs" id="LAY_app_tabs">
			<div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
			<div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
			<div class="layui-icon layadmin-tabs-control layui-icon-down">
				<ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
					<li class="layui-nav-item" lay-unselect>
						<a href="javascript:;"></a>
						<dl class="layui-nav-child layui-anim-fadein">
							<dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
							<dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
							<dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
						</dl>
					</li>
				</ul>
			</div>
			<div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
				<ul class="layui-tab-title" id="LAY_app_tabsheader">
					<li lay-id="{{url('/welcome')}}" lay-attr="{{url('/welcome')}}" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
				</ul>
			</div>
		</div>

		<!-- 主体内容 -->
		<div class="layui-body" id="LAY_app_body">
			<div class="layadmin-tabsbody-item layui-show">
				<iframe src="{{url('/welcome')}}" frameborder="0" class="layadmin-iframe"></iframe>
			</div>
		</div>

		<!-- 辅助元素，一般用于移动设备下遮罩 -->
		<div class="layadmin-body-shade" layadmin-event="shade"></div>
	</div>
</div>
@endsection

@push('scripts')
<script>
layui.config({
    base: '{{file_path('/include/booleanTools/lib/')}}',
}).extend({
    index: 'index',
}).use('index');
</script>
@endpush