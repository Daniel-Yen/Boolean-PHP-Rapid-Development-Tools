					@if (isset($search_conditions_dic_arr))
					<label class="layui-form-label search-type">
						<select name="{{$vo['field']}}_search_type" lay-filter="{{$vo['field']}}_search_type">
							@foreach ($search_conditions_dic_arr as $k=>$ko)
							<option field="{{$vo['field']}}" value="{{$k}}">{{$ko}}</option>
							@endforeach
						</select>
					</label>
					@endif