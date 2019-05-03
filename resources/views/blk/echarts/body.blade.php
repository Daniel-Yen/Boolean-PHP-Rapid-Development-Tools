@extends('layouts.base')

@section('title', 'Chart配置生成')

@push('css')
<style>
	.main{min-height:350px;}
</style>
@endpush

@section('content')
<div class="layui-fluid">
	@if (isset($chart_config['chart_set']))
	<div class="layui-row chart_main">
		@foreach ($chart_config['chart_set'] as $key=>$value)
		<div id="chart_{{$key}}" class="drag-able layui-col-sm{{$value['tag']}}">
			<div id="Blk-chart-{{$key}}" class="main dragsort">
				<div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
			</div>
		</div>
		@endforeach
	</div>
	@endif
</div>						
@endsection

@push('scripts')
<script src="{{file_path('/include/blk/plugin/jquery.min.js')}}"></script>
<script src="{{file_path('/include/blk/plugin/drag-arrange.js')}}"></script>
<script>
layui.config({
    base: '{{file_path('/include/blk/lib/')}}',
}).extend({
	echarts: 'extend/echarts',
	echartsTheme: 'extend/echartsTheme'
}).use(['jquery', 'form', 'layer', 'element', 'echarts'], function() {
		var $ = layui.$,
			form = layui.form,
			layer = layui.layer,
			echarts = layui.echarts;

		var _tools = {
			select_chart: function(option, key){
				if(key == ''){
					var key = $("#chart_id").val();
				}
				
				$("#chart_set_"+key+"_option").val(JSON.stringify(option));
				
				var ech = []
				,myOption = option
				,myChart = $('#Blk-chart-'+key)
				,renderchart = function(index){
				  ech[index] = echarts.init(myChart[index], layui.echartsTheme);
				  ech[index].setOption(myOption);
				  window.onresize = ech[index].resize;
				};
				if(!myChart[0]) return;
				renderchart(0);
				
				$("#chart_tpl").addClass('layui-hide');
				
				layer.closeAll();
			}
		}
		window.tools = _tools;
		
		@if (isset($chart_config['chart_set']))
		@foreach ($chart_config['chart_set'] as $key=>$vo)
			@if (isset($vo['option'])?$vo['option']:false)
				tools.select_chart({!! $vo['option'] !!}, '{{$key}}');
			@endif
		@endforeach
		@endif
	});
</script>
@endpush