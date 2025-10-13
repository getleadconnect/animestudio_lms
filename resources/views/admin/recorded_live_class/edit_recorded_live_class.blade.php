<form method="POST" action="{{url('update-recorded-live-class')}}" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden" name="rlclass_id" value="{{$rlc->id}}">
	<input type="hidden" name="class_icon" value="{{$rlc->class_icon}}">
	<input type="hidden" name="video_file" value="{{$rlc->video_file}}">
	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-8 col-xl-8 col-xxl-8">
		<label>Course</label>
		<select class="form-control mb-3" name="course_id_edit" placeholder="course" required> 
		<option value="">--select--</option>
		@foreach($crs as $r)
		<option value="{{$r->id}}" @if($r->id==$rlc->course_id){{__('selected')}}@endif>{{$r->course_name}}</option>					
		@endforeach
		</select>
	</div>
	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Title</label>
		<input class="form-control mb-3" type="text" name="title_edit" placeholder="title" value="{{$rlc->title}}" required>
	</div>
	</div>
	</div>

	<div class="form-group">
	<div class="row">
	<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Description</label>
		<textarea class="form-control mb-3" name="description_edit" placeholder="Description" style="text-align:left;">{{$rlc->title}}</textarea>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	<label>Class Icon</label>
	  <input type="file" class="form-control mb-3" placeholder="select file" id="class_icon_edit" name="class_icon_edit">
	</div>
	<div class="col-lg-2 col-xl-2 col-xxl-2">
	  <img id="icon_output_edit" src="{{config('constants.recorded_class').$rlc->class_icon}}" style="width:70px;">
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-11 col-xl-11 col-xxl-11">
	   <label>Class Video File</label>
	   <input type="file" class="form-control" onchange="file_Validation()" placeholder="select file" id="video_file_edit" name="video_file_edit" >
	   <label>Video: <span>{{str_replace('recorded_classes/',"",$rlc->video_file)}}</span>
	</div>
	</div>
	</div>

	<div class="form-group mt-3">
	<div class="row">
	<div class="col-lg-4 col-xl-4 col-xxl-4">
	  <label>Duration</label>
	  <input type="text" class="form-control" placeholder="2:30:00" id="duration_edit" name="duration_edit" value="{{$rlc->duration}}" required>
	  <span>Eg: 2:30:00</span>
	</div>
	
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	   <label>Class By</label>
	   <input type="text" class="form-control mb-3" placeholder="name" name="class_by_edit" value="{{$rlc->class_by}}" required>
	</div>
	</div>
	</div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
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
			$("#icon_output_edit").prop('src','');
		}
		else
		{
			if (file) {
				icon_output_edit.src = URL.createObjectURL(file)
			  }
		}  
}


function file_Validation()
{
	var fileInput = document.getElementById('video_file_edit'); 
	var allowedExtensions="";
		
	allowedExtensions = /(\.webm|\.mp4|\.aac|\.mkv|\.mpeg)$/i; 
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