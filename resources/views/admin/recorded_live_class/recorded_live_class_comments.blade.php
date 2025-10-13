@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Recorded Video Class Comments</div>
 
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
                  <h6 class="mb-0 pt5">Comments</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
				  <button class="btn btn-info btn-xs btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="padding-left:3px;" aria-expanded="true" aria-controls="flush-collapseOne">
                       <i class="lni lni-funnel"></i>
                  </button>&nbsp;
                  <!--<a href="{{url('add-videos')}}" class="btn btn-primary btn-xs btn-sm"><i class="fa fa-plus"></i>&nbsp;Add Videos</a>-->
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
								<select class="form-control mb-3" id="flt_course"  placeholder="Gender" required>
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
                          <!--<div class="table-responsive">-->
	
                             <table id="datatable" class="table align-middle" style="width:120% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th class="no-content">Action</th>
									<th>Id</th>
									<th>Course</th>
									<th>Student Name</th>
									<th>Video_Class</th>
									<th>Comments</th>
								</tr>
                               </thead>
                               <tbody>

                               </tbody>
                             </table>
                          <!--</div>-->

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
							<h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<div class="modal-body">


						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save changes</button>
						</div>
						
					</div>
				</div>
			</div>


@push('scripts')
<script>


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
		url:"recorded-video-comment-data",
		data: function (data) 
		{
		   data.search = $('input[type="search"]').val();
		   data.searchCourse = $('#flt_course').val();
		},
	},
	
	columnDefs:[
			  {"width":"40px","targets":[0,1]},
			],

	columns: [
		{"data": "action" ,name: 'Action',orderable: false, searchable: false },
		{"data": "id" },
		{"data": "cname" },
		{"data": "stname" },
		{"data": "vtitle" },
		{"data": "comnt" },

	],

});


$("#flt_course").change(function()
{
	$('#datatable').DataTable().ajax.reload(null, false);
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
			url: "delete-recorded-video-comment"+"/"+id,
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
