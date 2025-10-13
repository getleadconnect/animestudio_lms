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
              <div class="breadcrumb-title pe-3">Exam Tab Headings</div>
 
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
                  <h6 class="mb-0 pt5">Tab Headings</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
				   <!--<button class="btn btn-info btn-xs btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="padding-left:3px;" aria-expanded="true" aria-controls="flush-collapseOne">
                      <i class="lni lni-funnel"></i>
                   </button>&nbsp;
                   <button type="button" class="btn btn-primary btn-xs btn-sm" data-bs-toggle="modal" data-bs-target="#BasicModal1"><i class="fa fa-plus"></i>&nbsp;Add Question</button>
				   -->
				  </div>

				  </div>
                </div>
                <div class="card-body">
				
					<!--<div class="accordion-item accordion-item-bm" >
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" >
                          <div class="accordion-body">
						   <div class="row" style="padding:3px 10px 0px 10px;" >
							
							<div class="col-3 col-lg-3">
								<label>Course</label>
								<select class="form-control mb-3" placeholder="Gender" required>
								<option value="">select</option>
								<option value="LDC" >LDC</option>
								<option value="HSASST">HSASST</option>
								</select>
							</div>
							
							<div class="col-3 col-lg-3">
								<label>Subject</label>
								<select class="form-control mb-3" placeholder="Gender" required>
								<option value="">select</option>
								<option value="1" >ENGLISH</option>
								<option value="2">BIOLOGY</option>
								<option value="3">PHYSICS</option>
								</select>
							</div>
							
						   </div>
						</div>
					  </div>
				   </div> -->
				   
				
                <div class="row mt-2">
				   <div class="col-12 col-lg-12 col-xl-12 col-xxl-12">
				   
                    <div class="card  shadow-none w-100">
					
					<div class="row mt-2" >
					<div class="col-5 col-lg-5 col-xl-5 col-xxl-5">

					<label class=" mb-3" style="color:blue;"><u>Add Headings</u></label>

						<form  method="post" action="{{url('save-tab-heading')}}" enctype="multipart/form-data">
						@csrf
							<div class="form-group">
								<label>Course</label>
								<select class="form-control mb-3" name="course_id" placeholder="course" required>
								<option value="">select</option>
								@foreach($crs as $r)
								<option value="{{$r->id}}" >{{$r->course_name}}</option>
								@endforeach
								</select>
							</div>
						
							<div class="form-group">
							<div class="row">
							<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">No Of tabs</label>
							  <div class="col-lg-4 col-xl-4 col-xxl-4">
								<input type="number" id="tab_count" name="tab_count" class="form-control mb-3" required>
							  </div>
							   <div class="col-lg-4 col-xl-4 col-xxl-4">
								<button type="button" id="btnTabs" class="btn btn-primary"  style="padding-left:5px; padding-right:10px;"><i class="fa fa-plus"></i></button>
							  </div>
							</div>
							</div>
							
							<div id="tab_headings">
							
							
							</div>
							<button type="submit" id="btn_submit" class="btn btn-primary" disabled>Add Tabs</button>
						</form>

				    </div>
				   
                     <div class="col-7 col-lg-7 col-xl-7 col-xxl-7">
	
                        <!--<div class="card-body">-->
                             <table id="datatable" class="table align-middle" style="width:100% !important;" >
                               <thead class="table-light">
                                 <tr>
									
									<th>Id</th>
									<th>Course</th>
									<th>Tab-Heading</th>
									<th>Status</th>
									<th class="no-content">Action</th>
								</tr>
                               </thead>
                               <tbody>

                               </tbody>
                             </table>
                       <!-- </div>-->
                      </div> 
                    </div>
					
                   </div><!--end row-->
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

$(document).on('click','#btnTabs',function()
{
	var scnt=$("#tab_count").val();
	if(scnt>0)
	{
		sub="";
		for(x=1;x<=scnt;x++)
		{
			
			sub+='<div class="form-group">\
				<div class="row">\
				<div class="col-lg-12 col-xl-12 col-xxl-12">\
					<label>tab_heading-'+x+'</label>\
					<input type="text" name="tab_heading[]" class="form-control mb-3" placeholder="Tab heading-'+x+'" required>\
				</div>\
				</div>\
				</div>';	
		}
		
		$("#btn_submit").prop('disabled',false);
		$("#tab_headings").html(sub);
		
	}
	else
	{
		Swal.fire("Warning!","Tab count missing!");
	}
	
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
			url:"view-tab-headings",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
        },
		
		columnDefs:[
				  {"width":"40px","targets":0},
				],
	
        columns: [
            {"data": "id" },
			{"data": "cname" },
			{"data": "tabh" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
			
 });


$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');
	
	var Result=$("#BasicModal2 .modal-body");
		
		//$(this).attr('data-bs-target','#BasicModal2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit-tab-heading"+"/"+id,
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
	  text: "You want to delete this item!",
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
			url: "delete-tab-heading"+"/"+id,
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
			url: "act-deact-tab-heading/1"+"/"+id,
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
	  if (result.isConfirmed) 
	  {
		  var id=$(this).attr('id');
		  jQuery.ajax({
			type: "get",
			url: "act-deact-tab-heading/2"+"/"+id,
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
