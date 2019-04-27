			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>数据源设置</legend>
			</fieldset>
			<table class="layui-table create">
				<tbody>
					<tr class="main_table">
						<td style="width:110px;"> &nbsp; &nbsp; 主表：</td>
						<td>
						<select name="main_table">
							<option value=""></option>
							@foreach ($tables as $vo)
							<option @if ($datatable_arr['main_table'] == $vo) selected="selected" @endif value="{{$vo}}">{{$vo}}</option>
							@endforeach
						</select>
						</td>
					</tr>
					<tr>
						<td> &nbsp; &nbsp; 关联类型：</td>
						<td>
						<select name="associated_type" style="width:120px;">
							<option value=""></option>
							@foreach ($join_type_arr as $ko=>$vo)
							<option @if ($datatable_arr['associated_type'] == $ko) selected="selected" @endif value="{{$ko}}">{{$vo}}</option>
							@endforeach
						</select>
						</td>
					</tr>
					<tr class="associated_table">
						<td> &nbsp; &nbsp; 关联表：</td>
						<td>
						<select name="associated_table" style="width:150px;">
							<option value=""></option>
							@foreach ($tables as $vo)
							<option @if ($datatable_arr['associated_table'] == $vo) selected="selected" @endif value="{{$vo}}">{{$vo}}</option>
							@endforeach
						</select>
						</td>
					</tr>
					<tr class="external_field">
						<td> &nbsp; &nbsp; 自定义字段：</td>
						<td>
						<input type="text" name="external_field" value="{{$datatable_arr['external_field']}}" placeholder="请输入用逗号隔开的字段" autocomplete="off" class="layui-input">
						</td>
					</tr>
				</tbody>
			</table>
			<blockquote class="layui-elem-quote">
				主表（关联表）跟自定义字段可同时设置；
			</blockquote>