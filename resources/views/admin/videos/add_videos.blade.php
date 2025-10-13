@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')
<style>
.progress { position:relative; width:100%; }
.bar { background-color: #00ff00; width:0%; height:20px; }
.percent { position:absolute; display:inline-block; left:50%; color: #040608;}

.note-btn-group .dropdown-toggle::after
{
	content:none;
}
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Add Videos</div>
 
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
					  
					  
					  <form method="POST" id="addVideo" action="{{url('save-video')}}" enctype="multipart/form-data">
						@csrf
					  
						<div class="form-group">
						<div class="row">
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Course</label>
						<select class="form-control mb-3" id="course_id" name="course_id" placeholder="Select Course" required>
						<option value="">Select</option>
						@foreach($crs as $r)
						<option value="{{$r->id}}">{{$r->course_name}}</option>
						@endforeach
						
						</select>
						</div>
						
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Subjects</label>
						<select class="form-control mb-3" id="subject_id" name="subject_id" placeholder="Select Subjects" required>
						<option value="">Select</option>
						</select>
						</div>
												
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Topics</label>
						<select class="form-control mb-3" id="chapter_id" name="chapter_id" placeholder="Select Topic" required>
						<option value="">Select</option>
						</select>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Video Title</label>
						<input class="form-control mb-3" type="text" name="title"  placeholder="Title" required>
						</div>
																		
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Video File</label>
						<input class="form-control mb-3" type="file" onchange="fileValidation2()" id="video_file" name="video_file" placeholder="Video file" required>
						</div>

						</div>
						</div>

						<div class="form-group">
						<div class="row">
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<label>Duration</label>
						<input class="form-control" type="text"  id="duration" name="duration" placeholder="2:30" required>
						<label>Eg:2:30:00</label>
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Teacher Name</label>
						<input class="form-control mb-3" type="text"  name="teacher_name" placeholder="Teacher name" required>
						</div>
						
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Description</label>
						<textarea class="form-control mb-3" name="description" placeholder="Description" style="text-align:left;"></textarea>
						</div>
						
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label>Explanation</label>
						<textarea id="details" class="form-control mb-3" name="explanation"  placeholder="Explanation" style="text-align:left;"></textarea>
						</div>
						
						</div>
						</div>

						<div class="form-group mt-2">
						<div class="row">
						
						<div class="col-lg-8 col-xl-8 col-xxl-8 text-right">
							<div class="form-group row" style="padding-left:50px;padding-right:50px;">
								<div class="progress">
									<div class="bar"></div >
									<div class="percent">0%</div >
								</div>
								<label id="lbl1" style="color:red;font-size:12px;width:100%;text-align:center;">&nbsp;</label>
							</div>
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
							<button type="submit" id="btnSubmit" class="btn btn-primary">Save changes</button>
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

		<div class="modal fade" id="BasicModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
						

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save changes</button>
						</div>
						</form>
						
					</div>
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


$(function() 
 {
	
	var bar = $('.bar');
	var percent = $('.percent');
	  $('form').ajaxForm({
		beforeSend: function() {
			var percentVal = '0%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		uploadProgress: function(event, position, total, percentComplete) {
			var percentVal = percentComplete + '%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		complete: function(xhr) {
			//alert('File Has Been Uploaded Successfully');
			toastr.success("Video successfully added.");
			setTimeout(function(){window.location.reload();},500);
		}
	  });
 });


 $('#details').summernote({
		  dialogsInBody: true,
          height: '300',
		   placeholder: 'Enter Details',
			tabsize: 2,
		  
          toolbar: [
			  ['fontname', ['fontname']],
              ['fontsize', ['fontsize']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['height', ['height']]
			  
			  ['style', ['style']],
			  ['font', ['bold', 'italic', 'underline','strikethrough', 'superscript', 'subscript', 'clear']],
			  
			  ['para', ['ul', 'ol', 'paragraph']],
			  ['table', ['table']],
			  ['insert', ['link', 'picture', 'hr']],
			  ['view', ['fullscreen', 'codeview']],
			  ['help', ['help']]
          ],
          disableDragAndDrop: true
      });


$("#course_id").change(function()
{
	var id=$(this).val();
	
	jQuery.ajax({
			type: "GET",
			url: "get-subjects-for-videos"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#subject_id").html(res);
			}
		});

});



$("#subject_id").change(function()
{
	var id=$(this).val();
	
	jQuery.ajax({
			type: "GET",
			url: "get-chapters-for-videos"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#chapter_id").html(res);
			}
		});

});


function fileValidation2()
{
	var fileInput = document.getElementById('video_file'); 
	var allowedExtensions="";
		
	allowedExtensions = /(\.webm|\.mp4|\.aac|\.mpeg)$/i; 
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
