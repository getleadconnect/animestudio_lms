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
              <div class="breadcrumb-title pe-3">Course Category</div>
 
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
                  <h6 class="mb-0 pt5">Categories</h6>
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

					<label class=" mb-3" style="color:blue;"><u>Add Category</u></label>

						<form id="addCategory" enctype="multipart/form-data">
						@csrf
							<div class="form-group">
							<div class="row">
							<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">No Of Category</label>
							  <div class="col-lg-4 col-xl-4 col-xxl-4">
								<input type="number" id="cat_count" name="cat_count" class="form-control mb-3" required>
							  </div>
							   <div class="col-lg-4 col-xl-4 col-xxl-4">
								<button type="button" id="btnCategory" class="btn btn-primary" style="padding-left:5px; padding-right:10px;"><i class="fa fa-plus"></i></button>
							  </div>
							</div>
							</div>
							
							<div id="category">
							
							
							</div>
							
							<button type="submit" id="btn_submit" class="btn btn-primary" disabled>Add Category</button>
						</form>

				    </div>
				   
                     <div class="col-7 col-lg-7 col-xl-7 col-xxl-7">
	
                        <!--<div class="card-body">-->
                             <table id="datatable" class="table align-middle" style="width:100% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th>Id</th>
									<th>Course_Category</th>
									<th>Status</th>
									<th>Added_By</th>
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
				
				<form id="updateCategory" enctype="multipart/form-data">
				  @csrf
				  
					<input type="hidden" id="category_id" name="category_id" required>
				  
					  <div class="modal-body">
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label>Category</label>
						  <input class="form-control mb-3" type="text" id="category_edit" name="category_edit" placeholder="Categories" required>
						</div>
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
			url:"view-course-category",
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
			{"data": "cat" },
			{"data": "stat" },
			{"data": "addedby" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
			
 });


$("#datatable tbody").on('click','.edit',function()
{
	var id=$(this).attr('id');
	$(this).attr('data-bs-target','#BasicModal2');
	var cat=$(this).closest('tr').find('td').eq(1).text();
	$("#category_edit").val(cat);
	$("#category_id").val(id);
});


$("form#addCategory").submit(function(e)
{
   e.preventDefault();
   
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('save-course-category')}}",
          type: 'post',
          data: formData,
		  dataType:'json',
          success: function (res) 
		  {
			 if(res.status==true)
			 {
				//$('#BasicModal1').modal('hide');
				toastr.success(res.msg);
				$('#datatable').DataTable().ajax.reload(null, false);
				$('#addSubjects')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				$('#addSubjects')[0].reset();
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
});


$("form#updateCategory").submit(function(e)
{
   e.preventDefault();
   
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('update-course-category')}}",
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
				$('#updateSubject')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				$('#updateSubject')[0].reset();
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
});


$(document).on('click','#btnCategory',function()
{
	var scnt=$("#cat_count").val();
	if(scnt>0)
	{
		cat="";
		for(x=1;x<=scnt;x++)
		{
			
			cat+='<div class="form-group">\
				<div class="row">\
				<div class="col-lg-12 col-xl-12 col-xxl-12">\
					<label>category-'+x+'</label>\
					<input type="text" name="category[]" class="form-control mb-3" placeholder="category-'+x+'" required>\
				</div>\
				</div>\
				</div>';	
		}
		
		$("#btn_submit").prop('disabled',false);
		$("#category").html(cat);
		
	}
	else
	{
		Swal.fire("Warning!","Category count missing!");
	}
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
			url: "delete-course-category"+"/"+id,
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
			url: "act-deact-course-category/1"+"/"+id,
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
			url: "act-deact-course-category/2"+"/"+id,
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
