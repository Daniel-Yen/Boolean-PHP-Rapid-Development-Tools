@extends('layouts.base')

@section('title', 'Chart配置生成')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/booleanTools/style/template.css')}}" media="all">
<style>
	.create td{padding: 0;}
	.create td input{border: 0;}
	.create .switch_area{padding-bottom:8px; text-align: center;}
</style>
@endpush

@section('content')
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<form class="layui-form" action="" method="post">
			@csrf
			<div class="layui-tab layui-tab-brief" lay-filter="config">
				<ul class="layui-tab-title">
					<li lay-id="1">配置信息</li>
					<li lay-id="2" class="layui-this">配置管理</li>
					<li lay-id="3">配置字段设置</li>
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
									<td>配置文件（Config）</td>
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
									<td>{{$system->file_path}}{{DIRECTORY_SEPARATOR}}app{{DIRECTORY_SEPARATOR}}booleanTools{{DIRECTORY_SEPARATOR}}config_{{$design_id}}.php  &nbsp; 
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
						@include ('lazykit.config.data_source')
					</div>
					<div class="layui-tab-item">
						@include ('lazykit.config.data_source_set')
					</div>
				</div>
			</div>
			<form>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
layui.config({
    base: '{{file_path('/include/booleanTools/lib/')}}',
}).use(['jquery', 'form', 'layer', 'element'], function() {
		var $ = layui.$,
			form = layui.form,
			layer = layui.layer,
			element = layui.element;

		$(document).on('click','#addButton',function(){
			var html = '<tr>'
						+'<td><input type="text" name="config[name][]" value="" autocomplete="off" placeholder="请输入名称（站点设置）" lay-verify="required" class="layui-input"></td>'
						+'<td><input type="text" name="config[tag][]" value="" autocomplete="off" placeholder="请输入标识（site）" lay-verify="required" class="layui-input"></td>'
						+'<td><input type="text" name="config[describe][]" value="" autocomplete="off" placeholder="请输入描述" lay-verify="required" class="layui-input"></td>'
						+'<td style="text-align:center;"><a class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</a></td>'
					+'</tr>';
			$("#button_area").before(html);
			layui.form.render(); 	//重置表单
		});
		
		@if (isset($config['config_set'])?$config['config_set']:false)
		@foreach ($config['config_set'] as $ko)
		$(document).on('click','#add{{$ko['tag']}}',function(){
			var html = '<tr>'
						+'<td><input type="text" name="config_fields[{{$ko['tag']}}][field][]" value="" class="layui-input"></td>'
						+'<td><input type="text" name="config_fields[{{$ko['tag']}}][title][]" value="" class="layui-input"></td>'
						+'<td><input type="text" name="config_fields[{{$ko['tag']}}][sorting][]" value="" class="layui-input"></td>'
						+'<td><input type="text" name="config_fields[{{$ko['tag']}}][width][]" value="" class="layui-input"></td>'
						+'<td><input type="text" name="config_fields[{{$ko['tag']}}][instructions][]" value="" class="layui-input"></td>'
						+'<td></td>'
					+'</tr>';
			$("#{{$ko['tag']}}").before(html);
			layui.form.render(); 	//重置表单
		});
		@endforeach
		@endif
		
		$(document).on('click','.demo-delete',function(){
			$(this).parent().parent().remove();
		});
		  
		//Hash地址的定位
		var layid = location.hash.replace(/^#config=/, '');
		element.tabChange('config', layid);
		
		element.on('tab(config)', function(elem){
			location.hash = 'config='+ $(this).attr('lay-id');
		});
		
		var _tools = {
			layerCloseAll: function() {
				layer.closeAll();
			},
			//title:表字段名称, field:字段, field_from:字段类型
			openDialog: function(title, field, field_from) {
				var url = '{{url("lazykit/function_page/config_attribute_set")}}?system_id={{$system_id}}&design_id={{$design_id}}&field=' + field + '&field_from=' + field_from;
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
			}
		}
		window.tools = _tools;
	});
</script>
@endpush