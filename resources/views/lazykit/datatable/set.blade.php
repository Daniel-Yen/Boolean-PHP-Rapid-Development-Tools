@extends('layouts.base')

@section('title', 'Databale配置生成')

@push('css')
<style>
	.create td{padding: 0;}
	.create td input{border: 0;}
	.create .switch_area{padding-bottom:8px; text-align: center;}
	.main_table{color: blue;}
	.main_table input,select{color: blue;}
	.associated_table{color: green;}
	.associated_table input,select{color: green;}
	.external_field{color: red;}
	.external_field input,select{color: red;}
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
					<li class="layui-this">配置信息</li>
					<li> @if ($datatable_arr['model'] == 2) 数据源设置 @elseif ($datatable_arr['model'] == 5) 数据表格继承设置 @endif</li>
					@if (in_array($datatable_arr['model'], [2, 5]) && ($datatable_arr['main_table'] != '' || $datatable_arr['external_field'] != '' || $datatable_arr['inheritance'] != ''))
					@if ($datatable_arr['model'] == 2)
					<li>数据表格设置</li>
					@endif
					<li>头部内置工具菜单</li>
					<li>头部附加工具菜单</li>
					<li>行内工具按钮</li>
					@endif
				</ul>
				<div class="layui-tab-content">
					<div class="layui-tab-item layui-show">
						<table class='layui-table'>
							<tbody>
								<tr>
									<td width="85">页面名称：</td>
									<td>{{!empty($datatable_arr['title'])?$datatable_arr['title']:''}}</td>
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
									<td>{{$system->file_path}}{{DIRECTORY_SEPARATOR}}app{{DIRECTORY_SEPARATOR}}Datatable{{DIRECTORY_SEPARATOR}}datatable_{{$design_id}}.php  &nbsp; 
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
					<div class="layui-tab-item">
						@if ($datatable_arr['model'] == 2)
							@include ('lazykit.datatable.data_source')
						@elseif ($datatable_arr['model'] == 5)
							@include ('lazykit.datatable.inheritance')
						@endif
					</div>
					@if (in_array($datatable_arr['model'], [2, 5]) && ($datatable_arr['main_table'] != '' || $datatable_arr['external_field'] != '' || $datatable_arr['inheritance'] != ''))
					@if ($datatable_arr['model'] == 2)
					<div class="layui-tab-item">
						@include ('lazykit.datatable.data_source_set')
					</div>
					@endif
					
					<div class="layui-tab-item">
						<table class="layui-table create">
							<thead>
								<tr>
									<th style="width:90px;">头部菜单名称</th>
									<th style="width:130px;">图标</th>
									<th style="width:80px;">菜单类型</th>
									<th style="width:60px;">是否启用</th>
									<th style="width:60px;">宽</th>
									<th style="width:60px;">高</th>
									<th>路由</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($head_menu_arr as $key=>$vo)
								<tr>
									<td><input type="text" name="head_menu[{{$key}}][text]" value="{{isset($vo['text'])?$vo['text']:''}}" autocomplete="off" class="layui-input"></td>
									<td><input type="text" name="head_menu[{{$key}}][icon]" value="{{isset($vo['icon'])?$vo['icon']:''}}" autocomplete="off" class="layui-input"></td>
									<td> &nbsp; 内置：{{$key}}</td>
									<td class="switch_area"><input name="head_menu[{{$key}}][must]" @if (isset($vo['must'])) @if ($vo['must'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="是|否"></td>
									<td><input type="text" name="head_menu[{{$key}}][width]" value="{{isset($vo['width'])?$vo['width']:''}}" autocomplete="off" class="layui-input"></td>
									<td><input type="text" name="head_menu[{{$key}}][height]" value="{{isset($vo['height'])?$vo['height']:''}}" autocomplete="off" class="layui-input"></td>
									<td><input type="text" name="head_menu[{{$key}}][method]" value="{{isset($vo['method'])?$vo['method']:''}}" autocomplete="off" class="layui-input"></td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<div class="layui-form-item">
							<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
						</div>
					</div>
					<div class="layui-tab-item">
						<table class="layui-table create">
							<thead>
								<tr>
									<th style="width:90px;">头部菜单名称</th>
									<th style="width:130px;">图标</th>
									<th style="width:80px;">按钮名称</th>
									<th style="width:70px;">打开方式</th>
									<th style="width:60px;">是否启用</th>
									<th style="width:45px;">必选行</th>
									<th style="width:60px;">宽</th>
									<th style="width:60px;">高</th>
									<th>类的操作方法</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="area">
								@if (isset($datatable_config['new_head_menu']))
								@foreach ($datatable_config['new_head_menu'] as $key=>$vo)
								<tr>
									<td><input type="text" name="new_head_menu_list[{{$key}}][text]" value="{{isset($vo['text'])?$vo['text']:''}}" autocomplete="off" class="layui-input"></td>
									<td><input type="text" name="new_head_menu_list[{{$key}}][icon]" value="{{isset($vo['icon'])?$vo['icon']:''}}" autocomplete="off" class="layui-input"></td>
									<td> &nbsp; {{$key}}</td>
									<td>
										<select name="new_head_menu_list[{{$key}}][open_tepe]">
											@foreach ($button_open_type_arr as $k=>$ko)
											<option @if (isset($vo['open_tepe'])) @if ($vo['open_tepe'] == $k) selected="selected" @endif  @endif value="{{$k}}">{{$ko}}</option>
											@endforeach
										</select>
									</td>
									<td class="switch_area"><input name="new_head_menu_list[{{$key}}][must]" @if (isset($vo['must'])) @if ($vo['must'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="启用|关闭"></td>
									<td class="switch_area"><input name="new_head_menu_list[{{$key}}][checked]" @if (isset($vo['checked'])) @if ($vo['checked'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="是|否"></td>
									<td><input type="text" name="new_head_menu_list[{{$key}}][width]" value="{{isset($vo['width'])?$vo['width']:''}}" autocomplete="off" class="layui-input"></td>
									<td><input type="text" name="new_head_menu_list[{{$key}}][height]" value="{{isset($vo['height'])?$vo['height']:''}}" autocomplete="off" class="layui-input"></td>
									<td><input type="text" name="new_head_menu_list[{{$key}}][method]" value="{{isset($vo['method'])?$vo['method']:''}}" autocomplete="off" class="layui-input"></td>
									<td style="text-align:center; padding:0 10px;"><a class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</a></td>
								</tr>
								@endforeach
								@endif
								<tr>
									<td colspan="10" style="padding:5px;">
										<a class="layui-btn layui-btn-normal layui-btn-sm" lay-filter="add" id="add">添加</a>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="layui-form-item">
							<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
						</div>
					</div>
					<div class="layui-tab-item">
						<div class="layui-form-item">
							<label class="layui-form-label" style="width:120px;">操作按钮区域宽度</label>
							<div class="layui-input-inline" style="width:50px;">
								<input type="text" name="other_set[line_button_area_width]" value="{{isset($datatable_config['other_set']['line_button_area_width'])?$datatable_config['other_set']['line_button_area_width']:'160'}}" autocomplete="off"  class="layui-input">
							</div>
							<label class="layui-form-label" style="width:5px;">px</label>
						</div>
						<table class="layui-table create">
							<thead>
								<tr>
									<th style="width:90px;">按钮名称</th>
									<th style="width:130px;">按钮样式</th>
									<th style="width:80px;">按钮名称</th>
									<th style="width:70px;">打开方式</th>
									<th style="width:60px;">是否启用</th>
									<th style="width:60px;">宽</th>
									<th style="width:60px;">高</th>
									<th>类的操作方法</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="button_area">
								@if (isset($datatable_config['line_button']))
								@foreach ($datatable_config['line_button'] as $key=>$vo)
								<tr>
									<td><input type="text" name="line_button_list[{{$key}}][text]" value="{{isset($vo['text'])?$vo['text']:''}}" autocomplete="off" class="layui-input"></td>
									<td>
										<select name="line_button_list[{{$key}}][style]">
											@foreach ($button_style_type_arr as $k=>$ko)
											<option @if (isset($vo['style'])) @if ($vo['style'] == $k) selected="selected" @endif  @endif value="{{$k}}">{{$ko}}</option>
											@endforeach
										</select>
									</td>
									<td> &nbsp; {{$key}}</td>
									<td>
										<select name="line_button_list[{{$key}}][open_tepe]">
											@foreach ($button_open_type_arr as $k=>$ko)
											<option @if (isset($vo['open_tepe'])) @if ($vo['open_tepe'] == $k) selected="selected" @endif  @endif value="{{$k}}">{{$ko}}</option>
											@endforeach
										</select>
									</td>
									<td class="switch_area"><input name="line_button_list[{{$key}}][must]" @if (isset($vo['must'])) @if ($vo['must'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="启用|关闭"></td>
									<td><input type="text" name="line_button_list[{{$key}}][width]" value="{{isset($vo['width'])?$vo['width']:''}}" autocomplete="off" class="layui-input"></td>
									<td><input type="text" name="line_button_list[{{$key}}][height]" value="{{isset($vo['height'])?$vo['height']:''}}" autocomplete="off" class="layui-input"></td>
									<td><input type="text" name="line_button_list[{{$key}}][method]" value="{{isset($vo['method'])?$vo['method']:''}}" autocomplete="off" class="layui-input"></td>
									<td style="text-align:center; padding:0 10px;"><a class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</a></td>
								</tr>
								@endforeach
								@endif
								<tr>
									<td colspan="9" style="padding:5px;">
										<a class="layui-btn layui-btn-normal layui-btn-sm" lay-filter="addButton" id="addButton">添加</a>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="layui-form-item">
							<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
						</div>
					</div>
					@endif
				</div>
			</div>
			<form>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	layui.use(['jquery', 'form', 'layer', 'element'], function() {
		var $ = layui.$,
			form = layui.form,
			layer = layui.layer;

		$(document).on('click','#add',function(){
			var html = '<tr>'
						+'<td><input type="text" name="new_head_menu[text][]" value="" autocomplete="off" class="layui-input"></td>'
						+'<td><input type="text" name="new_head_menu[icon][]" value="" autocomplete="off" class="layui-input"></td>'
						+'<td><input type="text" name="new_head_menu[type][]" value="" autocomplete="off" class="layui-input"></td>'
						+'<td><select name="new_head_menu[open_tepe][]"> @foreach ($button_open_type_arr as $k=>$ko) <option value="{{$k}}">{{$ko}}</option> @endforeach </select></td>'
						+'<td class="switch_area"><input name="new_head_menu[must][]" checked="checked" type="checkbox" lay-skin="switch" lay-text="是|否"></td>'
						+'<td class="switch_area"><input name="new_head_menu[checked][]" type="checkbox" lay-skin="switch" lay-text="是|否"></td>'
						+'<td><input type="text" name="new_head_menu[width][]" value="" autocomplete="off" class="layui-input"></td>'
						+'<td><input type="text" name="new_head_menu[height][]" value="" autocomplete="off" class="layui-input"></td>'
						+'<td><input type="text" name="new_head_menu[method][]" value="" autocomplete="off" class="layui-input"></td>'
						+'<td style="text-align:center;"><a class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</a></td>'
					+'</tr>';
			//alert(html);
			$("#area").append(html);
			layui.form.render(); 	//重置表单
		});
		
		$(document).on('click','#addButton',function(){
			var html = '<tr>'
						+'<td><input type="text" name="line_button[text][]" value="" autocomplete="off" class="layui-input"></td>'
						+'<td><select name="line_button[style][]"> @foreach ($button_style_type_arr as $k=>$ko) <option @if (isset($vo['style'])) @if ($vo['style'] == $k) selected="selected" @endif  @endif value="{{$k}}">{{$ko}}</option> @endforeach </select></td>'
						+'<td><input type="text" name="line_button[type][]" value="" autocomplete="off" class="layui-input"></td>'
						+'<td><select name="line_button[open_tepe][]"> @foreach ($button_open_type_arr as $k=>$ko) <option value="{{$k}}">{{$ko}}</option> @endforeach </select></td>'
						+'<td class="switch_area"><input name="line_button[must][]" checked="checked" type="checkbox" lay-skin="switch" lay-text="是|否"></td>'
						+'<td><input type="text" name="line_button[width][]" value="" autocomplete="off" class="layui-input"></td>'
						+'<td><input type="text" name="line_button[height][]" value="" autocomplete="off" class="layui-input"></td>'
						+'<td><input type="text" name="line_button[method][]" value="" autocomplete="off" class="layui-input"></td>'
						+'<td style="text-align:center;"><a class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</a></td>'
					+'</tr>';
			//alert(html);
			$("#button_area").append(html);
			layui.form.render(); 	//重置表单
		});
		
		$(document).on('click','#preview',function(){
			layer.open({
				type: 2
				,title: '预览数据表格配置文件（datatable_{{$design_id}}）'
				,area: ['80%', '95%']
				,shade: 0.3
				,maxmin: false
				,offset: 'auto' 
				,content: '/lazykit/function_page/preview?design_id={{$design_id}}'
			});
		});
		
		$(document).on('click','.demo-delete',function(){
			$(this).parent().parent().remove();
		});
		
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
			}
		}
		window.tools = _tools;
	});
</script>
@endpush
