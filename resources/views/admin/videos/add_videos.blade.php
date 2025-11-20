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

.note-editable
{
	height:200px !important;
}
.required
{
	color:red;
}
.progress-box{
		z-index:99999999;width:100%;display:flex;position:absolute;justify-content:center;top:150px;
	}
	.progress-inner-box{
		width:500px;height:150px; margin:0 auto;background:#fff;
	}
.hide{display:none;}
.show{display:block;}

</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<meta name="csrf-token" content="{{ csrf_token() }}">

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
                   <div class="row" >
                     <div class="col-12 col-lg-12">
                      <div class="card  shadow-none w-100">

					    <form method="POST" id="addVideo" action="{{url('save-video')}}" enctype="multipart/form-data" >
							@csrf

					 	<div class="row" >
				<div class="col-12 col-lg-6 col-xl-6 col-xxl-6" >

						<input type="hidden" name="uploaded_file_path" id="uploaded_file_path">

						<div class="form-group">
							<label>Course <span class="required">*</span></label>
							<select class="form-control mb-3" id="course_id" name="course_id" placeholder="Select Course" required>
							<option value="">Select</option>
							@foreach($crs as $r)
							<option value="{{$r->id}}">{{$r->course_name}}</option>
							@endforeach
							</select>
						</div>
						
						
						<div class="form-group">
							<label>Subjects <span class="required">*</span></label>
							<select class="form-control mb-3" id="subject_id" name="subject_id" placeholder="Select Subjects" required>
							<option value="">Select</option>
							</select>
						</div>
												
						<div class="form-group">
							<label>Topics <span class="required">*</span></label>
							<select class="form-control mb-3" id="chapter_id" name="chapter_id" placeholder="Select Topic" required>
							<option value="">Select</option>
							</select>
						</div>
			
						
						<div class="form-group">
							<label>Video Title <span class="required">*</span></label>
							<input class="form-control mb-3" type="text" name="title" id="video_title"  placeholder="Title" required>
						</div>

						<div class="form-group mt-3" >
						<div class="row">
							<div class="col-12 col-lg-6 col-xl-6">
								<label>Duration <span class="required">*</span></label>
								<input class="form-control" type="text"  id="duration" name="duration" placeholder="2:30" required>
								<label>Eg:2:30:00</label>
							</div>
						
							<div class="col-12 col-lg-6 col-xl-6">
								<label>Teacher Name <span class="required">*</span></label>
								<input class="form-control mb-3" type="text"  id="teacher_name" name="teacher_name" placeholder="Teacher name" required>
							</div>
						</div>
						</div>

						
						<div class="form-group mt-3">
							<label>Description <span class="required">*</span></label>
							<textarea class="form-control mb-3" id="description"  name="description" placeholder="Description" style="text-align:left;height:100px;" required></textarea>
						</div>
						
				</div>

				<div class="col-12 col-lg-6 col-xl-6 col-xxl-6">

						<div class="form-group">
							<label>Explanation</label>
							<textarea id="details" class="form-control mb-3" name="explanation"  placeholder="Explanation" style="text-align:left;"></textarea>
						</div>

						<div class="form-group mt-3">
							<label>File Type <span class="required">*</span></label>
							<select class="form-control mb-3" id="file_type" name="file_type" placeholder="Select Type"  style="width:150px;" required>
							<option value="">Select</option>
							<option value="Video">Video</option>
							<option value="Image">Image</option>
							</select>
						</div>

						<div class="form-group mt-3">
							<label>Video File(.mp4 Only)/Images <span class="required">*</span></label>
							<!--<input class="form-control mb-3" type="file" onchange="fileValidation2()" id="video_file" name="video_file" placeholder="Video file" required> -->
							<div id="fileUploader" class="dropzone"></div>

						</div>
								

						<div class="form-group mt-3">
							<button type="button" id="btnSubmit" class="btn btn-primary">Save changes</button>
						</div>

						</div><!-- end column -->

						</div>
						</div>

						</form>
									
                       <!-- </div>-->
                      </div> 
                    </div>
                   </div><!--end row-->
                </div>
              </div>


			<!--- to provide progress bar ----------------------------------------------->
				<div class="progress-box hide" >
					<div class="progress-inner-box">

					<div class="card" style="border:1px solid #e0e5f6;">
						<div class="card-header p-y-3" style="background-color:#e0e5f6;">
							<label>File Uploading</label>
						</div>
						<div class="card-body">
						<div class="row">
							<div class="col-12">
								<div style="display:flex !important;justify-content:center;">
									<div id="progressText" style="position:absolute;margin:0 auto;">0%</div>
									<div id="progressWrapper" style="width:100%; height:20px; background:#eee;">
										<div id="progressBar" style="height:20px; width:0%; background:#28a745;"></div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<label id="mes_upload" style="color:green">&nbsp;</label>
							</div>
						</div>
					</div>
					</div>
					</div>
				</div>
			<!--------------------------------------------------------------------------->



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
Dropzone.autoDiscover = false;

let uploadedFilePath = null;

let dz = new Dropzone("#fileUploader", {
    url: "{{ route('chunk.upload') }}",
    paramName: "file",
    maxFilesize: 6000, // 5GB
    chunking: true,
    forceChunking: true,
    chunkSize: 2 * 1024 * 1024, // 2MB
    retryChunks: true,
    retryChunksLimit: 3,
    parallelChunkUploads: false,
    addRemoveLinks: true,
	autoProcessQueue: false, // Important: prevent auto upload
	acceptedFiles: "image/*,video/mp4",
	
	headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },

    init: function () {

		let myDropzone = this;

        // Upload button triggers processing
        document.getElementById("btnSubmit").addEventListener("click", function () {

			let cid=$("#course_id").val();
			let sid=$("#subject_id").val();
			let chid=$("#chapter_id").val();
			let vtitle=$("#video_title").val();
			let desc=$("#description").val();
			let dur=$("#duration").val();
			let tna=$("#teacher_name").val();
			let ftype=$("#file_type").val();
			
			if(cid!="" && sid!="" && chid!="" && vtitle!="" && dur!="" && tna!="" && desc!="" && ftype!="")
			{
				
				$(".progress-box").removeClass('hide');
				$(".progress-box").addClass('show');

				if (myDropzone.getQueuedFiles().length === 0) {
					alert("Please select a file for upload.");
					return;
				}
				document.getElementById("mes_upload").innerText="Please Wait, Uploading..!";
				myDropzone.processQueue(); // start upload
			}
			else
			{
				alert("Video details missing, Input data correctly.!");
			}
        });

		this.on("uploadprogress", function(file, progress, bytesSent) {
            let percent = Math.round(progress);
            console.log("File progress: " + percent + "%");

            document.getElementById("progressText").innerText = percent + "%";
            document.getElementById("progressBar").style.width = percent + "%";
        });


		this.on('canceled',function(file,response){
			myDropzone.removeAllFiles(true); // cancel and remove files
            uploadedFilePath = null;
            document.getElementById("uploaded_file_path").value = '';
            document.getElementById("progressBar").style.width = '0%';
            document.getElementById("progressText").innerText = '0%';
		});

        this.on("success", function (file, response) {

            // This is the final response
            if (response.path) {

                uploadedFilePath = response.path;
                document.getElementById("uploaded_file_path").value = response.path;

                console.log("Final file path:", response.path);

                document.getElementById("progressText").innerText = "Completed";
                document.getElementById("progressBar").style.width = "100%";
				uploadedFilePath = response.path;
            }

            console.log("File uploaded:", response);
			if (uploadedFilePath) {
				document.getElementById("mes_upload").innerText="File Uploaded";
				document.getElementById("addVideo").submit();
			}
        });
    }
});


/*document.getElementById("btnSubmit").addEventListener("click", function () {

    if (dz.getUploadingFiles().length > 0) {
        document.getElementById("mes_upload").innerText="Uploading...!";
    }

    if (!uploadedFilePath) {
        alert("Please upload a file first.");
    }
	
});*/

</script>


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

/*
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
*/


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
