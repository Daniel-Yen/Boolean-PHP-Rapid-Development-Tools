<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>数据表格继承设置</legend>
			</fieldset>
			<form class="layui-form" action="{{url('/lazykit/functionpage/add_model?id='.$datatable_arr['id'])}}" method="post">
			@csrf
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
						<td>&nbsp; {{!empty($datatable_arr['title'])?$datatable_arr['title']:''}}</td>
						<td>
						<select name="inheritance" style="width:150px;">
							<option value=""></option>
							@foreach ($inheritance_datatable_arr as $vo)
							<option @if ($datatable_arr['inheritance'] == $vo['id']) selected="selected" @endif value="{{$vo['id']}}">{{$vo['title']}}</option>
							@endforeach
						</select>
						</td>
						<td>
							<input type="text" name="inheritance_note" value="{{$datatable_arr['inheritance_note']}}" autocomplete="off"  class="layui-input">
						</td>
					</tr>
				</tbody>
			</table>
			<div class="layui-form-item" style="text-align:right;">
				<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
			</div>
			</form>