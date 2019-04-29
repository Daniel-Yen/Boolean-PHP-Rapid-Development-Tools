			<table class="layui-table create">
				<thead>
					<tr>
						<th width="150">菜单名称</th>
						<th width="250">要继承的数据表格</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>&nbsp; {{!empty($function_page['title'])?$function_page['title']:''}}</td>
						<td>
						<select name="inheritance" lay-verify="required" style="width:150px;">
							<option value=""></option>
							@foreach ($inheritance_function_page as $vo)
							<option @if ($function_page['inheritance'] == $vo['id']) selected="selected" @endif value="{{$vo['id']}}">{{$vo['title']}}</option>
							@endforeach
						</select>
						</td>
						<td>
							<input type="text" name="inheritance_note" value="{{$function_page['inheritance_note']}}" autocomplete="off"  class="layui-input">
						</td>
					</tr>
				</tbody>
			</table>
			<div class="layui-form-item">
				<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
			</div>