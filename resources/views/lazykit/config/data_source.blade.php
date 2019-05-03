			<table class="layui-table create">
				<thead>
					<tr>
						<th width="150">配置名称</th>
						<th width="250">配置标识</th>
						<th>配置描述</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@if (isset($config['config_set'])?$config['config_set']:false)
					@foreach ($config['config_set'] as $k=>$v)
					<tr>
						<td><input type="text" name="config[name][{{$k}}]" @if (isset($v['name'])?$v['name']:false) value="{{$v['name']}}" @endif placeholder="请输入名称（站点设置）" lay-verify="required" autocomplete="off"  class="layui-input"></td>
						<td><input type="text" name="config[tag][{{$k}}]" @if (isset($v['tag'])?$v['tag']:false) value="{{$v['tag']}}" @endif placeholder="请输入标识（site）" lay-verify="required" autocomplete="off"  class="layui-input"></td>
						<td><input type="text" name="config[describe][{{$k}}]" @if (isset($v['describe'])?$v['describe']:false) value="{{$v['describe']}}" @endif placeholder="请输入配置说明" lay-verify="required" autocomplete="off"  class="layui-input"></td>
						<td style="text-align:center;"><a class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</a></td>
					</tr>
					@endforeach
					@endif
					<tr id="button_area">
						<td colspan="4" style="padding:5px; text-align:right;">
							<a class="layui-btn layui-btn-normal layui-btn-sm" lay-filter="addButton" id="addButton">添加一个配置</a>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="layui-form-item">
				<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
			</div>