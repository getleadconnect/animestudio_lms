
	<form method="POST" action="{{url('update-live-class')}}" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden"  name="live_class_id" value="{{$lc->id}}" required>
	<input type="hidden"  name="class_icon"   value="{{$lc->class_icon}}" required>
	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-12 col-xl-12 col-xxl-12">
	<label>Select Course</label>
	<select class="form-control mb-3" id="course_id_edit" name="course_id_edit" placeholder="course" required>
	<option value="">select</option>
	@foreach($crs as $r)
	<option value="{{$r->id}}" @if($r->id==$lc->course_id){{__('selected')}}@endif>{{$r->course_name}}</option>	
	@endforeach
	</select>
	</div>
	</div>
	</div>
		
	<div class="form-group">
	<div class="row">
	<div class="col-lg-12 col-xl-12 col-xxl-12">
	<label>Select Subject</label>
	<select class="form-control mb-3" id="subject_id_edit" name="subject_id_edit" placeholder="subjects" required>
	<option value="">select</option>
	@foreach($subj as $r)
	<option value="{{$r->id}}" @if($r->id==$lc->subject_id){{__('selected')}}@endif>{{$r->subject_name}}</option>	
	@endforeach
	</select>
	</div>
	</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Class Conducted By</label>
		<input type="text" class="form-control mb-3" id="conducted_by_edit" name="conducted_by_edit" placeholder="name"  value="{{$lc->conducted_by}}" required>
		</div>
		</div>
		</div>
	
	<div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Title</label>
		<input type="Text" class="form-control mb-3" name="title_edit"  placeholder="Enter Title"  value="{{$lc->title}}" required>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Live class link</label>
		<textarea class="form-control mb-3" type="text" name="class_link_edit" placeholder="Meeting link"  required>{{$lc->class_link}}</textarea>
		</div>
		</div>
	</div>
		
	<div class="form-group">
		<div class="row">
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		<label>Start Date</label>
		<input class="form-control mb-3" type="date" name="start_date_edit" placeholder="start date" value="{{$lc->start_date}}" required>
		</div>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		<label>Start Time</label>
		<input class="form-control mb-3" type="time" name="start_time_edit" placeholder="start time" value="{{$lc->start_time}}" required>
		</div>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		<label>End Time</label>
		<input class="form-control mb-3" type="time" name="end_time_edit" placeholder="end time" value="{{$lc->end_time}}" required>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		<label>class Icon </label>
		<input class="form-control mb-3" type="file"  id="class_icon_edit" name="class_icon_edit" placeholder="select file">
		</div>
		<div class="col-lg-2 col-xl-2 col-xxl-2">
		<img id="icon_output_edit" src="{{config('constants.live_class_icon').$lc->class_icon}}" style="width:70px;">
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Description</label>
		<textarea class="form-control mb-3" type="text" name="description_edit" placeholder="description"  required>{{$lc->description}}</textarea>
		</div>
		</div>
	</div>
		
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Update changes</button>
	</div>
	</form>
	
	
	<script>
	

class_icon_edit.onchange = evt => {
  const [file] = class_icon_edit.files

 var allowedExtensions="";
	allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	var filePath = file.name;

	if (!allowedExtensions.exec(filePath)) { 
		alert('Invalid file type, Try again.'); 
		$("#class_icon_edit").val('');
		/*$("#icon_output_edit").prop('src','');*/
	}
	else
	{
		if (file) {
			icon_output_edit.src = URL.createObjectURL(file)
		  }
	}  
}

$("#course_id_edit").change(function()
{
	var id=$(this).val();
	
	jQuery.ajax({
			type: "GET",
			url: "get-live-class-subjects"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#subject_id_edit").html(res);
			}
		});
});


function fileValidation1()
{
	var fileInput = document.getElementById('class_icon_edit'); 
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
	