		@foreach ($dom as $key=>$vo)
		@switch ($vo['data_input_form'])
		@case ('input')

		@break
		@case ('textarea')

		@break
		@case ('select')
			
		@break
		@case ('tree_select')
			
		@break
		@case ('multiple_select')
			
		@break
		@case ('cascade_select')
			
		@break
		@case ('year')
			
		@break
		@case ('year_mouth')
			
		@break
		@case ('date')
			
		@break
		@case ('time')
			
		@break
		@case ('datetime')
			
		@break
		@case ('date_scope')
			
		@break
		@case ('year_scope')
			
		@break
		@case ('year_mouth_scope')
			
		@break
		@case ('time_scope')
			
		@break
		@case ('datetime_scope')
			
		@break
		@case ('color_choices')
			
			{{-- 颜色选择 end --}}
		@break
		@case ('single_file_upload')
			
		@break
		@case ('photos_upload')
			
		@break
		@case ('single_photo_upload')
			
		@break		
		@case ('files_upload')
				
		@break
		@case ('layui_editer')
			
		@break
		@case ('layui_editer_simple')
			
		@break
		@case ('editormd')
			
		@break
		@endswitch
		@endforeach
