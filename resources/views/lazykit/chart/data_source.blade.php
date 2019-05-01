			<div class="layui-fluid">
				@if (isset($chart_config['chart_set']))
				<div class="layui-row chart_main">
					@foreach ($chart_config['chart_set'] as $key=>$value)
					<div id="chart_{{$key}}" class="layui-col-sm{{$value['tag']}}">
						<div class="layui-form-item">
							<div class="layui-input-inline" style="width:40px;">
								<input name="chart_set[{{$key}}][tag]" value="{{isset($value['tag'])?$value['tag']:''}}" class="layui-input" style="height:30px;" type="text" placeholder="栅格" autocomplete="off" lay-verify="required">
								<input name="chart_set[{{$key}}][option]" value="{{isset($value['option'])?$value['option']:''}}" class="layui-hide1">
								<input name="chart_set[{{$key}}][attribute]" value="{{isset($value['attribute'])?json_encode($value['attribute']):''}}" class="layui-hide1">
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
			
			<form method="post" class="layui-form layui-hide" id="chart_tpl" lay-filter="chart_tpl">
				<div class="layui-fluid layadmin-cmdlist-fluid">
				  <div class="layui-row layui-col-space30">
					@csrf
					@if (isset($chart_tpl))
					@foreach ($chart_tpl as $key=>$vo)
					<div class="layui-col-md2 layui-col-sm4">
						<div class="cmdlist-container">
							<a href="javascript:;">
							  <img src="../../layuiadmin/style/res/template/portrait.png">
							</a>
							<a href="javascript:;">
							  <div class="cmdlist-text">
								<p class="info">2018春夏季新款港味短款白色T恤+网纱中长款chic半身裙套装两件套</p>
								<div class="price">
									<b>￥79</b>
									<p>
									  ¥
									  <del>130</del>
									</p>
									<span class="flow">
									  <i class="layui-icon layui-icon-rate"></i>
									  433
									</span>
								</div>
							  </div>
							</a>
						</div>
					</div>
					@endforeach
					@endif
				  </div>
				</div>
			</form>