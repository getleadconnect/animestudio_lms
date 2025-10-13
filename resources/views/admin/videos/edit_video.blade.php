@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')


<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Edit Video</div>
 
             <!-- <div class="ms-auto">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary">Settings</button>
                  <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                  </div>
                </div>
              </div>  -->
			  
            </div>
			
            <!--end breadcrumb-->

              <div class="card">
                <div class="card-header p-y-3">
				<div class="row">
				<div class="col-lg-9 col-xl-9 col-xxl-9 col-9">
                  <h6 class="mb-0 pt5">Video Details</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
                  <a href="{{url('videos')}}" class="btn btn-primary btn-xs btn-sm"><i class="fa fa-file"></i>&nbsp;View Videos</a>
				  </div>
				  
				  </div>
                </div>
                <div class="card-body">
                   <div class="row">
                     
                     <div class="col-12 col-lg-12 d-flex">
                      <div class="card  shadow-none w-100">
					  
					  <form method="POST" action="{{url('update-video')}}" enctype="multipart/form-data">
						@csrf
						
						<input type="hidden" name="video_id" value="{{$vd->id}}" >
						{{--<!--<input type="hidden" name="video_icon" value="{{$vd->video_icon}}">-->--}}
						<input type="hidden" name="video_file" value="{{$vd->video_file}}">
											  
						<div class="form-group">
						<div class="row">
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Course</label>
						<select class="form-control mb-3" id="course_id_edit" name="course_id_edit" placeholder="Select Course" required>
						<option value="">Select</option>
						@foreach($crs as $r)
						<option value="{{$r->id}}" @if($r->id==$vd->course_id){{__('selected')}}@endif >{{$r->course_name}}</option>
						@endforeach
						
						</select>
						</div>
						
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Subjects</label>
						<select class="form-control mb-3" id="subject_id_edit" name="subject_id_edit" placeholder="Select Subjects" required>
						<option value="">Select</option>
						@foreach($subj as $r)
						<option value="{{$r->id}}" @if($r->id==$vd->subject_id){{__('selected')}}@endif >{{$r->subject_name}}</option>
						@endforeach
						</select>
						</div>
												
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Topics</label>
						<select class="form-control mb-3" id="chapter_id_edit" name="chapter_id_edit" placeholder="Select Topic" required>
						<option value="">Select</option>
						@foreach($chpt as $r)
						<option value="{{$r->id}}" @if($r->id==$vd->chapter_id){{__('selected')}}@endif >{{$r->chapter_name}}</option>
						@endforeach
						</select>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Video Title</label>
						<input class="form-control mb-3" type="text" name="title_edit"  placeholder="Title" value="{{$vd->title}}" required>
						</div>
																		
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Video File</label>
						<input class="form-control" type="file" onchange="fileValidation2()" id="video_file_edit" name="video_file_edit" placeholder="Video file">
						<label>Video:<span style="color:blue;">{{$vd->video_file}}</span></label>
						</div>

						</div>
						</div>


						<div class="form-group">
						<div class="row">
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<label>Duration</label>
						<input class="form-control" type="text"  id="duration" name="duration_edit" placeholder="2:30" value="{{$vd->duration}}" required>
						<label>Eg:2:30:00</label>
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Teacher Name</label>
						<input class="form-control mb-3" type="text"  name="teacher_name_edit" placeholder="Teacher name" value="{{$vd->teacher_name}}" required>
						</div>
						
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Description</label>
						<textarea class="form-control mb-3" name="description_edit" placeholder="Description" style="text-align:left;">{{$vd->description}}</textarea>
						</div>
						
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label>Explanation</label>
						<textarea id="details" class="form-control mb-3" name="explanation_edit"  placeholder="Explanation" style="text-align:left;">{{$vd->explanation}}</textarea>
						</div>
						
						</div>
						</div>

						<div class="form-group mt-2">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12 text-right">
							<button type="submit" class="btn btn-primary">Update changes</button>
						</div>
						</div>
						</div>
						</form>

                       <!-- </div>-->
                      </div> 
                    </div>
                   </div><!--end row-->
                </div>
              </div>


@push('scripts')
<script>


var mes=$('#view_message').val().split('#');

if(mes[0]=="success")
{	
	toastr.success(mes[1]);
}
else if(mes[0]=="danger")
{
	toastr.error(mes[1]);
}

//---------------------------------------------------------------------------


$('#details').summernote({
        placeholder: 'Enter Details',
        tabsize: 2,
        height: 300
 });


$("#course_id_edit").change(function()
{
	var id=$(this).val();
	
	jQuery.ajax({
			type: "GET",
			url: "get-subjects-for-videos"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#subject_id_edit").html(res);
			}
		});

});



$("#subject_id_edit").change(function()
{
	var id=$(this).val();
	
	jQuery.ajax({
			type: "GET",
			url: "get-chapters-for-videos"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#chapter_id_edit").html(res);
			}
		});

});


function fileValidation2()
{
	var fileInput = document.getElementById('video_file_edit'); 
	var allowedExtensions="";
		
	allowedExtensions = /(\.webm|\.mp4|\.mkv|\.aac|\.mpeg)$/i; 
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
@endpush
@endsection
