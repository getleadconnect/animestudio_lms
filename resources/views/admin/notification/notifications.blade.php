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
              <div class="breadcrumb-title pe-3">Notifications</div>
 
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
				<div class="col-lg-6 col-xl-6 col-xxl-6 col-6">
                  <h6 class="mb-0 pt5">Notifications </h6>
				  </div>
				  <div class="col-lg-6 col-xl-6 col-xxl-6 col-6 text-right">
				  
				   <button class="btn btn-info btn-xs btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="padding-left:3px;" aria-expanded="true" aria-controls="flush-collapseOne">
                       <i class="lni lni-funnel"></i>
                  </button>&nbsp;
				  <button type="button" class="btn btn-primary btn-xs btn-sm" data-bs-toggle="modal" data-bs-target="#BasicModal1"><i class="fa fa-plus"></i>&nbsp;Add Message</button>
				  </div>

				  </div>
                </div>
                <div class="card-body">
					<div class="accordion-item accordion-item-bm" >
                        <div id="flush-collapseOne" class="accordion-collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" >
                          <div class="accordion-body">
						   <div class="row" style="padding:3px 10px 0px 10px;" >

							<div class="col-3 col-lg-3">
								<label>Select Course</label>
								<select class="form-control mb-3" id="flt_course" placeholder="course" required>
								<option value="">select</option>
								@foreach($crs as $r)
								<option value="{{$r->id}}">{{$r->course_name}}</option>
								@endforeach
								
								</select>
							</div>
							
							
							<div class="col-3 col-lg-3">
								<label>Select Type</label>
								<select class="form-control mb-3" id="flt_notification_type" placeholder="type" required>
								<option value="">select</option>
								@foreach($ntype as $r)
									<option value="{{$r->id}}">{{$r->type_name}}</option>
								@endforeach
								</select>
							</div>

						   </div>
						</div>
					  </div>
					</div>
					
					 <div class="row mt-2">
                     <div class="col-12 col-lg-12 ">
					 
	
					 </div>
					 </div>
						
				
                   <div class="row mt-2">
                     <div class="col-12 col-lg-12 ">
                      <div class="card  shadow-none w-100">
                        <!--<div class="card-body">-->
                          <!--<div class="table-responsive">-->
	
                             <table id="datatable" class="table align-middle" style="width:120% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th width="120px">Action</th>
									<th>Id</th>
									<th>Center</th>
									<th>Course</th>
									<th>Title</th>
									<th>Message</th>
									<th>Type</th>
									<th>Status</th>
									<th>Send_Status</th>
									<th>Added_By</th>
									
								</tr>
                               </thead>
                               <tbody>
                         
								
                               </tbody>
                             </table>
                         <!-- </div>-->

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
							<h5 class="modal-title" id="exampleModalLabel">Add Message</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<div class="modal-body">
						
						
						<form id="addNotification">
						@csrf
						<div class="form-group">
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Select Type</label>
							<select class="form-control mb-3"  id="notification_type" name="notification_type" placeholder="Notification type" required>
							<option value="">select</option>
							@foreach($ntype as $r)
								<option value="{{$r->id}}">{{$r->type_name}}</option>
							@endforeach
							</select>
							</div>
							
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Select Course</label>
							<select class="form-control mb-3" id="course_id" name="course_id" placeholder="course" required>
							<option value="">select</option>
							@foreach($crs as $r)
								<option value="{{$r->id}}">{{$r->course_name}}</option>
							@endforeach
							</select>
							</div>
						</div>
						</div>
						
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label>Notification Title</label>
						<input type="text" class="form-control mb-3" name="notification_title" placeholder="Title" required>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label>Notification Message</label>
						<textarea class="form-control mb-3" name="message" placeholder="Message" required></textarea>
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

$("form#addNotification").submit(function(e)
{
   e.preventDefault(); 
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('save-notification')}}",
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
				$('#addNotification')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				//$('#addNotification')[0].reset();
				
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
			url:"view-notifications",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.searchCourse = $('#flt_course').val();
			   data.searchMtype = $('#flt_notification_type').val();
		    },
        },
		
		columnDefs:[
				  {"width":"40px","targets":0},
				],
        columns: [
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
            {"data": "id" },
			{"data": "center" },
			{"data": "cname" },
			{"data": "title" },
			{"data": "mess" },
			{"data": "ntype" },
			{"data": "status" },
			{"data": "pstatus" },
			{"data": "addedby" },
        ],

});


$("#flt_course").change(function()
{
	$('#datatable').DataTable().ajax.reload(null, false);
});

$("#flt_notification_type").change(function()
{
	$('#datatable').DataTable().ajax.reload(null, false);
});

$("#notification_type").change(function()
{
	if($(this).val()==1)
	{
		$("#course_id").prop('required',false)
		$("#course_id").prop('disabled',true)
	}
	else
	{
		$("#course_id").prop('required',true)
		$("#course_id").prop('disabled',false)
	}
});


$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');
	
	var Result=$("#BasicModal2 .modal-body");
		
		//$(this).attr('data-bs-target','#BasicModal2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit-notification"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
  });
 
$("#datatable tbody").on('click','.btnSend',function()
{
	Swal.fire({
	  title: "Are you sure?",
	  text: "You want to send this notifiction?",
	  icon: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#3085d6",
	  cancelButtonColor: "#d33",
	  confirmButtonText: "Yes, send it!"
	}).then((result) => {
	  if (result.isConfirmed) {
		
		var id=$(this).attr('id');
		  jQuery.ajax({
			type: "get",
			url: "send-push-notification"+"/"+id,
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
			url: "delete-notification"+"/"+id,
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
			url: "act-deact-notification/1"+"/"+id,
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
			url: "act-deact-notification/2"+"/"+id,
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


	
</script>
@endpush
@endsection
