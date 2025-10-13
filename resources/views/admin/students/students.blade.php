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
              <div class="breadcrumb-title pe-3">Students</div>
 
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
                  <h6 class="mb-0 pt5">Students List</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
				  
				   <button class="btn btn-info btn-xs btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="padding-left:3px;" aria-expanded="true" aria-controls="flush-collapseOne">
                       <i class="lni lni-funnel"></i>
                  </button>&nbsp;
                  <button type="button" class="btn btn-primary btn-xs btn-sm" data-bs-toggle="modal" data-bs-target="#BasicModal1"><i class="fa fa-plus"></i>&nbsp;Add Student</button>
				  </div>
				  				  
				  
				  </div>
                </div>
                <div class="card-body">
					<div class="accordion-item accordion-item-bm" >
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" >
                          <div class="accordion-body">
						   <div class="row" style="padding:3px 10px 0px 10px;" >
							<div class="col-3 col-lg-3">
								<label>Center</label>
								<select class="form-control mb-3" id="flt_center" placeholder="center" required>
								<option value="">select</option>
								@foreach($center as $r)
								<option value="{{$r->id}}">{{$r->center_name}}</option>
								@endforeach
								</select>
							</div>
							
							<div class="col-3 col-lg-3">
								<label>District</label>
								<select class="form-control mb-3" id="flt_district" placeholder="district" required>
								<option value="">select</option>
								@foreach($dist as $r)
								<option value="{{$r->id}}">{{$r->district}}</option>
								@endforeach
								</select>
							</div>
						   </div>
						</div>
					  </div>
					</div>
				
                   <div class="row mt-2">
                     <div class="col-12 col-lg-12 d-flex">
                      <div class="card  shadow-none w-100">
                        <!--<div class="card-body">-->
                          <div class="table-responsive">
	
                             <table id="datatable" class="table align-middle" style="width:130% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th class="no-content">Action</th>
									<th>Id</th>
									<th>Center</th>
									<th>Name</th>
									<th>Birth_Date</th>
									<th>Mobile</th>
									<th>Email</th>
									<th>District</th>
									<th>Place</th>
									<th>Referred_By</th>
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
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<div class="modal-body">
						
						<form id="addStudent" enctype="multipart/form-data">
						@csrf
						
						<div class="form-group">
							<div class="row">
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Name</label>
							<input class="form-control mb-3" type="text" name="student_name" placeholder="Name" required>
							</div>
							
							<div class="col-lg-3 col-xl-3 col-xxl-3">
							<label>Date Of birth</label>
							<input class="form-control mb-3" type="date" name="dob" placeholder="Date of birth"  required>
							</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>District</label>
							<select class="form-control mb-3" id="district" name="district" placeholder="district" required>
								<option value="">select</option>
								@foreach($dist as $r)
								 <option value="{{$r->id}}">{{$r->district}}</option>
								@endforeach
							</select>
							</div>
							
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Place</label>
							<input class="form-control mb-3" type="text" name="place" placeholder="Place"  required>
							</div>
							</div>
						</div>						

						<div class="form-group">
							<div class="row">
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Email</label>
							<input class="form-control mb-3" type="email" name="email" placeholder="email" required>
							</div>
							
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Mobile</label>
							<input class="form-control mb-3" type="number" name="mobile" placeholder="mobile"  required>
							</div>
							</div>
						</div>

						<div class="form-group">
						<label class="mb-2" style="color:blue"><u>Prefered Course</u></label>
						<div class="row">
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Select Course</label>
							<select class="form-control mb-3" id="course_id" name="course_id" placeholder="course" required>
							<option value="">select</option>
							@foreach($crs as $r)
							<option value="{{$r->id}}">{{$r->course_name}}</option>
							@endforeach
							</select>
							</div>
							<div class="col-lg-3 col-xl-3 col-xxl-3">
								<label>Start Date</label>
							<input type="date" class="form-control mb-3" id="start_date" name="start_date"  value="{{date('Y-m-d')}}"placeholder="start date" readonly>
							</div>
							<div class="col-lg-3 col-xl-3 col-xxl-3">
								<label>End Date</label>
							<input type="date" class="form-control mb-3" id="end_date" name="end_date" placeholder="end date">
							</div>
						</div>
						</div>
						
						<div class="form-group">
							<div class="row">
							<div class="col-lg-4 col-xl-4 col-xxl-4">
							<label>Fees</label>
							<input class="form-control mb-3" type="number" step="any" id="fee" name="fee" placeholder="net amount" required>
							</div>
							
							<div class="col-lg-4 col-xl-4 col-xxl-4">
							<label>Discount</label>
							<input class="form-control mb-3" type="number" step="any" id="discount" name="discount" placeholder="discount" required>
							</div>
							
							<div class="col-lg-4 col-xl-4 col-xxl-4">
							<label>Net-Amount</label>
							<input class="form-control mb-3" type="number" step="any" id="net_amount" name="net_amount" placeholder="net amount" required>
							</div>
							</div>
						</div>
						
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
							<h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
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

$("form#addStudent").submit(function(e)
{
   e.preventDefault(); 
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('save-student')}}",
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
				$('#addStudent')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				//$('#addStudent')[0].reset();
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
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
			url:"view-students",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.searchCenter = $('#flt_center').val();
			   data.searchDist = $('#flt_district').val();
		    },
        },
		
		columnDefs:[
				  {"width":"40px","targets":1},
				],
	
        columns: [
            {"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "id" },
			{"data": "center" },
			{"data": "sname" },
			{"data": "dob" },
			{"data": "mobile" },
			{"data": "email" },
			{"data": "dist" },
			{"data": "place" },
			{"data": "refby" },
			{"data": "status" },
			{"data": "addedby" },
			
        ],

});

$("#flt_center").change(function()
{
	$('#datatable').DataTable().ajax.reload(null, false);
});

$("#flt_district").change(function()
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


$("#net_amount").focus(function()
{
	var fee=parseFloat($("#fee").val());
	var disc=parseFloat($("#discount").val());
	var net=parseFloat(fee-disc).toFixed(2);
	$(this).val(net);
	
});

$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');
	
	var Result=$("#BasicModal2 .modal-body");
		
		//$(this).attr('data-bs-target','#BasicModal2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit-student"+"/"+id,
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
			url: "delete-student"+"/"+id,
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
			url: "act-deact-student/1"+"/"+id,
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
			url: "act-deact-student/2"+"/"+id,
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
	var fileInput = document.getElementById('class_icon'); 
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
@endpush
@endsection
