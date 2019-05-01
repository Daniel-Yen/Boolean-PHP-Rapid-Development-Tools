@extends('layouts.base')

@section('title', 'Chart配置生成')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/blk/style/template.css')}}" media="all">
<style>
	.main{min-height:350px;border:0px solid #e2e2e2; margin:0 10px 20px 0;}
	.mark{width:120px; float:left; margin-right:10px;}
	.layui-input-mark{width:120px; height:30px;}
	.dragsort{cursor: move;}
	.info{padding:10px 5px; text-align:center;}
</style>
@endpush

@section('content')
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<form class="layui-form" action="" method="post">
			@csrf
			<div class="layui-tab layui-tab-brief">
				<ul class="layui-tab-title">
					<li>配置信息</li>
					<li class="layui-this">图表布局</li>
					<li>图表参数设置</li>
				</ul>
				<div class="layui-tab-content">
					<div class="layui-tab-item">
						<table class='layui-table'>
							<tbody>
								<tr>
									<td width="85">页面名称：</td>
									<td>{{!empty($function_page['title'])?$function_page['title']:''}}</td>
								</tr>
								<tr>
									<td width="85">页面模型：</td>
									<td>统计图表（Chart）</td>
								</tr>
								<tr>
									<td>所属系统：</td>
									<td>{{!empty($system['system_name'])?$system['system_name']:''}} <span class="layui-badge layui-bg-gray">系统路径：{{$system['file_path']}}</span></td>
								</tr>
								<tr>
									<td>所属模块：</td>
									<td>{{!empty($module['module_name'])?$module['module_name']:''}} <span class="layui-badge layui-bg-gray">模块目录：{{$module['module']}}</span></td>
								</tr>
								<tr>
									<td>配置路径：</td>
									<td>{{$system->file_path}}{{DIRECTORY_SEPARATOR}}app{{DIRECTORY_SEPARATOR}}Blk{{DIRECTORY_SEPARATOR}}chart_{{$design_id}}.php  &nbsp; 
									<a id="preview" class="layui-btn layui-btn-primary layui-btn-sm">预览配置文件</a></td>
								</tr>
								<tr>
									<td>路由地址：</td>
									<td>{{$route_message['route_path']}}{{$route_message['route_name']}}</td>
								</tr>
								<tr>
									<td>控制器文件：</td>
									<td>
										{{$route_message['namespace']}}\{{$route_message['controller']}}.php &nbsp; 
										@if ($route_message['controller_exists']) <span class="layui-badge layui-bg-blue">存在</span> @else <span class="layui-badge">不存在</span> @endif &nbsp;
										方法：{{$route_message['method']}} &nbsp; 
										@if ($route_message['method_exists']) <span class="layui-badge layui-bg-blue">存在</span> @else <span class="layui-badge">不存在</span> @endif  &nbsp;
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="layui-tab-item layui-show">
						@include ('lazykit.chart.data_source')
					</div>
					<div class="layui-tab-item">
						@include ('lazykit.chart.data_source_set')
					</div>
				</div>
			</div>
			<form>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script src="{{file_path('/include/blk/plugin/jquery.min.js')}}"></script>
<script src="{{file_path('/include/blk/plugin/drag-arrange.js')}}"></script>
<script>
layui.config({
    base: '{{file_path('/include/blk/lib/')}}',
}).extend({
	echarts: 'extend/echarts',
	echartsTheme: 'extend/echartsTheme'
}).use(['jquery', 'form', 'layer', 'element', 'echarts'], function() {
		var $ = layui.$,
			form = layui.form,
			layer = layui.layer,
			echarts = layui.echarts;

		$('.drag-able').arrangeable({dragSelector: '.dragsort'});

		$(document).on('click','#preview',function(){
			layer.open({
				type: 2
				,title: '预览统计图表配置文件（chart_{{$design_id}}）'
				,area: ['80%', '95%']
				,shade: 0.3
				,maxmin: false
				,offset: 'auto' 
				,content: '/lazykit/function_page/preview?design_id={{$design_id}}'
			});
		});
		
		//$(".chart_main:first").dragsort();
		
		var _tools = {
			layerCloseAll: function() {
				layer.closeAll();
			},
			//title:表字段名称, field:字段, field_from:字段类型
			openDialog: function(title, field, field_from) {
				var url = '{{url("lazykit/functionpage/attribute_set")}}?system_id={{$system_id}}&design_id={{$design_id}}&field=' + field + '&field_from=' + field_from;
				//执行重载
				layer.open({
					id: 'layerDemo',
					type: 2,
					title: '附加属性设置：' + title + '（' + field + '）',
					offset: 'lt',
					area: ['90%', '100%'],
					content: url,
					shade: 0.3,
					scrollbar: false,
				});
			},
			delete: function(chart_id) {
				layer.confirm("请确认当前操作?", {icon:3, title:'温馨提示'}, function() {
					$("#"+chart_id).remove();
					layer.closeAll();
				});
			},
			add: function(key) {
				$("#chart_id").val(key);
				$("#chart_tpl").removeClass('layui-hide');
				layer.open({
					type: 1
					,title: '选择统计图表模板'
					,area: ['100%', '100%']
					,shade: 0.3
					,maxmin: false
					,offset: 'auto' 
					,content: $("#chart_tpl")
					,scrollbar: false
					,cancel: function(index, layero){ 
					    $("#chart_tpl").addClass('layui-hide');
					    layer.close(index);
						return false; 
					}
				});
				
			},
			edit: function(key) {
				$("#chart_id").val(key);
				$("#chart_attribute_set").removeClass('layui-hide');
				layer.open({
					type: 2
					,title: '选择统计图表模板'
					,area: ['100%', '100%']
					,shade: 0.3
					,maxmin: false
					,offset: 'auto' 
					,content: '/lazykit/function_page/chart_attribute_set?system_id={{$system_id}}&design_id={{$design_id}}&key='+key
					,scrollbar: false
					,cancel: function(index, layero){ 
					    $("#chart_attribute_set").addClass('layui-hide');
					    layer.close(index);
						return false; 
					}
				});
				
			},
			select_chart: function(option, key){
				if(key == ''){
					var key = $("#chart_id").val();
				}
				
				$("#chart_set_"+key+"_option").val(JSON.stringify(option));
				
				var ech = []
				,myOption = option
				,myChart = $('#Blk-chart-'+key)
				,renderchart = function(index){
				  ech[index] = echarts.init(myChart[index], layui.echartsTheme);
				  ech[index].setOption(myOption);
				  window.onresize = ech[index].resize;
				};
				if(!myChart[0]) return;
				renderchart(0);
				
				$("#chart_tpl").addClass('layui-hide');
				
				layer.closeAll();
			}
		}
		window.tools = _tools;
		
		@if (isset($chart_config['chart_set']))
		@foreach ($chart_config['chart_set'] as $key=>$vo)
		tools.select_chart({!! $vo['option'] !!}, '{{$key}}');
		@endforeach
		@endif
	});
</script>
@endpush