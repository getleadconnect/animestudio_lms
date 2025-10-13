<form method="POST" action="{{url('update-chapter')}}" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden" name="chapter_id"  value="{{$ch->id}}">
	<input type="hidden" name="chapter_icon"  value="{{$ch->chapter_icon}}">

	<div class="form-group">
	<label>Course</label>
	<select class="form-control mb-3" name="course_id_edit" id="course_id_edit" required>
	<option value="">Select</option>
	@foreach($crs as $r)
	<option value="{{$r->id}}" @if($r->id==$ch->course_id){{__('selected')}}@endif >{{$r->course_name}}</option>
	@endforeach
	</select>
	</div>
	
	<div class="form-group">
	<label>Select Subject</label>
	<select class="form-control mb-3" name="subject_id_edit" id="subject_id_edit" required>
	<option value="">Select</option>
	@foreach($subj as $r)
	<option value="{{$r->id}}" @if($r->id==$ch->subject_id){{__('selected')}}@endif >{{$r->subject_name}}</option>
	@endforeach
	</select>
	</div>
						
	<div class="form-group">
	<label>Chapter Name</label>
	<input class="form-control mb-3" type="text" name="chapter_name_edit" placeholder="Chapter name" value="{{$ch->chapter_name}}" required>
	</div>
	
	<div class="form-group">
	<label>Description</label>
	<textarea class="form-control mb-3" name="description_edit" placeholder="description" required>{{$ch->description}}</textarea>
	</div>

	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	<label>Icon (size 173x173)</label>
	<input type="file" class="form-control mb-3" id="chapter_icon_edit" name="chapter_icon_edit"  placeholder="icon">
	</div>
	<div class="col-lg-4 col-xl-4 col-xxl-4">
	<img id="icon_output_edit" src="{{config('constants.chapter_icon').$ch->chapter_icon }}" style="width:70px;">
	</div>
	</div>
	</div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
	</form>


<script>
	

chapter_icon_edit.onchange = evt => {
  const [file] = chapter_icon_edit.files

 var allowedExtensions="";
	    allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	    var filePath = file.name;

		if (!allowedExtensions.exec(filePath)) { 
			alert('Invalid file type, Try again.'); 
			$("#chapter_icon_edit").val('');
			//$("#icon_output_edit").prop('src','');
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
			url: "get-subjects"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#subject_id_edit").html(res);
			}
		});

});


	</script>	