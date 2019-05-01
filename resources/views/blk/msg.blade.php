@extends('blk.datatable.base')

@section('title', "系统提示")

@push('css')
<style>
	
</style>
@endpush

@section('content')
<div class="layui-fluid">
  <div class="layadmin-tips">
	<br/>
    <i class="layui-icon" style="font-size:200px;">&#xe664;</i>
    
    <div class="layui-text" style="font-size: 16px;">
      {{$msg}}
    </div>
    
  </div>
</div>
@endsection