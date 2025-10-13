<form id="editQuestionPaper"  enctype="multipart/form-data">
	@csrf
	
	<input type="hidden" name="qpaper_id" value="{{$qp->id}}">
	
	<div class="form-group">
		<label> Select Option</label>
		
		<div class="row mt-2 mb-3">
		<div class="col-lg-4 col-xl-4 col-xxl-4">
				<div class="form-check">
					<input class="form-check-input free_test_edit opt-radio" type="radio" name="free_test_edit" value="1" @if($qp->free_test==1){{__('checked')}}@endif>
					<label class="form-check-label" for="free_test_edit1">&nbsp;&nbsp;FREE EXAMS</label>
				</div>
		</div>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
			<div class="form-check">
				<input class="form-check-input free_test_edit opt-radio" type="radio"  name="free_test_edit" value="2" @if($qp->free_test==2){{__('checked')}}@endif>
				<label class="form-check-label" for="free_test_edit2">&nbsp;&nbsp;TEST EXAMS</label>
			</div>
		</div>
		</div>
		</div>
		
	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label>Select Course</label>
		<select class="form-control mb-3" id="course_id_edit" name="course_id_edit" placeholder="Course" required>
		<option value="">select</option>
		@foreach($crs as $r)
			<option value="{{$r->id}}" @if($r->id==$qp->course_id){{__('selected')}}@endif>{{$r->course_name}}</option>
		@endforeach
		</select>
	</div>
	<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label>Select Tab</label>
		<select class="form-control mb-3" name="tab_heading_id_edit" id="tab_heading_id_edit" placeholder="Tab Name" required>
		<option value="">select</option>
		@foreach($tabhead as $r)
			<option value="{{$r->id}}" @if($r->id==$qp->exam_tab_heading_id){{__('selected')}}@endif>{{$r->tab_heading}}</option>
		@endforeach
		</select>
	</div>
	</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Question Paper Name</label>
		<input class="form-control mb-3" type="text" name="question_paper_edit" placeholder="Name" value="{{$qp->question_paper_name}}" required>
		</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Description</label>
		<textarea class="form-control mb-3" name="description_edit" placeholder="Description" required>{{$qp->description}}</textarea>
		</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
		<div class="col-lg-5 col-xl-5 col-xxl-5">
		<label>Start Date</label>
		<input class="form-control mb-3" type="date" name="start_date_edit" placeholder="start date" value="{{date_create($qp->start_date)->format('Y-m-d')}}" required>
		</div>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		<label>Duration(Mins)</label>
		<input class="form-control mb-3" type="number" name="duration_edit" placeholder="Duration" value="{{$qp->duration}}" required>
		</div> 
		</div>
	</div>
	
	<div class="form-group">
		<div class="row mb-3">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Exaplanation Video</label>
		<input type="file" class="form-control" onchange="fileValidation1()" id="exp_video_edit" name="exp_video_edit" placeholder="Explanation video">
		<label>File:<span style="color:blue;">{{$qp->explanation_video}}</span>
		</div>
		</div>
	</div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
	</form>
	
<script>

function check_option()
{
	var vl=parseInt($('input[name="free_test_edit"]:checked').val());
	if(vl==1)
	{
		$("#course_id_edit").prop('disabled',true);
		$("#course_id_edit").prop('required',false);
		
		$("#tab_heading_id_edit").prop('disabled',true);
		$("#tab_heading_id_edit").prop('required',false);
	}
	else
	{
		$("#course_id_edit").prop('disabled',false);
		$("#course_id_edit").prop('required',true);
		
		$("#tab_heading_id_edit").prop('disabled',false);
		$("#tab_heading_id_edit").prop('required',true);
	}
}


$(".free_test_edit").change(function()
{
	var vl=parseInt($('input[name="free_test_edit"]:checked').val());
	if(vl==1)
	{
		$("#course_id_edit").val('');
		$("#tab_heading_id_edit").html('<option value="">--select--</option>');
		$("#course_id_edit").prop('disabled',true);
		$("#course_id_edit").prop('required',false);
		
		$("#tab_heading_id_edit").prop('disabled',true);
		$("#tab_heading_id_edit").prop('required',false);
	}
	else
	{
		$("#course_id_edit").prop('disabled',false);
		$("#course_id_edit").prop('required',true);
		$("#tab_heading_id_edit").prop('disabled',false);
		$("#tab_heading_id_edit").prop('required',true);
	}
});


$(document).ready(function()
{
	check_option();
});


$("#course_id_edit").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get-tab-headings-by-course-id"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#tab_heading_id_edit").html(res);
			}
		});
});


$("form#editQuestionPaper").submit(function(e)
{
   e.preventDefault(); 
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('update-question-paper')}}",
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
				$('#editQuestionPaper')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				$('#editQuestionPaper')[0].reset();
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
});


function fileValidation1()
{
	var fileInput = document.getElementById('exp_video_edit'); 
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
	
	