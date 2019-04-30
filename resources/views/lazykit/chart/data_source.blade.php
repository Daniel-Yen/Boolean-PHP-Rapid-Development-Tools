			<div class="layui-fluid">
				@if (isset($chart_config['chart_set']))
				<div class="layui-row chart_main">
					@foreach ($chart_config['chart_set'] as $key=>$value)
					<div id="chart_{{$key}}" class="layui-col-sm{{$value['tag']}}">
						<div class="layui-form-item">
							<div class="layui-input-inline" style="width:40px;">
								<input name="chart_set[{{$key}}][tag]" value="{{$value['tag']}}" class="layui-input" style="height:30px;" type="text" placeholder="栅格" autocomplete="off" lay-verify="required">
								<input name="chart_set[{{$key}}][option]" value="{{$value['option']}}" class="layui-hide">
								
							</div>
							<div class="layui-input-inline" style="width:80px;">
								<input name="chart_set[{{$key}}][title]" value="{{$value['title']}}" class="layui-input" style="height:30px;" type="text" placeholder="图表标记" autocomplete="off" lay-verify="required">
							</div>
							<div class="layui-input-inline" style="width:150px;">
								<div class="layui-btn-group">
									<a onclick="tools.add('{{$key}}')" class="layui-btn layui-btn-sm layui-btn-normal">添加</a>
									<a onclick="tools.edit('{{$key}}')" class="layui-btn layui-btn-sm layui-btn-normal">编辑</a>
									<a onclick="tools.delete('chart_{{$key}}')" class="layui-btn layui-btn-sm layui-btn-danger">删除</a>
								</div>
							</div>
						</div>
						<div class="main dragsort"></div>
					</div>
					@endforeach
				</div>
				@endif
				<fieldset class="layui-elem-field layui-field-title">
					<legend>添加统计图表</legend>
				</fieldset>
				<div class="layui-row">
					<div class="layui-col-sm12">
						<div class="layui-form-item">
							<div class="layui-input-inline" style="width:60px;">
								<input name="chart_add_set[tag]" value="" class="layui-input" style="height:30px;" type="text" placeholder="栅格" autocomplete="off">
							</div>
							<div class="layui-input-inline" style="width:80px;">
								<input name="chart_add_set[title]" value="" class="layui-input" style="height:30px;" type="text" placeholder="图表标记" autocomplete="off">
							</div>
						</div>
						<div class="main"></div>
					</div>
				</div>
				<div class="layui-form-item">
					<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
				</div>
			</div>
			<blockquote class="layui-elem-quote">
				帮助手册
			</blockquote>