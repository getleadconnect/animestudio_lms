<form method="POST" action="{{url('update-splash-slide')}}" enctype="multipart/form-data">
		@csrf
		
		<input type="hidden" name="slide_id" value="{{$ss->id}}" required>
		<input type="hidden" name="slide_image" value="{{$ss->slide_image}}">
		
		<div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Title</label>
		<input class="form-control mb-3" type="text" name="title_edit" placeholder="title" value="{{$ss->title}}" required>
		</div>
		</div>
		</div>

		<div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Description</label>
		<textarea class="form-control mb-3" name="description_edit" placeholder="Description" style="text-align:left;">{{$ss->description}}</textarea>
		</div>
		
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		<label>Slide Position</label>
		<select class="form-control mb-3" name="slide_position_edit" placeholder="select file">
		<option value="">--select--</option>
		@for($x=1;$x<=4;$x++)
		<option value="{{$x}}" @if($x==$ss->slide_position){{__('selected')}}@endif>Slide-{{$x}}</option>
		@endfor
		</select>
		</div>
		
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		<label>Slide Image</label>
		<input type="file" class="form-control mb-3" placeholder="select file" id="slide_image_edit" name="slide_image_edit">
		</div>
		<div class="col-lg-2 col-xl-2 col-xxl-2">
		<img id="icon_output_edit" src="{{ config('constants.splash_slide').$ss->slide_image}}" style="width:70px;">
		</div>
		</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Update changes</button>
		</div>
		</form>
		
		<script>
		
slide_image_edit.onchange = evt => {
  const [file] = slide_image_edit.files

 var allowedExtensions="";
	    allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	    var filePath = file.name;

		if (!allowedExtensions.exec(filePath)) { 
			alert('Invalid file type, Try again.'); 
			$("#slide_image_edit").val('');
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