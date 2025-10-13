<form method="POST" action="{{url('update-subject')}}" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden" name="subject_id" value="{{$subj->id}}">
	<input type="hidden" name="subject_icon" value="{{$subj->subject_icon}}">
	
	<div class="form-group">
	<label>Course</label>
	<select class="form-control mb-3" name="course_id_edit" required>
	<option value="">Select</option>
	@foreach($crs as $r)
	<option value="{{$r->id}}" @if($r->id==$subj->course_id){{__('selected')}} @endif >{{$r->course_name}}</option>	
	@endforeach
	</select>
	</div>
						
	<div class="form-group">
	<label>Subject Name</label>
	<input class="form-control mb-3" type="text" name="subject_name_edit" placeholder="Subject name" value="{{$subj->subject_name}}" required>
	</div>
	
	<div class="form-group">
	<label>Description</label>
	<textarea class="form-control mb-3" name="description_edit" placeholder="description" required>{{$subj->description}}</textarea>
	</div>
	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	<label>Icon</label>
	<input type="file" class="form-control mb-3" id="subject_icon_edit" name="subject_icon_edit"  placeholder="icon" >
	</div>
	<div class="col-lg-4 col-xl-4 col-xxl-4">
	<img id="icon_output_edit" src="{{config('constants.subject_icon').$subj->subject_icon }}" style="width:70px;">
	</div>
	</div>
	</div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
	</form>
	
<script>
	
subject_icon_edit.onchange = evt => {
  const [file] = subject_icon_edit.files

 var allowedExtensions="";
	allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	var filePath = file.name;

	if (!allowedExtensions.exec(filePath)) { 
		alert('Invalid file type, Try again.'); 
		$("#subject_icon_edit").val('');
		/*$("#icon_output_edit").prop('src','');*/
	}
	else
	{
		if (file) {
			icon_output_edit.src = URL.createObjectURL(file)
		  }
	}  
}

</script>