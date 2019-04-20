<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>数据源设置</legend>
			</fieldset>
			<form class="layui-form" action="{{url('/lazykit/functionpage/add_model?id='.$datatable_arr['id'])}}" method="post">
			@csrf
			<table class="layui-table create">
				<thead>
					<tr>
						<th>菜单名称</th>
						<th>主表</th>
						<th>关联类型</th>
						<th>关联表</th>
						<th>自定义字段</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="width:150px;">&nbsp; {{!empty($datatable_arr['title'])?$datatable_arr['title']:''}}</td>
						<td class="main_table" style="width:150px;">
						<select name="main_table" style="width:150px;">
							<option value=""></option>
							@foreach ($tables as $vo)
							<option @if ($datatable_arr['main_table'] == $vo) selected="selected" @endif value="{{$vo}}">{{$vo}}</option>
							@endforeach
						</select>
						</td>
						<td style="width:120px;">
						<select name="associated_type" style="width:120px;">
							<option value=""></option>
							@foreach ($join_type_arr as $ko=>$vo)
							<option @if ($datatable_arr['associated_type'] == $ko) selected="selected" @endif value="{{$ko}}">{{$vo}}</option>
							@endforeach
						</select>
						</td>
						<td class="associated_table" style="width:150px;">
						<select name="associated_table" style="width:150px;">
							<option value=""></option>
							@foreach ($tables as $vo)
							<option @if ($datatable_arr['associated_table'] == $vo) selected="selected" @endif value="{{$vo}}">{{$vo}}</option>
							@endforeach
						</select>
						</td>
						<td class="external_field">
						<input type="text" name="external_field" value="{{$datatable_arr['external_field']}}" placeholder="请输入用逗号隔开的字段" autocomplete="off" class="layui-input">
						</td>
					</tr>
				</tbody>
			</table>
			<div class="layui-form-item" style="text-align:right;">
				<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
			</div>
			</form>