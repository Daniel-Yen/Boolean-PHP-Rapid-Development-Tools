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
						<div class="layui-form-item">
							<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
						</div>