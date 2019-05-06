@extends('blk.datatable.base')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/blk/style/step.css')}}" media="all">
<style type="text/css">
	
</style>
@endpush

@section('content')
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div id="import_step"></div>
			@if ($step == '1')
			<form class="layui-form" method="post" enctype="multipart/form-data" action="/{{request()->path().'?do=import&ac=data'}}">
				@csrf
				<table class="layui-table">
					<colgroup>
					  <col width="200">
					</colgroup>
					<thead>
					  <tr>
						<th style="text-align:right;">下载导入模版</th>
						<th><a style="color:#06F; font-weight:bolder;" href="/{{request()->path()}}?do=import&ac=download">“{{$title}}”导入摸板下载</a></th>
					  </tr> 
					</thead>
					<tbody>
					  <tr>
						<td style="text-align:right;">选择导入的CSV文件</td>
						<td><input name="file" type="file" id="file" /></td>
					  </tr>
					</tbody>
				</table>
				<div class="layui-form-item">
					<button class="layui-btn" lay-submit="" lay-filter="demo2">提交</button>
				</div>
			</form>
			@elseif ($step == '2')
			<form class="layui-form" method="post" action="/{{request()->path()}}?do=import&ac=save">
				@csrf
				<textarea class="layui-hide" name="DATA">{{json_encode($data)}}</textarea>
			    <table class="layui-table">
					<colgroup>
					  <col width="200">
					</colgroup>
					<thead>
					  <tr>
						@foreach ($datatable_set as $v)
						@if(isset($v['import'])?$v['import'] == 'on':false)
						<th>{{$v['title']}}</th>
						@endif
						@endforeach
					  </tr> 
					</thead>
					<tbody>
						@foreach ($data as $value)
						<tr>
							@foreach ($datatable_set as $v)
							@if(isset($v['import'])?$v['import'] == 'on':false)
							<td>{{$value[$v['field']]}}</td>
							@endif
							@endforeach
						</tr>
						@endforeach
					</tbody>
				</table>
				<div class="layui-form-item">
					<button class="layui-btn" lay-submit="" lay-filter="demo2">提交</button>
					<a href="/{{request()->path()}}?do=import" class="layui-btn layui-btn-normal">返回</a>
				</div>
			</form>
			@elseif ($step == '3')
			<form class="layui-form" method="post" action="/{{request()->path()}}?do=import&ac=save">
				<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
					<legend>导入结果</legend>
					<div style="padding-top:15px;">
						新增了<span style="font-size:24px; color:green;">{{$num_insert}}</span>条记录;
					</div>
				</fieldset>
				<div class="layui-form-item">
					<a href="/{{request()->path()}}?do=import" class="layui-btn layui-btn-normal">继续导入</a>
				</div>
			</form>
			@endif
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	layui.config({
		base: '{{file_path('/include/blk/lib/')}}',
	}).extend({
		step: 'extend/step'
	}).use(['jquery', 'form', 'step'], function() {
			var $ = layui.$,
				form = layui.form,
				step = layui.step;
			
			var importStep = {
				steps: [{"title" : "<br/>第一步：选择文件", "time" : ""},
					   {"title" : "<br/>第二步：数据验证", "time" : ""},
					   {"title" : "<br/>第三步：导入结果", "time" : ""}]
				,current: {{$step}}
			};
			
			step.ready({
				elem: '#import_step',
				data: importStep,
				width: '30%',
				color: {
					success:'#33ABA0',
					error:'#848484'
				}
			})
		});
</script>
@endpush
