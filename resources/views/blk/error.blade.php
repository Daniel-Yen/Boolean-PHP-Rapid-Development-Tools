@extends('blk.datatable.base')

@section('title', $message)

@push('css')
<style>
	.main{ padding-top:100px; width:500px; margin:0 auto;}
	.main div{padding-top:15px; font-size:16px;}
	.msg{ border-bottom:1px solid green; padding-bottom:10px; font-size:20px;}
	.msg i{color:red;}
	#href{color:blue;}
</style>
@endpush

@section('content')
<div class="layui-container">
	<div class="layui-row">
		<div class="layui-col-xs3">
			&nbsp;
		</div>
		<div class="layui-col-xs6 main">
			<div class="msg">
				<i class="layui-icon layui-icon-close"></i> {{$message}}
			</div>
			<div><i class="layui-icon layui-icon-about"></i> {{$supplement}}</div>
			<div>页面自动 <a id="href" href="javascript :history.back(-1)">跳转</a> 等待时间： <b id="wait">{{$jumpTime}}</b> 秒</div>
		</div>
		<div class="layui-col-xs3">
			&nbsp;
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	(function(){
        var wait = document.getElementById('wait'),
            href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                history.back(-1);
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>    
@endpush