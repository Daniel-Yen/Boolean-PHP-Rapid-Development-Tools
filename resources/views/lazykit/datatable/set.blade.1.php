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
	.layui-card-body{padding:5px; font-size:16px;}
</style>
@endpush

@section('content')
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-tab layui-tab-brief">
				<ul class="layui-tab-title">
					<li class="layui-this">配置信息</li>
					<li>Datatable设置</li>
					<li>权限分配</li>
					<li>商品管理</li>
					<li>订单管理</li>
				</ul>
				<div class="layui-tab-content">
					<div class="layui-tab-item layui-show">
						<div class="layui-card">
							<div class="layui-card-body">
							    配置路径：{{$system->file_path}}{{DIRECTORY_SEPARATOR}}app{{DIRECTORY_SEPARATOR}}Datatable{{DIRECTORY_SEPARATOR}}datatable_{{$design_id}}.php  &nbsp; <button id="preview" class="layui-btn layui-btn-primary layui-btn-sm">预览配置文件</button>
							</div>
							<div class="layui-card-body">
							    路由地址：{{$route_message['route_path']}}{{$route_message['route_name']}} &nbsp; 
							</div>
							<div class="layui-card-body">
							    控制器文件：{{$route_message['namespace']}}\{{$route_message['controller']}}.php &nbsp; 
							    @if ($route_message['controller_exists']) <span class="layui-badge layui-bg-blue">存在</span> @else <span class="layui-badge">不存在</span> @endif &nbsp;
							    方法：{{$route_message['method']}} &nbsp; 
							    @if ($route_message['method_exists']) <span class="layui-badge layui-bg-blue">存在</span> @else <span class="layui-badge">不存在</span> @endif  &nbsp;
							</div>
							<div class="layui-card-body">
							  
							</div>
							<div class="layui-card-body">
							  
							</div>
						</div>
					</div>
					<div class="layui-tab-item">2</div>
					<div class="layui-tab-item">3</div>
					<div class="layui-tab-item">4</div>
					<div class="layui-tab-item">5</div>
					<div class="layui-tab-item">6</div>
				</div>
			</div>
			<fieldset class="layui-elem-field layui-field-title">
				<legend>配置信息</legend>
			</fieldset>
			<div class="layui-card">
				<div class="layui-card-body">
				    配置路径：{{$system->file_path}}{{DIRECTORY_SEPARATOR}}app{{DIRECTORY_SEPARATOR}}Datatable{{DIRECTORY_SEPARATOR}}datatable_{{$design_id}}.php  &nbsp; <button id="preview" class="layui-btn layui-btn-primary layui-btn-sm">预览配置文件</button>
				</div>
				<div class="layui-card-body">
				    路由地址：{{$route_message['route_path']}}{{$route_message['route_name']}} &nbsp; 
				</div>
				<div class="layui-card-body">
				    控制器文件：{{$route_message['namespace']}}\{{$route_message['controller']}}.php &nbsp; 
				    @if ($route_message['controller_exists']) <span class="layui-badge layui-bg-blue">存在</span> @else <span class="layui-badge">不存在</span> @endif &nbsp;
				    方法：{{$route_message['method']}} &nbsp; 
				    @if ($route_message['method_exists']) <span class="layui-badge layui-bg-blue">存在</span> @else <span class="layui-badge">不存在</span> @endif  &nbsp;
				</div>
				<div class="layui-card-body">
				  
				</div>
				<div class="layui-card-body">
				  
				</div>
			</div>
			
			@if ($datatable_arr['model'] == 2)
				@include ('lazykit.datatable.data_source_set')
			@elseif ($datatable_arr['model'] == 5)
				@include ('lazykit.datatable.inheritance_set')
			@endif
			
			@if (in_array($datatable_arr['model'], [2, 5]))
			@if ($datatable_arr['main_table'] != '' || $datatable_arr['external_field'] != '' || $datatable_arr['inheritance'] != '')
			<form class="layui-form" action="" method="post">
				@csrf
				@if ($datatable_arr['model'] == 2)
				<fieldset class="layui-elem-field layui-field-title">
					<legend>Datatable设置</legend>
				</fieldset>
				@if ($datatable_arr['main_table'])
				<div class="layui-form-item">
					<label class="layui-form-label">是否树结构</label>
					<div class="layui-input-inline" style="width:50px;">
						<input name="other_set[is_tree]" @if (isset($datatable_config['other_set']['is_tree'])) @if ($datatable_config['other_set']['is_tree'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="是|否">
					</div>
					<div class="layui-form-mid layui-word-aux">树节点字段为“pid”,另需要“id、title”字段；</div>
					<label class="layui-form-label">每页记录数</label>
					<div class="layui-input-inline" style="width:150px;">
						<select name="other_set[limit]">
							<option value="20">默认（每页20条）</option>
							@for ($i = 1; $i < 10; $i++)
							<option @if (isset($datatable_config['other_set']['limit'])) @if ($datatable_config['other_set']['limit'] == $i*10) selected="selected" @endif @endif value="{{$i*10}}">每页{{$i*10}}条</option>
							@endfor
						</select>
					</div>
					<label class="layui-form-label" style="width:100px;">字段最小宽度</label>
					<div class="layui-input-inline" style="width:50px;">
						<input type="text" name="other_set[cell_min_width]" value="{{isset($datatable_config['other_set']['cell_min_width'])?$datatable_config['other_set']['cell_min_width']:'160'}}" autocomplete="off"  class="layui-input">
					</div>
					<label class="layui-form-label" style="width:5px;">px</label>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">左侧目录树</label>
					<div class="layui-input-inline" style="width:50px;">
						<input name="directory[has]" @if (isset($datatable_config['directory']['has'])) @if ($datatable_config['directory']['has'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="是|否">
					</div>
					<label class="layui-form-label" style="width:45px;">数据源</label>
					<div class="layui-input-inline" style="width:450px;">
						<input type="text" name="directory[method]" value="{{isset($datatable_config['directory']['method'])?$datatable_config['directory']['method']:''}}"  placeholder="控制器方法" autocomplete="off"  class="layui-input">
					</div>
					<label class="layui-form-label">关联字段</label>
					<div class="layui-input-inline" style="width:200px;">
						@if ($datatable_arr['main_table'] != '')
						<select name="directory[associated_field]">
							<option value="">请选择关联字段</option>
							@foreach ($field_row_arr as $vo)
							@if (!in_array($vo['Field'], ['id', 'created_at', 'updated_at', 'deleted_at']))
							<option @if (isset($datatable_config['directory']['associated_field'])) @if ($datatable_config['directory']['associated_field'] == $vo['Field']) selected="selected" @endif @endif value="{{$vo['Field']}}">{{$vo['Comment']}} （{{$vo['Field']}}）</option>
							@endif
							@endforeach
						</select>
						@else
						<input type="text" name="directory[associated_field]" value="{{isset($datatable_config['directory']['associated_field'])?$datatable_config['directory']['associated_field']:''}}"  placeholder="请输入关联字段" autocomplete="off"  class="layui-input">
						@endif
					</div>
					<label class="layui-form-label">目录宽度</label>
					<div class="layui-input-inline" style="width:50px;">
						<input type="text" name="directory[width]" value="{{isset($datatable_config['directory']['width'])?$datatable_config['directory']['width']:'200'}}" autocomplete="off"  class="layui-input">
					</div>
				</div>
				@endif
				<table class="layui-table create">
					<thead>
						<tr>
							<th style="width:30px;">排序</th>
							<th style="width:55px;">固定列</th>
							<th>字段名</th>
							<th>字段</th>
							<th style="width:30px;">宽度</th>
							<th style="width:39px;">新增</th>
							<th style="width:39px;">修改</th>
							<th style="width:39px;">查看</th>
							<!-- <th style="width:39px;">搜索</th> -->
							<th style="width:65px;">搜索条件</th>
							<th style="width:39px;">导入</th>
							<th style="width:39px;">导出</th>
							<th style="width:70px;"></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($field_row_arr as $vo)
						<tr>
							<td>
								<input type="hidden" name="datatable_set[{{$vo['Field']}}][field_type]" value="{{isset($vo['field_type'])?$vo['field_type']:''}}" autocomplete="off" class="layui-input">
								<input type="hidden" name="datatable_set[{{$vo['Field']}}][field_length]" value="{{isset($vo['field_length'])?$vo['field_length']:''}}" autocomplete="off" class="layui-input">
								<input type="text" name="datatable_set[{{$vo['Field']}}][sorting]" value="{{isset($vo['sorting'])?$vo['sorting']:''}}" autocomplete="off" class="layui-input">
							</td>
							<td>
								<select name="datatable_set[{{$vo['Field']}}][fixed]">
									<option value="0"> &emsp; </option>
									@foreach ($fixed_column_dic_arr as $k=>$ko)
									<option @if (isset($vo['fixed'])) @if ($vo['fixed'] == $k) selected="selected" @endif  @endif value="{{$k}}">{{$ko}}</option>
									@endforeach
								</select>
							</td>
							<td class="{{$vo['field_from']}}"><input type="text" name="datatable_set[{{$vo['Field']}}][title]" class="layui-input" value="{{isset($vo['title'])?$vo['title']:$vo['Comment']}}"></td>
							<td class="{{$vo['field_from']}}">
								<input type="text" name="datatable_set[{{$vo['Field']}}][field]" readonly class="layui-input" value="{{isset($vo['field'])?$vo['field']:$vo['Field']}}">
								<input type="hidden" name="datatable_set[{{$vo['Field']}}][field_from]" value="{{isset($vo['field_from'])?$vo['field_from']:''}}">
							</td>
							<td><input type="text" name="datatable_set[{{$vo['Field']}}][width]" value="{{isset($vo['width'])?$vo['width']:''}}" class="layui-input"></td>
							<td class="switch_area">
								@if ($vo['field_from'] == 'main_table')
								@if (!in_array($vo['Field'], ['id','created_at','updated_at','deleted_at']))
								<input name="datatable_set[{{$vo['Field']}}][create]" @if (isset($vo['create'])) @if ($vo['create'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="是|否">
								@endif
								@endif
							</td>
							<td class="switch_area">
								@if ($vo['field_from'] == 'main_table')
								@if (!in_array($vo['Field'], ['id','created_at','updated_at','deleted_at']))
								<input name="datatable_set[{{$vo['Field']}}][update]" @if (isset($vo['update'])) @if ($vo['update'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="是|否">
								@endif
								@endif
							</td>
							<td class="switch_area"><input name="datatable_set[{{$vo['Field']}}][read]"   @if (isset($vo['read'])) @if ($vo['read'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="是|否"></td>
							<!-- <td class="switch_area"><input name="datatable_set[{{$vo['Field']}}][search]" @if (isset($vo['search'])) @if ($vo['search'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="是|否"></td> -->
							<td>
								<select name="datatable_set[{{$vo['Field']}}][search]">
									<option value="0"> &emsp; </option>
									@foreach ($search_conditions_dic_arr as $k=>$ko)
									<option @if (isset($vo['search'])) @if ($vo['search'] == $k) selected="selected" @endif  @endif value="{{$k}}">{{$ko}}</option>
									@endforeach
								</select>
							</td>
							<td class="switch_area">
								@if ($vo['field_from'] == 'main_table')
								<input name="datatable_set[{{$vo['Field']}}][import]" @if (isset($vo['import'])) @if ($vo['import'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="是|否">
								@endif
							</td>
							<td class="switch_area"><input name="datatable_set[{{$vo['Field']}}][export]" @if (isset($vo['export'])) @if ($vo['export'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="是|否"></td>
							<td style="text-align: center;">
								<button type="button" onclick="tools.openDialog('{{$vo['Comment']}}', '{{$vo['Field']}}', '{{$vo['field_from']}}');" class="layui-btn layui-btn-sm layui-btn-xs layui-btn-danger">附加属性</button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div class="layui-form-item">
					操作提示：1、不同颜色的字段属性代表不同的字段来源。
				</div>
				@endif
				<!-- <div class="layui-form-item">
					<label class="layui-form-label">ORDER BY</label>
					<div class="layui-input-inline">
						<input type="text" name="validation_rules" value="{$attribute_arr.validation_rules}" placeholder="请输入数据库查询排序条件,示例:id desc" autocomplete="off" class="layui-input" style="width:300px;">
					</div>
				</div> -->
				
				<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
					<legend>头部内置工具菜单</legend>
				</fieldset>
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
				
				<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
					<legend>头部附加工具菜单</legend>
				</fieldset>
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
				
				<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
					<legend>行内工具按钮</legend>
				</fieldset>
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
				<br />
				<div class="layui-form-item" style="text-align:right;">
					<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
				</div>
			</form>
			@endif
			@endif
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
