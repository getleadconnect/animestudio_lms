<form id="editStory" >

<input type="hidden" name="story_id"  value="{{$ss->id}}" >
<input type="hidden" name="story_icon"   value="{{$ss->story_icon}}" >
<input type="hidden" name="story_video" value="{{$ss->story_video}}" >

	@csrf
	<div class="form-group">
	<label>Name</label>
	<input class="form-control mb-3" type="text" name="name_edit" placeholder="name" value="{{$ss->name}}" required>
	</div>
	
	<div class="form-group">
	<label>City & Place</label>
	<input class="form-control mb-3" type="text" name="place_edit" placeholder="city & place" value="{{ $ss->place}}"required>
	</div>
	
	<div class="form-group">
	<label>Description</label>
	<textarea class="form-control mb-3" type="text" name="description_edit" placeholder="Description"  required>{{$ss->description}}</textarea>
	</div>									
	
	<div class="form-group">
		<div class="row">
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		<label>Icon</label>
		<input type="file" class="form-control mb-3" id="story_icon_edit" name="story_icon_edit" placeholder="icon">
		</div>
		<div class="col-lg-3 col-xl-3 col-xxl-3">
		<img id="icon_output_edit" src="{{config('constants.success_story').$ss->story_icon}}" style="width:70px;">
		</div>
		</div>
	</div>

	<div class="form-group">
	<label>Video File</label>
	<input type="file" class="form-control mb-3"  onchange="fileValidation1()"  name="story_video_edit" placeholder="Video">
	<label>File: <span style="color:blue;">{{$ss->story_video}}</span></label>
	</div>
		
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
	</form>
	
<script>

story_icon_edit.onchange = evt => {
  const [file] = story_icon_edit.files

 var allowedExtensions="";
	allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	var filePath = file.name;

	if (!allowedExtensions.exec(filePath)) { 
		alert('Invalid file type, Try again.'); 
		$("#story_icon_edit").val('');
		/*$("#icon_output").prop('src','');*/
	}
	else
	{
		if (file) {
			icon_output_edit.src = URL.createObjectURL(file)
		  }
	}  
}


$("form#editStory").submit(function(e)
{
   e.preventDefault(); 
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('update-success-story')}}",
          type: 'post',
          data: formData,
		  dataType:'json',
          success: function (res) 
		  {
			 if(res.status==true)
			 {
				$('#BasicModal2').modal('hide');
				toastr.success(res.msg);
				$('#datatable').DataTable().ajax.reload(null, false);
				$('#editStory')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				$('#editStory')[0].reset();
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
});

</script>