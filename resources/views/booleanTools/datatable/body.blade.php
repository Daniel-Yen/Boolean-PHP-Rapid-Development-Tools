@extends('booleanTools.datatable.base')

@section('title', isset($datatable_config['title'])?$datatable_config['title']:'数据表格')

@push('css')
<style type="text/css">
	.layui-table-view{margin: 0;}
	.layui-table-tool{background-color: #FFFFFF;}
</style>
<link rel="stylesheet" href="{{file_path('/include/booleanTools/style/formSelects-v4.css')}}" media="all">
@endpush

@section('content')
<div id="main" style="padding:0">
	@if (isset($datatable_config['directory']['has']))
	<div class="layui-side" style="width:{{$datatable_config['directory']['width']}}px">
		<style type="text/css">
			.layui-table-view{margin-left:{{$datatable_config['directory']['width']}}px;}
		</style>
		<div class="layui-side-scroll">
			<br/>
			<a lay-filter="buer-all" id="buer-all" style="padding:5px; cursor:pointer;"></a>
			<ul id="directory"></ul>
		</div>
	</div>
	@endif
	<table class="layui-hide" id="buer-table" lay-filter="buer-table"></table>
	<script type="text/html" id="buer-table-toolbar">
		<div class="layui-btn-container">
		@if (isset($datatable_config['head_menu'])?is_array($datatable_config['head_menu']):false)
		@foreach ($datatable_config['head_menu'] as $key=>$vo)
		@if ($do != "recycle")
			@if (isset($vo['must']))
			@if ($key != "recovery")
			<button class="layui-btn layui-btn-sm" lay-event="{{$key}}"><i class="layui-icon {{$vo['icon']}}"></i> {{$vo['text']}}</button>
			@endif
			@endif
		@else
			@if (in_array($key,["search","delete","recovery"]))
			<button class="layui-btn layui-btn-sm" lay-event="{{$key}}"><i class="layui-icon {{$vo['icon']}}"></i> {{$vo['text']}}</button>
			@endif
		@endif
		@endforeach
		@endif
		
		@if ($do != "recycle")
		@if (isset($datatable_config['new_head_menu'])?is_array($datatable_config['new_head_menu']):false)
		@foreach ($datatable_config['new_head_menu'] as $key=>$vo)
		<button class="layui-btn layui-btn-normal layui-btn-sm" lay-event="{{$key}}"><i class="layui-icon {{$vo['icon']}}"></i> {{$vo['text']}}</button>
		@endforeach
		@endif
		@endif
		<button id="search" class="layui-btn layui-btn-danger layui-hide layui-btn-sm" lay-event="exit_search"><i class="layui-icon layui-icon-close"></i> 退出搜索</button>
		</div>
	</script>
	<script type="text/html" id="buer-table-bar">
		@if (isset($datatable_config['line_button'])?is_array($datatable_config['line_button']):false)
		@foreach ($datatable_config['line_button'] as $key=>$vo)
		<a class="layui-btn {{isset($vo['style'])?$vo['style']:''}} layui-btn-xs" lay-event="{{$key}}">{{$vo['text']}}</a>
		@endforeach
		@endif
	</script>
</div>

<form method="post" class="layui-form layui-hide" id="where" style="width:95%" lay-filter="where">
	<div id="left_directory"></div>
	<div id="search">
		<div class="layui-fluid">
			<div class="layui-row layui-col-space15">
				<br/>
				<div class="layui-col-md11">
				@csrf
				@if (isset($search))
				@foreach ($search as $key=>$vo)
				@if (in_array($vo['data_input_form'], $data_input_form_to_input_dic_arr))
					@include ('booleanTools.datatable.form.input')
				@else
					@include ('booleanTools.datatable.form.'.$vo['data_input_form'])
				@endif
				@endforeach
				@endif
				</div>
			</div>
		</div>
	</div>
</form>

<script>
var picdomain = '{{$filedomain}}/';
//var filedomain = '{{$datatable_config['route_name']}}/?do=download&md5=';
filedomain = '{{$filedomain}}';
</script>
@foreach ($read as $vo)
@if (!empty($vo['cell_style_template']))
<script type="text/html" id="{{$vo['field']}}Tpl">
{!! $vo['cell_style_template'] !!}
</script>
@endif
@endforeach

@endsection

@push('scripts')
<script>
layui.config({
    base: '{{file_path('/include/booleanTools/lib/')}}',
}).extend({
    index: 'index',
	formSelects: 'formSelects-v4'
}).use(['tree', 'index', 'form', 'layer', 'table', 'laydate', 'formSelects'], function(){
    var admin = layui.admin
		table = layui.table,
		$ = layui.jquery,
		form = layui.form,
		layer = layui.layer,
		laydate = layui.laydate,
		formSelects = layui.formSelects;
	
	var rand = Math.floor(Math.random()*10000+1);
	@if ($do == "recycle")
	var ac = '&ac=recycle';
	@else
	var ac = '';
	@endif
	
	var base_url = '{{env('APP_URL').$datatable_config['route_name']}}?{!!$parse_url_query!!}';
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	{{-- 单元格编辑 --}}
	//监听单元格编辑
	table.on('edit(buer-table)', function(obj){
		var value = obj.value //得到修改后的值
		,data = obj.data //得到所在行所有键值
		,field = obj.field; //得到字段
		//layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
		$.ajax({
		    url:base_url+'do=update&ac=celledit',
		    type:'post',
		    data:{id:data.id,field:field,value:value},
		    // beforeSend:function () {
		    //     this.layerIndex = layer.load(0, { shade: [0.5, '#393D49'] });
		    // },
		    dataType: 'json',
		    success:function(res){
				if(res.code == '0'){
		            layer.msg(res.msg);
		            return;
		        }else{
		            layer.msg(res.msg);
		        }
		    },
		    complete: function () {
		        layer.close(this.layerIndex);
		    },
		});
	});
	
	{{-- 获取查询条件 --}}
	$.fn.serializeObject = function() {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function() {
			if (o[this.name]) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
	};
	
    var tableIns = table.render({
        elem: '#buer-table'
        ,url: base_url+'do=data'+ac
        ,toolbar: '#buer-table-toolbar'
		,defaultToolbar:['filter','exports','print']
        ,title: '{{$datatable_config['title']}}'
        ,height: 'full-0'
        ,cellMinWidth: @if (isset($datatable_config['other_set']['cell_min_width'])){{$datatable_config['other_set']['cell_min_width']}} @else 160 @endif
        ,cols: [{!! $cols !!}]
		,where: $('#where').serializeObject()
		,loading:true
        ,method: 'post'
        @empty ($datatable_config['data_source'])
		@if ( !isset( $datatable_config['other_set']['is_tree']))
		// 分页 curr起始页，groups连续显示的页码，默认每页显示的条数
		,page: {
		  layout: ['limit', 'count', 'prev', 'page', 'next', 'skip']
		  ,curr: 1
		  ,groups: 6
		  ,limit: @if (isset($datatable_config['other_set']['limit'])){{$datatable_config['other_set']['limit']}} @else 20 @endif
		}
		@endif
		@endempty
        ,id: 'buerTableReload'
    });
    
    {{-- 头工具栏事件 --}}
    table.on('toolbar(buer-table)', function(obj){
        var checkStatus = table.checkStatus(obj.config.id);
		switch(obj.event){
			@if ($datatable_config['head_menu'])
			@foreach ($datatable_config['head_menu'] as $key=>$vo)
			//{{$vo['text']}}
			case '{{$key}}':
			@if (in_array($key, ['delete', 'recovery']))
				//var data = JSON.stringify(checkStatus.data);
				var data = checkStatus.data;
				//alert(data);
				//alert(data['0']['id']);
				if(data.length>0){
					layer.confirm("请确认当前操作?", {icon:3, title:'温馨提示'}, function() {
						//layer.msg(id);
						var ids = [];
						for(var i=0, j=data.length;i<j;i++){
							var item;
							item = data[i]['id'];
							ids.push(item);
						}
						//alert(JSON.stringify(ids));
						
						$.ajax({
							@if ( !empty( $datatable_config['delete_page'] ) )
							url: "{{ $datatable_config['delete_page'] }}",
							@else
							url: base_url+"do={{ $key }}"+ac,
							@endif
							data: {
								'ids': JSON.stringify(ids)
							},
							type: "post",
							dataType: 'json',
							success: function(res) {
								if (res.code == 0) {
									layer.msg(res.msg);
									//table.reload('testReload');
									if (res.refresh == 'yes'){
										@if ($key == 'recovery')
										parent.tools.reload();
										@else
										tools.reload();
										@endif
									}
								} else {
									layer.msg(res.msg);
								}
							}
						});
					});
				}else{
					layer.msg('请至少选中一条记录');
				}
			@elseif (in_array($key, ['search']))
				$("#where").removeClass('layui-hide');
				layer.open({
					type: 1
					,title: '{{$vo['text']}}'
					,area: ['{{$vo['width']}}', '{{$vo['height']}}']
					,shade: 0.3
					,maxmin: false
					,offset: 'auto' 
					,content: $('#where')
					,btn: ['提交', '退出搜索']
					,yes: function(index){
						$("#where").addClass('layui-hide');
						layer.close(index);
						tools.reload();
						$("#search").removeClass('layui-hide');
						return false;
					}
					,btn2: function(index, layero){
						$("#where").addClass('layui-hide');
						$("#where")[0].reset();
						layui.form.render(); 	//重置表单
						tools.reload();
						layer.close(index);
						return false;
					}
					,cancel: function(index, layero){ 
					    $("#where").addClass('layui-hide');
					    $("#where")[0].reset();
					    layui.form.render(); 	//重置表单
					    layer.close(index);
						return false; 
					}
				});
				form.render(null, 'where');
				formSelects.local.render(null, 'where');
			@elseif (in_array($key, ['create']))
				layer.open({
					type: 2
					,title: '{{$vo['text']}}'
					,area: ['{{$vo['width']}}', '{{$vo['height']}}']
					,shade: 0.3
					,maxmin: false
					,offset: 'auto' 
					,content: base_url+'do={{$key}}'
				});
			@elseif (in_array($key, ['update']))
				var data = checkStatus.data;
				//alert(data);
				//alert(data['0']['id']);
				if(data.length == 1){
					layer.open({
						type: 2
						,title: '{{$vo['text']}}'
						,area: ['{{$vo['width']}}', '{{$vo['height']}}']
						,shade: 0.3
						,maxmin: false
						,offset: 'auto' 
						,content: base_url+'do={{$key}}&id='+data['0']['id']
					});
				}else if(data.length > 1){
					layer.msg('请最多选中一条记录');
				}else{
					layer.msg('请选中一条记录');
				}
			@else
				layer.open({
					type: 2
					,title: '{{$vo['text']}}'
					,area: ['{{$vo['width']}}', '{{$vo['height']}}']
					,shade: 0.3
					,maxmin: false
					,offset: 'auto' 
					,content: base_url+'do={{$key}}'
				});
			@endif
			break;
			@endforeach
			@endif
			case 'exit_search':
				$("#where")[0].reset();
				layui.form.render();
				tools.reload();
				$("#search").addClass('layui-hide');
			break;
			{{-- 附加头部工具菜单 --}}
			@if (isset($datatable_config['new_head_menu']))
			@foreach ($datatable_config['new_head_menu'] as $key=>$vo)
			//{{$vo['text']}}
			case '{{$key}}':
			@if ($vo['open_tepe'] == 'window')
				layer.open({
					type: 2
					,title: '{{$vo['text']}}'
					,area: ['{{$vo['width']}}', '{{$vo['height']}}']
					,shade: 0.3
					,maxmin: false
					,offset: 'auto' 
					,content: base_url+'do={{$key}}'
				});
			@elseif ($vo['open_tepe'] == 'ajax')
				layer.confirm("请确认当前操作?", {icon:3, title:'温馨提示'}, function() {
					$.ajax({
						url: base_url+'do={{ $key }}',
						type: "post",
						dataType: 'json',
						success: function(res) {
							if (res.code == 0) {
								layer.msg(res.msg);
								if (res.refresh == 'yes'){
									tools.reload();
								}
							} else {
								layer.msg(res.msg);
							}
						}
					});
				});
			@endif
			break;
			@endforeach
			@endif
        };
    });
		
    {{-- 监听行工具事件 --}}
    table.on('tool(buer-table)', function(obj){
        var data = obj.data;
		var additional_window_title = '';
		@foreach ($datatable_config['additional_window_title'] as $v)
		additional_window_title = additional_window_title+data['{{$v}}']+' / ';
		@endforeach
		//alert(data['id']);
		
		switch(obj.event){
			@if (isset($datatable_config['line_button']))
			@foreach ($datatable_config['line_button'] as $key=>$vo)
			//{{$vo['text']}}
			case '{{$key}}':
			@if ($vo['open_tepe'] == 'window')
				layer.open({
					type: 2
					,title: additional_window_title+'{{$vo['text']}}'
					,area: ['{{$vo['width']}}', '{{$vo['height']}}']
					,shade: 0.3
					,maxmin: false
					,offset: 'auto'
					@if (isset($vo['route'])?$vo['route']:false)
					,content: "{{env('APP_URL').$vo['route']}}?{!!$parse_url_query!!}{{isset($datatable_config['id_prefix'])?$datatable_config['id_prefix']:''}}id="+data['id']
					@else
					,content: base_url+"do={{$key}}&from=line&{{isset($datatable_config['id_prefix'])?$datatable_config['id_prefix']:''}}id="+data['id'],
					@endif
				});
			@elseif ($vo['open_tepe'] == 'ajax')
				layer.confirm("请确认当前操作?", {icon:3, title:'温馨提示'}, function() {
					$.ajax({
						@if (isset($vo['route'])?$vo['route']:false)
						url: "{{env('APP_URL').$vo['route']}}?{!!$parse_url_query!!}{{isset($datatable_config['id_prefix'])?$datatable_config['id_prefix']:''}}id="+data['id'],
						@else
						url: base_url+"do={{$key}}&from=line&{{isset($datatable_config['id_prefix'])?$datatable_config['id_prefix']:''}}id="+data['id'],
						@endif
						type: "post",
						dataType: 'json',
						success: function(res) {
							if (res.code == 0) {
								//alert(res.refresh);
								layer.msg(res.msg);
								if (res.refresh == 'yes'){
									tools.reload();
								}
							} else {
								layer.msg(res.msg);
							}
						}
					});
				});
			@endif
			break;
			@endforeach
			@endif
			
			{{-- 添加单元格事件 --}}
			@if (isset($datatable_config['datatable_set']))
			@foreach ($datatable_config['datatable_set'] as $key=>$vo)
			@if (isset($vo['event'])?$vo['event']:false)
			case '{{$vo['field']}}Event':
			@if ($vo['event_type'] == 'new_window')
				@if (strstr($vo['event_behavior'], '://'))
				window.open("{{$vo['event_behavior']}}");
				@elseif (isset($vo['event_route'])?$vo['event_route']:false)
				window.open("{{$vo['event_route']}}?{!!$parse_url_query!!}{{isset($datatable_config['id_prefix'])?$datatable_config['id_prefix']:''}}id="+data['id']);
				@else
				window.open(base_url+"do={{$vo['field']}}Event&from=cell&{{isset($datatable_config['id_prefix'])?$datatable_config['id_prefix']:''}}id="+data['id']);
				@endif
			@elseif ($vo['event_type'] == 'window')
				layer.open({
					type: 2
					,title: '单元格：'+data['{{$vo['field']}}']
					,area: ['100%', '100%']
					,shade: 0.3
					,maxmin: false
					,offset: 'auto'
					@if (isset($vo['event_route'])?$vo['event_route']:false)
					,content: "{{$vo['event_route']}}?{!!$parse_url_query!!}{{isset($datatable_config['id_prefix'])?$datatable_config['id_prefix']:''}}id="+data['id']
					@else
					,content: base_url+"do={{$vo['field']}}Event&from=cell&{{isset($datatable_config['id_prefix'])?$datatable_config['id_prefix']:''}}id="+data['id'],
					@endif
				});
			@elseif ($vo['event_type'] == 'ajax')
				layer.confirm("请确认当前操作?", {icon:3, title:'温馨提示'}, function() {
					$.ajax({
						@if (isset($vo['event_route'])?$vo['event_route']:false)
						url: "{{$vo['event_route']}}?{!!$parse_url_query!!}{{isset($datatable_config['id_prefix'])?$datatable_config['id_prefix']:''}}id="+data['id'],
						@else
						url: base_url+"do={{$vo['field']}}Event&from=cell&{{isset($datatable_config['id_prefix'])?$datatable_config['id_prefix']:''}}id="+data['id'],
						@endif
						type: "post",
						dataType: 'json',
						success: function(res) {
							if (res.code == 0) {
								//alert(res.refresh);
								layer.msg(res.msg);
								if (res.refresh == 'yes'){
									tools.reload();
								}
							} else {
								layer.msg(res.msg);
							}
						}
					});
				});
			@endif
			break;
			@endif
			@endforeach
			@endif
		};
	});
	
	@if (isset($datatable_config['directory']['has']))
	layui.tree({
		elem: '#directory'
		,target: '_blank'
		,click: function(item){ 		{{-- 点击节点回调 --}}
			var associated_field = '{{$datatable_config['directory']['associated_field']}}';
			if(associated_field == "" || associated_field == null || associated_field == undefined){
				layer.msg('没有指定关联字段');
			}else{
				$("#left_directory").html('<input type="text" name="where_field" value="{{$datatable_config['directory']['associated_field']}}" /><input type="text" name="condition" value="'+JSON.stringify(item.condition)+'" />');
				tools.reload();
			}
		}
		,nodes: @if ( isset($datatable_config['left_tree']['code'])?$datatable_config['left_tree']['code'] == 0:false ) @json($datatable_config['left_tree']['data']) @else [] @endif
	});
	
	@if ( isset($datatable_config['left_tree']['code'])?$datatable_config['left_tree']['code'] == 1:false )
	<div class="layui-form-mid layui-word-aux"><span class="layui-badge">{{$datatable_config['left_tree']['msg']}}</span></div>
	@endif
	$("#buer-all").html('<i class="layui-icon layui-icon-template-1"></i> 全部');
	
	$(document).on('click','#buer-all',function(){
		//layer.msg('hello');
		$("#left_directory").html('');
		tools.reload();
	});
	@endif
	
	{{-- 搜索条件 --}}
	@if (isset($search)?$search:false)
	@foreach ($search as $key=>$vo)
	@if (in_array($vo['data_input_form'], $data_input_form_between_dic_arr))
	form.on('select({{$vo['field']}}_search_type)', function(data){
		if(data.value == 'between'){
			$('#between_{{$vo['field']}}_end').removeClass('layui-hide');
		}else{
			$('#between_{{$vo['field']}}_end').addClass('layui-hide');
		}
		layui.form.render(); 	//重置表单
	});	
	@endif
	@endforeach
	@endif
	
	{{-- 搜索表单控件初始化 --}}
	@if (isset($search)?$search:false)
	@foreach ($search as $key=>$vo)
	@if (in_array($vo['data_input_form'], $data_input_form_to_input_dic_arr))
		@include ('booleanTools.datatable.form_js.input')
	@else
		@include ('booleanTools.datatable.form_js.'.$vo['data_input_form'])
	@endif
	@endforeach
	@endif
	
	
	var _tools = {
		layerCloseAll: function(){
			layer.closeAll();
		},
		reload: function(){
			{{-- 执行重载 --}}
			layer.closeAll();
			tableIns.reload({
				page: {
					curr: 1 {{-- 重新从第 1 页开始 --}}
				}
				,where: $('#where').serializeObject()
			});
			tools.refresh_table();
		},
		refresh_table: function(){
			//添加刷新按钮
			$(".layui-table-tool-self").append('<div class="layui-inline" title="刷新" onclick="tools.reload();" lay-event="LAYTABLE_REFRESH"><i class="layui-icon layui-icon-refresh"></i></div>');
		}
	}
	window.tools = _tools;
	tools.refresh_table();
});
</script>
@endpush