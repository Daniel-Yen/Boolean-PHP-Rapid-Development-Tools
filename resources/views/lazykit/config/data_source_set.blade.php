						@if (isset($config['config_set'])?$config['config_set']:false)
						@foreach ($config['config_set'] as $ko)
						<fieldset class="layui-elem-field layui-field-title">
							<legend>{{$ko['name']}}</legend>
						</fieldset>
						<table class="layui-table create">
							<thead>
								<tr>
									<th style="width:130px;">字段</th>
									<th style="width:130px;">字段名</th>
									<th style="width:30px;">排序</th>
									<th style="width:30px;">宽度</th>
									<th>填写说明</th>
									<th style="width:70px;"></th>
								</tr>
							</thead>
							<tbody>
								@if (isset($ko['fields'])?$ko['fields']:false)
								@foreach ($ko['fields'] as $vo)
								<tr>
									<td><input type="text" name="config_fields[{{$ko['tag']}}][field][]" value="{{isset($vo['field'])?$vo['field']:''}}" class="layui-input"></td>
									<td><input type="text" name="config_fields[{{$ko['tag']}}][title][]" value="{{isset($vo['title'])?$vo['title']:''}}" class="layui-input"></td>
									<td><input type="text" name="config_fields[{{$ko['tag']}}][sorting][]" value="{{isset($vo['sorting'])?$vo['sorting']:''}}" class="layui-input"></td>
									<td><input type="text" name="config_fields[{{$ko['tag']}}][width][]" value="{{isset($vo['width'])?$vo['width']:''}}" class="layui-input"></td>
									<td><input type="text" name="config_fields[{{$ko['tag']}}][instructions][]" value="{{isset($vo['instructions'])?$vo['instructions']:''}}" class="layui-input"></td>
									<td style="text-align: center;"><button type="button" onclick="tools.openDialog('{{$ko['name']}}', '{{$vo['field']}}', '{{$ko['tag']}}');" class="layui-btn layui-btn-sm layui-btn-xs layui-btn-danger">附加属性</button></td>
								</tr>
								@endforeach
								@endif
								<tr id="{{$ko['tag']}}">
									<td colspan="6" style="padding:5px; text-align:right;">
										<a class="layui-btn layui-btn-normal layui-btn-sm" id="add{{$ko['tag']}}">添加一个字段</a>
									</td>
								</tr>
							</tbody>
						</table>
						@endforeach
						@endif
						<blockquote class="layui-elem-quote">
							操作提示：1、不同颜色的字段属性代表不同的字段来源；2、更多针对字段的设置请在 <button type="button" class="layui-btn layui-btn-sm layui-btn-xs layui-btn-danger">附加属性</button> 中操作
						</blockquote>
						<div class="layui-form-item">
							<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
						</div>