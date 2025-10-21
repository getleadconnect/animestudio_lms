@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')

<style>
.progress { position:relative; width:100%; }
.bar { background-color: #00ff00; width:0%; height:20px; }
.percent { position:absolute; display:inline-block; left:50%; color: #040608;}

.note-btn-group .dropdown-toggle::after{ content:none; }
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Add New Course</div>
 
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
                  <h6 class="mb-0 pt5">Course Details</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
                  <a href="{{url('courses')}}" class="btn btn-primary btn-xs btn-sm"><i class="fa fa-file"></i>&nbsp;View Courses</a>
				  </div>
				  
				  </div>
                </div>
                <div class="card-body">
                   <div class="row">
                     
                     <div class="col-12 col-lg-12 d-flex">
                      <div class="card  shadow-none w-100">
					  					  
					  <form method="POST" action="{{url('save-course')}}" enctype="multipart/form-data">
					  @csrf
					  
						<div class="modal-body">
						<div class="form-group">
						<div class="row">
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Course</label>
						<input class="form-control mb-3" type="text" placeholder="Course Name" name="course_name" required>
						</div>
						
						<div class="col-lg-3 col-xl-3 col-xxl-3">
						<label>Course Category</label>
						<select class="form-control mb-3" placeholder="Select Type" name="course_category" required>
						<option value="">Select Type</option>
						@foreach($cat as $r)
						<option value="{{$r->id}}">{{$r->category}}</option>
						@endforeach
						</select>
						</div>
												
						<div class="col-lg-3 col-xl-3 col-xxl-3">
						<label>Course Type</label>
						<select class="form-control mb-3" placeholder="Select Type" name="course_type"  required>
						<option value="">Select Type</option>
						@foreach($ctype as $r)
						<option value="{{$r->id}}">{{$r->course_type}}</option>
						@endforeach
						</select>
						</div>
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<label>Premium/Free</label>
						<select class="form-control mb-3" placeholder="premium/free" name="premium"  required>
						<option value="">Select</option>
						<option value="0">Free</option>
						<option value="1">Premium</option>
						</select>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Course wider icon (372 x 160)</label>
						<input type="file" class="form-control mb-3"  placeholder="select file" id="course_icon_wide"  name="course_icon_wide" required>
						</div>
						
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<img id="icon_output_wide" src="" style="width:70px;">
						</div>
												
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Course wide icon (225 x 176)</label>
						<input type="file" class="form-control mb-3"  placeholder="select file" id="course_icon_square"  name="course_icon_square" required>
						</div>
						
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<img id="icon_output_square" src="" style="width:70px;">
						</div>
						</div>
						</div>

						
						<div class="form-group">
						<div class="row">
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Course details Video</label>
						<input type="file" class="form-control mb-3" onchange="fileValidation3()" placeholder="select file" id="video_file"  name="video_file" >
						</div>
						
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<label>Start-Date</label>
						<input class="form-control mb-3" type="date" placeholder="Start date"  name="start_date" required>
						</div>
						
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<label>End-Date</label>
						<input class="form-control mb-3" type="date" placeholder="End date"  name="end_date"  min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
						</div>
																		
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<label>Rate</label>
						<input class="form-control mb-3" type="text" placeholder="Rate"  name="rate" required>
						</div>
						
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<label>Discount Rate</label>
						<input class="form-control mb-3" type="text" placeholder="discount Rate"  name="discount_rate" required>
						</div>
						</div>
						</div>

						<div class="form-group">
						<label style="color:blue;" class="mb-2"><u>For IOS App</u></label>
						<div class="row">

						<div class="col-lg-3 col-xl-3 col-xxl-3">
						<label>IOS-Rate</label>
						<input class="form-control mb-3" type="text" placeholder="IOS rate"  name="ios_rate">
						</div>
						
						<div class="col-lg-5 col-xl-5 col-xxl-5">
						<label>App Product Id</label>
						<input class="form-control mb-3" type="text" placeholder="App store product id" name="app_store_id">
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Subscription Type</label>
						<select class="form-control mb-3"  name="subscription_type" >
						<option value="">Select Type</option>
						<option value="Subscription">Subscription</option>	
						<option value="Consumable">Consumable</option>
						</select>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label>Description</label>
						<textarea class="form-control mb-3" placeholder="Description" name="description" style="text-align:left;"></textarea>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label>Course Details</label>
						<textarea id="details" class="form-control mb-3" placeholder="Course Details"  name="course_details" style="text-align:left;"></textarea>
						</div>
						
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
							<button type="submit" class="btn btn-primary">Save changes</button>
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


		<div class="modal fade" id="BasicModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
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

/*$(function() 
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
			toastr.success("Course successfully added.");
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


course_icon_wide.onchange = evt => {
  const [file] = course_icon_wide.files

        var allowedExtensions="";
	    allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	    var filePath = file.name;
		console.log(file);
	
		if (!allowedExtensions.exec(filePath)) { 
			alert('Invalid file type, Try again.'); 
			$("#course_icon_wide").val('');
			$("#icon_output_wide").prop('src','');
		}
		else
		{
			if (file) {
				icon_output_wide.src = URL.createObjectURL(file)
			  }
		}  
}


/*course_icon_square.onchange = evt => {
  const [file] = course_icon_square.files
  if (file) {
    icon_output_square.src = URL.createObjectURL(file)
  }
}*/


course_icon_square.onchange = evt => {
  const [file] = course_icon_square.files

 var allowedExtensions="";
	    allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	    var filePath = file.name;

		if (!allowedExtensions.exec(filePath)) { 
			alert('Invalid file type, Try again.'); 
			$("#course_icon_square").val('');
			$("#icon_output_square").prop('src','');
		}
		else
		{
			if (file) {
				icon_output_square.src = URL.createObjectURL(file)
			  }
		}  
}


function fileValidation1()
{
	var fileInput = document.getElementById('course_icon_wide'); 
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

function fileValidation2()
{
	var fileInput = document.getElementById('course_icon_square'); 
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

function fileValidation3()
{
	var fileInput = document.getElementById('video_file'); 
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
@endpush
@endsection
