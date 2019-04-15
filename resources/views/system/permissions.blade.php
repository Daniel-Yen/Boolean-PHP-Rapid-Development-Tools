@extends('layouts.base')

@section('title', 'Databale配置生成')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/formSelects-v4.css')}}" media="all">
<style>
	.create td{padding: 0;}
	.create td input{border: 0;}
	.create .switch_area{padding-bottom:8px; text-align: center;}
</style>
@endpush

@section('content')
<div class="layui-fluid">
	<div class="layui-row">
		<div class="layui-col-md12">
			<form id="iframeForm" class="layui-form" action="" method="post">
				@csrf
				<table class="layui-table">
					<thead>
						<tr>
							<!-- <th width='20'></th> -->
							<th width='200'>菜单名称</th>
							<th width='200'>规则名称</th>
							<th>功能节点</th>
						</tr> 
					</thead>
					<tbody>
						@foreach ($data as $k=>$v)
						<tr>
							<!-- <td>
								@if ($v['url'])
								<input type="checkbox" name="rules[{{$v['url']}}]" value="on" lay-skin="primary" checked="">
								@endif
							</td> -->
							<td>{!!$v['title']!!}</td>
							<td>{!!$v['url']!!}</td>
							<td>
								@if (isset($v['button'])?!empty($v['button']):false)
								@foreach ($v['button'] as $key=>$value)
								<input type="checkbox" name="rules[{{$v['url']}}][{{$key}}]" @if (isset($rules[$v['url']]['button']['value'])?in_array($key, $rules[$v['url']]['button']['value']):false) checked="" @endif value="on" title="{{$value['text']}}">
								@endforeach
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div class="layui-form-item layui-form-text">
					<button class="layui-btn" lay-submit="" lay-filter="submit">立即提交</button>
					<button type="reset" class="layui-btn layui-btn-primary">重置</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	layui.config({
		base: '{{file_path('/include/')}}',
	}).extend({
		index: 'lib/index', //主入口模块
		formSelects: 'formSelects-v4'
	}).use(['jquery', 'form', 'element', 'formSelects'], function() {
		var $ = layui.$,
			form = layui.form,
			layer = layui.layer,
			layedit = layui.layedit,
			formSelects = layui.formSelects,
			laydate = layui.laydate;
		
		//监听提交
		form.on('submit(submit)', function(data){
			return true;
		});
	});
</script>
@endpush
