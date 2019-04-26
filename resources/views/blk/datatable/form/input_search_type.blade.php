					@php
					$conditions_dic_arr = isset($search_conditions_dic_arr)?$search_conditions_dic_arr:false;
					@endphp
					@if ($conditions_dic_arr)
					<div class="layui-form-label search-type">
						{{-- 剔除不支持between的字段条件 --}}
						@if (!in_array($vo['data_input_form'], $data_input_form_between_dic_arr))
							@php
							if(isset($conditions_dic_arr['between'])){
								unset($conditions_dic_arr['between']);
							}
							@endphp
						@endif
						{{-- 剔除不支持like的字段条件 --}}
						@if (!in_array($vo['data_input_form'], $data_input_form_like_dic_arr))
							@php
							if(isset($conditions_dic_arr['like'])){
								unset($conditions_dic_arr['like']);
							}
							@endphp
						@endif
						{{-- 仅支持like的字段条件，剔除其他字段 --}}
						@if (in_array($vo['data_input_form'], $data_input_form_only_like_dic_arr))
							@php
							$conditions_dic_arr = [
								'like' 	=> '模糊匹配'
							];
							@endphp
						@endif
						{{-- 仅支持=的字段条件，剔除其他字段 --}}
						@if (in_array($vo['data_input_form'], $data_input_form_only_equal_dic_arr))
							@php
							$conditions_dic_arr = [
								'=' 	=> '等于',
								'<>' 	=> '不等于'
							];
							@endphp
						@endif
						@if(count($conditions_dic_arr) > 1)
						<select name="{{$vo['field']}}_search_type" lay-filter="{{$vo['field']}}_search_type">
							@foreach ($conditions_dic_arr as $k=>$ko)
							<option value="{!! $k !!}">{{$ko}}</option>
							@endforeach
						</select>
						@else
						@foreach ($conditions_dic_arr as $k=>$ko)
						<input type="hidden" name="{{$vo['field']}}_search_type" value="{!! $k !!}">
						<input type="text" readonly="readonly" value="{{$ko}}" autocomplete="off" class="layui-input">
						@endforeach
						@endif
					</div>
					@endif