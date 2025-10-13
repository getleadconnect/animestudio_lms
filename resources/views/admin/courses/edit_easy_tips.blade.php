
	<form method="POST" action="{{url('update-easy-tips')}}" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden"  name="tips_id"  value="{{ $et->id}}" required>
	<input type="hidden"  name="tips_icon"  value="{{ $et->tips_icon}}" required>
	<input type="hidden" name="tips_file" value="{{ $et->tips_file}}" required>
	<input type="hidden" name="file_type" value="{{ $et->file_type}}" required>

		<div class="form-group">
		<div class="row">
		<label>Select Course</label>
		<div class="col-12 col-lg-12 col-xl-12 col-xxl-12">	
			<select class="form-control mb-3"  name="course_id_edit" required>
			<option value="">Select</option>
			@foreach($crs as $r)
			<option value="{{$r->id}}" @if($r->id==$et->course_id){{__('selected')}}@endif>{{$r->course_name}}</option>	
			@endforeach
			</select>
			</div>
		</div>
		</div>
		<div class="form-group">
		<div class="row">
		<div class="col-12 col-lg-12 col-xl-12 col-xxl-12">
		<div class="form-group">
			<label>Title </label>
			<input type="text" class="form-control mb-3" name="title_edit" placeholder="Enter title" value="{{ $et->title}}" required>
			</div>
		
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<div class="col-12 col-lg-12 col-xl-12 col-xxl-12">
			<div class="form-group">
			<label>Description </label>
			<textarea class="form-control mb-3" name="description_edit" placeholder="Enter description" required>{{$et->description}}</textarea>
			</div>
		
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		<label>Easy tips icon</label>
		<input type="file" class="form-control mb-3" onchange="fileValidation()" placeholder="select file" id="tips_icon_edit" name="tips_icon_edit">
		</div>
		<div class="col-lg-2 col-xl-2 col-xxl-2">
		<img id="icon_output_edit" src="{{ config('constants.easy_tips').$et->tips_icon}}" style="width:70px;">
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<div class="col-3 col-lg-3 col-xl-3col-xxl-3">
			<label>File Type</label>
			<select class="form-control mb-3" id="file_type_edit"  name="file_type_edit" required>
			<option value="">Select</option>
			<option value="1" @if($et->file_type==1){{__('selected')}}@endif>Video</option>	
			<option value="2" @if($et->file_type==2){{__('selected')}}@endif>PDF</option>	
			</select>
		</div>
		<div class="col-9 col-lg-9 col-xl-9col-xxl-9">
		<div class="form-group">
			<label>Select File(video/pdf)</label>
			<input type="file" id="tips_file_edit" class="form-control" onchange="fileValidation1()" name="tips_file_edit" placeholder="select file(video/PDF)">
			</div>
		</div>
		<label>File: <a href="{{config('constants.easy_tips').$et->tips_file }}" target="_blank">{{$et->tips_file}}</a></label>
		</div>
		
		</div>

	<div class="modal-footer mt-2">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Update changes</button>
	</div>
	
	</form>


<script>


tips_icon_edit.onchange = evt => {
  const [file] = tips_icon_edit.files

 var allowedExtensions="";
	    allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	    var filePath = file.name;

		if (!allowedExtensions.exec(filePath)) { 
			alert('Invalid file type, Try again.'); 
			$("#tips_icon_edit").val('');
			$("#icon_output_edit").prop('src','');
		}
		else
		{
			if (file) {
				icon_output_edit.src = URL.createObjectURL(file)
			  }
		}  
}


</script>