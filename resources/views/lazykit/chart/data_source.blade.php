			<div class="layui-fluid">
				@if (isset($chart_config['chart_set']))
				<div class="layui-row chart_main">
					@foreach ($chart_config['chart_set'] as $key=>$value)
					<div id="chart_{{$key}}" class="drag-able layui-col-sm{{$value['tag']}}">
						<div class="layui-form-item">
							<div class="layui-input-inline" style="width:40px;">
								<input name="chart_set[{{$key}}][tag]" value="{!! isset($value['tag'])?$value['tag']:'' !!}" class="layui-input" style="height:30px;" type="text" placeholder="栅格" autocomplete="off" lay-verify="required">
								<input id="chart_set_{{$key}}_option" name="chart_set[{{$key}}][option]" value='{!! isset($value['option'])?$value['option']:'' !!}' class="layui-hide">
								<input name="chart_set[{{$key}}][attribute]" value='{!! isset($value['attribute'])?json_encode($value['attribute']):'' !!}' class="layui-hide">
							</div>
							<div class="layui-input-inline" style="width:80px;">
								<input name="chart_set[{{$key}}][title]" value="{{$value['title']}}" class="layui-input" style="height:30px;" type="text" placeholder="图表标记" autocomplete="off" lay-verify="required">
							</div>
							<div class="layui-input-inline" style="width:150px;">
								<div class="layui-btn-group">
									<a onclick="tools.add({{$key}})" class="layui-btn layui-btn-sm layui-btn-normal">添加</a>
									<a onclick='tools.edit({{$key}})' class="layui-btn layui-btn-sm layui-btn-normal">编辑</a>
									<a onclick="tools.delete('chart_{{$key}}')" class="layui-btn layui-btn-sm layui-btn-danger">删除</a>
								</div>
							</div>
						</div>
						<div id="Blk-chart-{{$key}}" class="main dragsort">
							<div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
						</div>
					</div>
					@endforeach
				</div>
				<input id="chart_id" type="hidden" value=""/>
				@endif
				
				<fieldset class="layui-elem-field site-demo-button" style="margin-top: 30px;">
				    <legend>添加统计图表</legend>
					<div class="layui-row">
						<div class="layui-col-sm12" style="padding:25px 25px 10px 25px;">
							<div class="layui-form-item">
								<div class="layui-input-inline" style="width:60px;">
									<input name="chart_add_set[tag]" value="" class="layui-input" style="height:30px;" type="text" placeholder="栅格" autocomplete="off">
								</div>
								<div class="layui-input-inline" style="width:80px;">
									<input name="chart_add_set[title]" value="" class="layui-input" style="height:30px;" type="text" placeholder="图表标记" autocomplete="off">
								</div>
							</div>
						</div>
					</div>
				</fieldset>
				
				<div class="layui-form-item">
					<button class="layui-btn"  lay-submit="" lay-filter="demo2">提交</button>
				</div>
				<blockquote class="layui-elem-quote">
					帮助手册
				</blockquote>
			</div>
			
			<div class="layui-form layui-hide" id="chart_tpl">
				<div class="layui-fluid layadmin-cmdlist-fluid">
				  <div class="layui-row layui-col-space30">
					@if (isset($chart_tpl))
					@foreach ($chart_tpl as $key=>$vo)
					<div onclick='tools.select_chart({!! $vo['option'] !!}, "")' class="layui-col-md2 layui-col-sm4">
						<div class="cmdlist-container">
							<img src="{{file_path('/include/images/charts/'.$vo['picture'])}}">
							<p class="info">{{$vo['title']}}</p>
						</div>
					</div>
					@endforeach
					@endif
				  </div>
				</div>
			</div>
			
			<div method="post" class="layui-form layui-hide" id="chart_attribute_set">
				<div class="layui-fluid layadmin-cmdlist-fluid">
				  <div class="layui-row layui-col-space30">
					<
				  </div>
				</div>
			</div>