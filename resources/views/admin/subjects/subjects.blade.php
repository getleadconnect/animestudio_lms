@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Subjects</div>
 
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
                  <h6 class="mb-0 pt5">Subject List</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
                     <button class="btn btn-info btn-xs btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="padding-left:3px;" aria-expanded="true" aria-controls="flush-collapseOne">
                       <i class="lni lni-funnel"></i>
                  </button>&nbsp;
				  <button type="button" class="btn btn-primary btn-xs btn-sm" data-bs-toggle="modal" data-bs-target="#BasicModal1"><i class="fa fa-plus"></i>&nbsp;Add Subject</button>
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
								<select class="form-control mb-3" id="flt_course" placeholder="Course name" >
								<option value="">select</option>
								@foreach($crs as $r)
								<option value="{{$r->id}}">{{$r->course_name}}</option>
								@endforeach
								</select>
							</div>
							
							
						   </div>
						</div>
					  </div>
					</div>
				
                   <div class="row mt-3">
                     
                     <div class="col-12 col-lg-12 d-flex">
                      <div class="card  shadow-none w-100">
                        <!--<div class="card-body">-->
                          <div class="table-responsive">
	
                             <table id="datatable" class="table align-middle" style="width:130% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th class="no-content" width="80px">Action</th>
									<th>Id</th>
									<th>Course_Name</th>
									<td>Icon</td>
									<th>Subject Name</th>
									<td>Description</td>
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
							<h5 class="modal-title" id="exampleModalLabel">Add Subjects</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<div class="modal-body">

						<form method="POST" action="{{url('save-subject')}}" enctype="multipart/form-data">
						@csrf
						
						<div class="form-group">
						<label>Course</label>
						<select class="form-control mb-3" name="course_id" required>
						<option value="">Select</option>
						@foreach($crs as $r)
						<option value="{{$r->id}}">{{$r->course_name}}</option>	
						@endforeach
						</select>
						</div>
											
						<div class="form-group">
						<label>Subject Name</label>
						<input class="form-control mb-3" type="text" name="subject_name" placeholder="Subject name" required>
						</div>
						
						<div class="form-group">
						<label>Description</label>
						<textarea class="form-control mb-3" name="description" placeholder="description" required></textarea>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-8 col-xl-8 col-xxl-8">
						<label>Icon</label>
						<input type="file" class="form-control mb-3" id="subject_icon" name="subject_icon"  placeholder="icon" required>
						</div>
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<img id="icon_output" src="" style="width:70px;">
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

subject_icon.onchange = evt => {
  const [file] = subject_icon.files

var allowedExtensions="";
	allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	var filePath = file.name;

	if (!allowedExtensions.exec(filePath)) { 
		alert('Invalid file type, Try again.'); 
		$("#subject_icon").val('');
		$("#icon_output").prop('src','');
	}
	else
	{
		if (file) {
			icon_output.src = URL.createObjectURL(file)
		  }
	}  
}


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
			url:"view-subjects",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.searchCourse = $('#flt_course').val();
		    },
        },
		
		columnDefs:[
				  {"width":"40px","targets":1},
				],
	
        columns: [
            {"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "id" },
			{"data": "cname" },
			{"data": "sicon" },
			{"data": "sname" },
			{"data": "desc" },
			{"data": "status" },
			{"data": "addedby" },
			
        ],

});

$("#flt_course").change(function()
{
	$('#datatable').DataTable().ajax.reload(null, false);
});


$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');
	
	var Result=$("#BasicModal2 .modal-body");
		
		$(this).attr('data-bs-target','#BasicModal2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit-subject"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
  });
 


$('#datatable tbody').on('click','.btnDel',function()
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
			url: "delete-subject"+"/"+id,
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


$('#datatable tbody').on('click','.btnAct',function()
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
			url: "act-deact-subject/1"+"/"+id,
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


$('#datatable tbody').on('click','.btnDeact',function()
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
			url: "act-deact-subject/2"+"/"+id,
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
	var fileInput = document.getElementById('subejct_icon'); 
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
