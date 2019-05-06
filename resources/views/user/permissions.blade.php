@extends('layouts.base')

@section('title', '用户组权限设置')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/formSelects-v4.css')}}" media="all">
<style>
	.create td{padding: 0;}
	.create td input{border: 0;}
	.create .switch_area{padding-bottom:8px; text-align: center;}
	.layui-form-checkbox{ height:20px; line-height:20px; padding-right:0; padding-left:0; margin:2px 0;}
	.layui-form-checkbox span{ font-size:12px;}
	.layui-form-checkbox i{display:none;}
	.roles{border:0; width:100%;}
	.roles tr,td{border:0;}
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
						<tr style="background-color:#fff;">
							<!-- <th width='20'></th> -->
							<th width='230'>菜单</th>
							<th width='60'>菜单权限</th>
							<th>节点操作权限</th>
						</tr> 
					</thead>
					<tbody>
						@foreach ($data as $k=>$v)
						<tr @if(empty($v['url'])) style="background-color:#e2e2e2;" @endif>
							<!-- <td>
								@if ($v['url'])
								<input type="checkbox" name="rules[{{$v['url']}}]" value="on" lay-skin="primary" checked="">
								@endif
							</td> -->
							<td>
							
							{!!$v['title']!!}
							</td>
							<!-- <td>{!!$v['url']!!}</td> -->
							<td>
								@if ($v['url'])
								@foreach ($view as $t=>$y)
								<div><input type="checkbox" name="rules[{{$v['url']}}][{{$t}}]" @if (isset($rules[$v['url']]['button']['value'])?in_array($t, $rules[$v['url']]['button']['value']):false) checked="" @endif value="on" title="{{$y['text']}}"></div>
								@endforeach
								@endif
							</td>
							<td>
								@if ($v['url'])
								@if (isset($v['nodes'])?!empty($v['nodes']):false)
								<table class="roles">
								@foreach ($v['nodes'] as $y)
								@if (isset($y['node'])?!empty($y['node']):false)
									<tr>
										<td style="border:0; width:70px; padding:2px; padding-right:5px; text-align:right;">{{$y['title']}}</td>
										<td style="border:0; padding:2px;">
										@foreach ($y['node'] as $key=>$value)
										@if (isset($value['must'])?$value['must'] == 'on':false)
										<input type="checkbox" name="rules[{{$v['url']}}][{{$key}}]" @if (isset($rules[$v['url']]['button']['value'])?in_array($key, $rules[$v['url']]['button']['value']):false) checked="" @endif value="on" title="{{$value['text']}}">
										@endif
										@endforeach
										</td>
									</tr>
								@endif
								@endforeach
								</table>
								@endif
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
