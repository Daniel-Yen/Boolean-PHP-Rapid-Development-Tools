@extends('layouts.base')

@section('title', 'Databale配置生成')

@push('css')
<link rel="stylesheet" href="{{file_path('/include/blk/style/formSelects-v4.css')}}" media="all">
<style>
	.create td{padding: 0;}
	.create td input{border: 0;}
	.create .switch_area{padding-bottom:8px; text-align: center;}
	#textarea {
		display: block;
		margin:0 auto;
		overflow: hidden;
		width: 550px;
		font-size: 14px;
		height: 18px;
		line-height: 24px;
		padding:2px;
	}
</style>
@endpush

@section('content')
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<form id="iframeForm" class="layui-form" action="" method="post">
				@csrf
				<div class="layui-form-item">
					<label class="layui-form-label" style="width:60px;">title</label>
					<div class="layui-input-inline" style="width:65px;">
						<input name="title[is_title]" @if (isset($attribute['title']['is_title'])) @if ($attribute['title']['is_title'] == 'on') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="显示|隐藏">
					</div>
					<div class="layui-input-inline" style="width:250px;">
						<input type="text" name="title[text]" value="{{isset($attribute['title']['text'])?$attribute['title']['text']:''}}" autocomplete="off"  class="layui-input">
					</div>
					<label class="layui-form-label" style="width:45px;">副标题</label>
					<div class="layui-input-inline" style="width:200px;">
						<input type="text" name="title[subtext]" value="{{isset($attribute['title']['subtext'])?$attribute['title']['subtext']:''}}" autocomplete="off"  class="layui-input">
					</div>
					<label class="layui-form-label" style="width:70px;">副标题链接</label>
					<div class="layui-input-inline" style="width:200px;">
						<input type="text" name="title[sublink]" value="{{isset($attribute['title']['sublink'])?$attribute['title']['sublink']:''}}" autocomplete="off"  class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label" style="width:40px;"></label>
					<label class="layui-form-label" style="width:20px;">X:</label>
					<div class="layui-input-inline" style="width:150px;">
						<select name="x" lay-filter="x">
							<option value="window">标题 X 轴位置</option>
							@foreach ($x as $key=>$vo)
							<option @if (isset($attribute_arr['x'])) @if ($attribute_arr['x'] == $key) selected="selected" @endif  @endif value="{{$key}}">{{$vo}}</option>
							@endforeach
						</select>
					</div>
					<label class="layui-form-label" style="width:20px;">Y:</label>
					<div class="layui-input-inline" style="width:150px;">
						<select name="y" lay-filter="y">
							<option value="window">标题 Y 轴位置</option>
							@foreach ($y as $key=>$vo)
							<option @if (isset($attribute_arr['y'])) @if ($attribute_arr['y'] == $key) selected="selected" @endif  @endif value="{{$key}}">{{$vo}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label" style="width:60px;">toolbox</label>
					<div class="layui-input-inline" style="width:65px;">
						<input name="toolbox[show]" @if (isset($attribute['toolbox']['show'])) @if ($attribute['toolbox']['show'] == 'true') checked="checked" @endif @endif type="checkbox" lay-skin="switch" lay-text="显示|隐藏">
					</div>
					<div class="layui-input-inline" style="width:250px;">
						<input type="text" name="title[text]" value="{{isset($attribute['title']['text'])?$attribute['title']['text']:''}}" autocomplete="off"  class="layui-input">
					</div>
					<label class="layui-form-label" style="width:45px;">副标题</label>
					<div class="layui-input-inline" style="width:200px;">
						<input type="text" name="title[subtext]" value="{{isset($attribute['title']['subtext'])?$attribute['title']['subtext']:''}}" autocomplete="off"  class="layui-input">
					</div>
					<label class="layui-form-label" style="width:70px;">副标题链接</label>
					<div class="layui-input-inline" style="width:200px;">
						<input type="text" name="title[sublink]" value="{{isset($attribute['title']['sublink'])?$attribute['title']['sublink']:''}}" autocomplete="off"  class="layui-input">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	layui.config({
		base: '{{file_path('/include/blk/lib/')}}',
	}).extend({
		index: 'index',
		formSelects: 'modules/formSelects-v4'
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
	
	/**
	* 文本框根据输入内容自适应高度
	* @param                {HTMLElement}        输入框元素
	* @param                {Number}                设置光标与输入框保持的距离(默认0)
	* @param                {Number}                设置最大高度(可选)
	*/
	var autoTextarea = function (elem, extra, maxHeight) {
        extra = extra || 15;
        var isFirefox = !!document.getBoxObjectFor || 'mozInnerScreenX' in window,
        isOpera = !!window.opera && !!window.opera.toString().indexOf('Opera'),
                addEvent = function (type, callback) {
                        elem.addEventListener ?
                                elem.addEventListener(type, callback, false) :
                                elem.attachEvent('on' + type, callback);
                },
                getStyle = elem.currentStyle ? function (name) {
                        var val = elem.currentStyle[name];
 
                        if (name === 'height' && val.search(/px/i) !== 1) {
                                var rect = elem.getBoundingClientRect();
                                return rect.bottom - rect.top -
                                        parseFloat(getStyle('paddingTop')) -
                                        parseFloat(getStyle('paddingBottom')) + 'px';        
                        };
 
                        return val;
                } : function (name) {
                                return getComputedStyle(elem, null)[name];
                },
                minHeight = parseFloat(getStyle('height'));
 
        elem.style.resize = 'none';
 
        var change = function () {
                var scrollTop, height,
                        padding = 0,
                        style = elem.style;
 
                if (elem._length === elem.value.length) return;
                elem._length = elem.value.length;
 
                if (!isFirefox && !isOpera) {
                        padding = parseInt(getStyle('paddingTop')) + parseInt(getStyle('paddingBottom'));
                };
                scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
 
                elem.style.height = minHeight + 'px';
                if (elem.scrollHeight > minHeight) {
                        if (maxHeight && elem.scrollHeight > maxHeight) {
                                height = maxHeight - padding;
                                style.overflowY = 'auto';
                        } else {
                                height = elem.scrollHeight - padding;
                                style.overflowY = 'hidden';
                        };
                        style.height = height + extra + 'px';
                        scrollTop += parseInt(style.height) - elem.currHeight;
                        document.body.scrollTop = scrollTop;
                        document.documentElement.scrollTop = scrollTop;
                        elem.currHeight = parseInt(style.height);
                };
        };
 
        addEvent('propertychange', change);
        addEvent('input', change);
        addEvent('focus', change);
        change();
	};
	//textarea高度自适应
	autoTextarea(document.getElementById("cell_style_template"));
	autoTextarea(document.getElementById("data_source"));
</script>
@endpush
