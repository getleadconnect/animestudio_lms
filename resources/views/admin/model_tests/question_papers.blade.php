@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')
<style>
.card-body{
	padding-top:2px !important;
}


</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Model Question Papers</div>
 
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
                  <h6 class="mb-0 pt5">Question papers </h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
				  
				   <button class="btn btn-info btn-xs btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="padding-left:3px;" aria-expanded="true" aria-controls="flush-collapseOne">
                       <i class="lni lni-funnel"></i>
                  </button>&nbsp;
                  <button type="button" class="btn btn-primary btn-xs btn-sm" data-bs-toggle="modal" data-bs-target="#BasicModal1"><i class="fa fa-plus"></i>&nbsp;Add Q-papers</button>
				  </div>

				  </div>
                </div>
                <div class="card-body">
					<div class="accordion-item accordion-item-bm" >
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" >
                          <div class="accordion-body">
						   <div class="row" style="padding:3px 10px 0px 10px;" >

							<div class="col-3 col-lg-3">
								<label>Course</label>
								<select class="form-control mb-3" id="flt_course_id" placeholder="course" required>
								<option value="">select</option>
								@foreach($crs as $r)
									<option value="{{$r->id}}" >{{$r->course_name}}</option>
								@endforeach
								</select>
							</div>
							
							<div class="col-3 col-lg-3">
								<label>Tab Heading</label>
								<select class="form-control mb-3" id="flt_tab_heading" placeholder="Exam tab heading" required>
								<option value="">select</option>
								
								</select>
							</div>

						   </div>
						</div>
					  </div>
					</div>
							
				
                   <div class="row mt-2">
                     <div class="col-12 col-lg-12 ">
                      <div class="card  shadow-none w-100">
                        <!--<div class="card-body">-->
                          <div class="table-responsive">
	
                             <table id="datatable" class="table align-middle" style="width:120% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th class="no-content">Action</th>
									<th>Id</th>
									<th>Course</th>
									<th>Tab_Name</th>
									<th>Question_Papers</th>
									<th>Description</th>
									<th>Start Date</th>
									<th>Duration</th>
									<th>Explanation_Video</th>
									<th>Status</th>
									<th>Added_By</th>
								</tr>
                               </thead>
                               <tbody>
                                							
								
                               </tbody>
                             </table>
                          </div>

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
							<h5 class="modal-title" id="exampleModalLabel">Add Question Paper</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						
						<div class="modal-body">
						
						<form id="addQuestionPaper"  enctype="multipart/form-data">
						@csrf
						
						<div class="form-group">
						<label> Select Option</label>
						
						<div class="row mt-2 mb-3">
						<div class="col-lg-4 col-xl-4 col-xxl-4">
								<div class="form-check">
									<input class="form-check-input opt-radio" type="radio"   name="free_test" value="1" id="flexRadioDefault1">
									<label class="form-check-label" for="flexRadioDefault1">&nbsp;&nbsp;FREE EXAMS</label>
								</div>
						</div>
						<div class="col-lg-4 col-xl-4 col-xxl-4">
							<div class="form-check">
								<input class="form-check-input opt-radio" type="radio"  name="free_test" value="2" id="flexRadioDefault2">
								<label class="form-check-label" for="flexRadioDefault2">&nbsp;&nbsp;TEST EXAMS</label>
							</div>
						</div>
						</div>
						</div>
						
						<fieldset id="qp_fieldset" disabled>
						
						<div class="form-group">
						
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Select Course</label>
						<select class="form-control mb-3" id="course_id" name="course_id" placeholder="Course" required>
						<option value="">select</option>
						@foreach($crs as $r)
							<option value="{{$r->id}}" >{{$r->course_name}}</option>
						@endforeach
						</select>
						</div>
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Select Tab</label>
						<select class="form-control mb-3" name="tab_heading_id" id="tab_heading_id" placeholder="Tab Name" required>
						<option value="">select</option>
						
						</select>
						</div>
						</div>
						</div>
						
												
						<div class="form-group">
							<div class="row">
							<div class="col-lg-12 col-xl-12 col-xxl-12">
							<label>Question Paper Name</label>
							<input class="form-control mb-3" type="text" name="question_paper" placeholder="Name" required>
							</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
							<div class="col-lg-12 col-xl-12 col-xxl-12">
							<label>Description</label>
							<textarea class="form-control mb-3" name="description" placeholder="Description" required></textarea>
							</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
							<div class="col-lg-5 col-xl-5 col-xxl-5">
							<label>Start Date</label>
							<input class="form-control mb-3" type="date" name="start_date" placeholder="start date" required>
							</div>
							<div class="col-lg-4 col-xl-4 col-xxl-4">
							<label>Duration(Mins)</label>
							<input class="form-control mb-3" type="number" name="duration" placeholder="Duration" value="45" required>
							</div> 
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
							<div class="col-lg-12 col-xl-12 col-xxl-12">
							<label>Exaplanation Video</label>
							<input type="file" class="form-control mb-3" onchange="fileValidation()" id="exp_video" name="exp_video" placeholder="Explanation video" required>
							</div>
							</div>
						</div>
					
						</fieldset>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save changes</button>
						</div>
						</form>
						</div>
					</div>
				</div>
			</div>
			  

			<div class="modal fade" id="BasicModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
												
						<div class="modal-body">
						
						
						</div>
						
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

$("#flexRadioDefault1").change(function()
{
	$("#course_id").prop('disabled',true);
	$("#course_id").prop('required',false);
	
	$("#tab_heading_id").prop('disabled',true);
	$("#tab_heading_id").prop('required',false);
	$("#qp_fieldset").prop('disabled',false);
});


$("#flexRadioDefault2").change(function()
{
	$("#course_id").prop('disabled',false);
	$("#course_id").prop('required',true);
	
	$("#tab_heading_id").prop('disabled',false);
	$("#tab_heading_id").prop('required',true);
	$("#qp_fieldset").prop('disabled',false);
	
});



$("form#addQuestionPaper").submit(function(e)
{
   e.preventDefault(); 
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('save-question-paper')}}",
          type: 'post',
          data: formData,
		  dataType:'json',
          success: function (res) 
		  {
			 if(res.status==true)
			 {
				$('#BasicModal1').modal('hide');
				toastr.success(res.msg);
				$('#datatable').DataTable().ajax.reload(null, false);
				$('#addQuestionPaper')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				$('#addQuestionPaper')[0].reset();
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
});



$("#course_id").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get-tab-headings-by-course-id"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#tab_heading_id").html(res);
			}
		});
});


var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :50,
		scrollX: true,
		
		'pagingType':"simple_numbers",
        'lengthChange': true,
			
		ajax:
		{
			url:"view-question-papers",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.searchCourseId = $('#flt_course_id').val();
			   data.searchTabHead = $('#flt_tab_heading').val();
		    },
        },
		
		columnDefs:[
				  {"width":"40px","targets":1},
				],
	
        columns: [
            {"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "id" },
			{"data": "crs" },
			{"data": "tabh" },
			{"data": "qpaper" },
			{"data": "desc" },
			{"data": "sdat" },
			{"data": "dura" },
			{"data": "evideo" },
			{"data": "status" },
			{"data": "addedby" },
			
        ],

});

$("#flt_course_id").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get-tab-headings-by-course-id"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#flt_tab_heading").html(res);
			}
		});
		
		$('#datatable').DataTable().ajax.reload(null, false);
});


$("#flt_tab_heading").change(function()
{
	$('#datatable').DataTable().ajax.reload(null, false);
});


$("#course_id").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get-course-fee"+"/"+id,
			dataType: 'json',
			//data: {vid: vid},
			success: function(res)
			{
			   console.log(res);
			   $("#fee").val(res.data.rate);
			   $("#end_date").val(res.data.end_date);
			   }
		});

});


$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');
	
	var Result=$("#BasicModal2 .modal-body");
		
		//$(this).attr('data-bs-target','#BasicModal2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit-question-paper"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
	});
});
 


$("#datatable tbody").on('click','.btnDel',function()
{
	Swal.fire({
	  title: "Are you sure?",
	  text: "You want to delete this item?",
	  icon: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#3085d6",
	  cancelButtonColor: "#d33",
	  confirmButtonText: "Yes, delete it!"
	}).then((result) => {
	  if (result.isConfirmed) {
		
		var id=$(this).attr('id');
		  jQuery.ajax({
			type: "get",
			url: "delete-question-paper"+"/"+id,
			dataType: 'json',
			//data: {vid: vid},
			success: function(res)
			{
			   if(res.status==true)
			   {
				   toastr.success(res.msg);
				   $('#datatable').DataTable().ajax.reload(null, false);
			   }
			   else
			   {
				 toastr.error(res.msg); 
			   }
			}
			
		  });

	  }
	});

});


$("#datatable tbody").on('click','.btnAct',function()
{
	Swal.fire({
	  title: "Activate?",
	  text: "You want to activate this item?",
	  icon: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#3085d6",
	  cancelButtonColor: "#d33",
	  confirmButtonText: "Yes, activate it!"
	}).then((result) => {
	  if (result.isConfirmed) {
		var id=$(this).attr('id');
		  jQuery.ajax({
			type: "get",
			url: "act-deact-question-paper/1"+"/"+id,
			dataType: 'json',
			//data: {vid: vid},
			success: function(res)
			{
			   if(res.status==true)
			   {
				   toastr.success(res.msg);
				   $('#datatable').DataTable().ajax.reload(null, false);
			   }
			   else
			   {
				 toastr.error(res.msg); 
			   }
			}
		  });
	  }
	});

});


$("#datatable tbody").on('click','.btnDeact',function()
{
	Swal.fire({
	  title: "Deactivate?",
	  text: "You want to deactivate this item?",
	  icon: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#3085d6",
	  cancelButtonColor: "#d33",
	  confirmButtonText: "Yes, deactivate it!"
	}).then((result) => {
	  if (result.isConfirmed) {
		var id=$(this).attr('id');
		  jQuery.ajax({
			type: "get",
			url: "act-deact-question-paper/2"+"/"+id,
			dataType: 'json',
			//data: {vid: vid},
			success: function(res)
			{
			   if(res.status==true)
			   {
				   toastr.success(res.msg);
				   $('#datatable').DataTable().ajax.reload(null, false);
			   }
			   else
			   {
				 toastr.error(res.msg); 
			   }
			}
		  });
	  }
	});

});


function fileValidation()
{
	var fileInput = document.getElementById('exp_video'); 
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
