<div class="layui-layout layui-layout-admin">
	<div class="layui-header">
		<!-- 头部区域 -->
		<ul class="layui-nav">
			<li class="layui-nav-item layadmin-flexible" lay-unselect>
				<span>
					<h2 style="font-size: 20px;">Boolean Lazy Kit</h2>
				</span>
			</li>
			<li class="layui-nav-item layui-hide-xs">
				<a href="http://www.layui.com/admin/" target="_blank" title="前台">
					<i class="layui-icon layui-icon-website"></i>
				</a>
			</li>
		</ul>
		<ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
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
		</ul>
	</div>
	<!-- 辅助元素，一般用于移动设备下遮罩 -->
	<div class="layadmin-body-shade" layadmin-event="shade"></div>
</div>