@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')
<style>
.card-body{
	padding-top:2px !important;
}
.view-image img:hover
{
	padding:2px;
	border:1px solid #ababd9;
}
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
<!-- for message end-------------->	



<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Question Paper Questions</div>
 
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
                  <h6 class="mb-0 pt5">Questions List</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
				   <button class="btn btn-info btn-xs btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="padding-left:3px;" aria-expanded="true" aria-controls="flush-collapseOne">
                      <i class="lni lni-funnel"></i>
                   </button>&nbsp;
                   <a href="{{route('add-question')}}" class="btn btn-primary btn-xs btn-sm" ><i class="fa fa-plus"></i>&nbsp;Add Question</a>
				  </div>

				  </div>
                </div>
                <div class="card-body">
					<div class="accordion-item accordion-item-bm" >
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" >
                          <div class="accordion-body">
						   <div class="row" style="padding:3px 10px 0px 10px;" >
							
							<div class="col-3 col-lg-3">
								
								<label >Select Course </label>
							    	<select class="form-control mb-3"  id="flt_course_id" name="flt_course_id" required>
										<option value="">--select--</option>
										@foreach($crs as $r)
										<option value="{{$r->id}}">{{$r->course_name}}</option>
										@endforeach
							        </select>
							</div>

							<div class="col-3 col-lg-3">
								<label >Question Paper </label>
							    	<select class="form-control" id="flt_qpaper_id" name="flt_qpaper_id" required>
										<option value="">--select--</option>
							        </select>
							</div>
							
						   </div>
						</div>
					  </div>
				   </div>
				   
				   <div class="row mt-2">
                     <div class="col-6 col-lg-6 col-xl-6 col-xxl-6">
					 <label class="mb-2" >Q-Paper: <span style="color:blue;" id="qpaper_name"></span></label>
					 </div>
					 
					 <div class="col-6 col-lg-6 col-xl-6 col-xxl-6 text-right">
					 <label class="mb-2" >Total Questions :<span style="color:blue;" id="tot_questions"></span></label>
					 </div>
					 </div>

                   <div class="row mt-2">
                     <div class="col-12 col-lg-12">
                      <div class="card  shadow-none w-100">
                        <!--<div class="card-body">-->

                          <div class="table-responsive">
	
                             <table id="datatable" class="table align-middle" style="width:150% !important;" >
                               <thead class="table-light">
                                 <tr>
									<td class="no-content">
										Action
									</td>
									<th>Id</th>
									<th>Question_Paper</th>
									<th>Subject</th>
									<th>Type</th>
									<th>question</th>
									<th>Answer(1)</th>
									<th>Answer(2)</th>
									<th>Answer(3)</th>
									<th>Answer(4)</th>
									<th>Answer</th>
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
	
	<div class="modal fade" id="BasicModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">View - Image Question</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				
				<div class="modal-body">
				<img id="img-view" src="" style="width:100%;">
				</div>
				
				<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
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
		url:"view-qpaper-questions",
		data: function (data) 
		{
		   data.search = $('input[type="search"]').val();
		   data.searchQpaperId = $('#flt_qpaper_id').val();
		   
		},
	},
	
	columnDefs:[
			     {"width":"40px","targets":0},
			   ],

	columns: [
		{"data": "action" ,name: 'Action',orderable: false, searchable: false },
		{"data": "id" },
		{"data": "qpname" },
		{"data": "qb_subject" },
		{"data": "type" },
		{"data": "quest" },
		{"data": "ans1" },
		{"data": "ans2" },
		{"data": "ans3" },
		{"data": "ans4" },
		{"data": "cans" },
	],

	drawCallback: function() {
        var api = this.api();
        var num_rows = api.page.info().recordsTotal;
        //var records_displayed = api.page.info().recordsDisplay;
		$('#tot_questions').html(num_rows);
    }
	
	
});

$("#flt_qpaper_id").change(function()
{
	$('#datatable').DataTable().ajax.reload(null, false);
	$("#qpaper_name").html($("#flt_qpaper_id option:selected").text());
});


$("#flt_course_id").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
		type: "GET",
		url: "get-qpapers-by-course-id"+"/"+id,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#flt_qpaper_id").html(res);
		}
	});
});

$('#datatable tbody').on( 'click', '.view-image', function ()
  {
	
	var dataImg=$(this).data('image');
	$("#img-view").attr('src',dataImg);
  });
 
 

$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');
	
	var Result=$("#BasicModal2 .modal-body");
		
		//$(this).attr('data-bs-target','#BasicModal2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit-question"+"/"+id,
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
			url: "delete-question"+"/"+id,
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
