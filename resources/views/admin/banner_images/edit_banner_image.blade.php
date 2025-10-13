<form method="POST" action="{{url('update-banner-image')}}" enctype="multipart/form-data">
		@csrf
		
		<input type="hidden" name="banner_id" value="{{$bi->id}}" required>
		<input type="hidden" name="banner_image" value="{{$bi->banner_image}}">
		
						
			
			
			<div class="form-group">
			<div class="row">
			<div class="col-lg-8 col-xl-8 col-xxl-8">
			<label>Banner Image(size 372 x 160)</label>
			<input type="file" class="form-control mb-3" placeholder="select file" id="banner_image_edit" name="banner_image_edit">
			</div>
			<div class="col-lg-2 col-xl-2 col-xxl-2">
			<img id="icon_output" src="{{config('constants.banner_image').$bi->banner_image}}" style="width:135px;">
			</div>
			</div>
			</div>
			
			<div class="form-group">
			<div class="row">
			<div class="col-lg-12 col-xl-12 col-xxl-12">
			<label>Banner_link</label>
			<input class="form-control mb-3" type="text" name="banner_link_edit" placeholder=" link" value="{{$bi->banner_link}}" required>
			</div>
			</div>
			</div>
	
			<div class="form-group">
			<div class="row">
			<div class="col-lg-12 col-xl-12 col-xxl-12">
			<label>Banner_type</label>
			<select class="form-control mb-3" id="banner_type_edit" name="banner_type_edit" placeholder="type">
			<option value="">--select--</option>
			<option value="1" @if($bi->banner_type==1){{__('selected')}}@endif>Course</option>
			<option value="2" @if($bi->banner_type==2){{__('selected')}}@endif>Others</option>
			</select>
			
			</div>
			
			</div>
			</div>
			
			<div class="form-group">
			<div class="row">
			<div class="col-lg-8 col-xl-8 col-xxl-8">
			<label>Category</label>
			<select class="form-control mb-3" id="category_id_edit" name="category_id_edit"  placeholder="category">
			<option value="">--select--</option>
			@foreach($cat as $r)
			<option value="{{$r->id}}" @if($r->id==$bi->course_category_id){{__('selected')}}@endif>{{$r->category}}</option>
			@endforeach
			</select>
			</div>
			</div>
			</div>
			
			<div class="form-group">
			<div class="row">
			<div class="col-lg-8 col-xl-8 col-xxl-8">
			<label>Course</label>
			<select class="form-control mb-3" id="course_id_edit" name="course_id_edit" placeholder="course">
			<option value="">--select--</option>
			@foreach($crs as $r)
			<option value="{{$r->id}}" @if($bi->id=$bi->course_id){{__('selected')}}@endif>{{$r->course_name}}</option>
			@endforeach
			</select>
			</div>
			
			</div>
			</div>
						

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Update changes</button>
		</div>
		</form>
		
<script>

$(document).ready(function()
{
  var btype=$("#banner_type").val();
  check_banner_type(btype);
});

function check_banner_type(btype)
{
	if(btype==1)
	{
		$("#course_id_edit").prop('required',true);
		$("#course_id_edit").prop('disabled',false);
		$("#category_id_edit").prop('required',true);
		$("#category_id_edit").prop('disabled',false);
	}
	else
	{
	   $("#course_id_edit").prop('required',false);
	   $("#course_id_edit").prop('disabled',true);
	   $("#category_id_edit").prop('required',false);
	   $("#category_id_edit").prop('disabled',true);
	}
	
}
		
$("#banner_type_edit").change(function()
{
	var btype=$(this).val();
	check_banner_type(btype);
});

		
banner_image_edit.onchange = evt => {
  const [file] = banner_image_edit.files

 var allowedExtensions="";
	    allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	    var filePath = file.name;

		if (!allowedExtensions.exec(filePath)) { 
			alert('Invalid file type, Try again.'); 
			$("#banner_image_edit").val('');
			/*$("#icon_output_edit").prop('src','');*/
		}
		else
		{
			if (file) {
				icon_output_edit.src = URL.createObjectURL(file)
			  }
		}  
}

function fileValidation1()
{
	var fileInput = document.getElementById('slide_image_edit'); 
	 var allowedExtensions="";
	 
		allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
		var filePath = fileInput.value; 
			
		if (!allowedExtensions.exec(filePath)) { 
			alert('Invalid file type, Try again.'); 
			fileInput.value = ''; 
			return false; 
		}
		else
		{
			return true;
		}
}

		</script>