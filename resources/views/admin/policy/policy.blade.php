@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')
<style>
.card-body{
	padding-top:2px !important;
}

.dropdown-toggle::after{ content:none !important; }
</style>


<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Privacy/Terms</div>
 
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
                  <h6 class="mb-0 pt5">Privacy Policy</h6>
				  </div>
				  <div class="col-lg-6 col-xl-6 col-xxl-6 col-6 text-right">
				  <!--<button type="button" class="btn btn-primary btn-xs btn-sm" data-bs-toggle="modal" data-bs-target="#BasicModal1"><i class="fa fa-plus"></i>&nbsp;Add Message</button>-->
				  </div>

				  </div>
                </div>
                <div class="card-body">
					
                   <div class="row mt-2">
                     <div class="col-12 col-lg-12 ">
                      <div class="card  shadow-none w-100">
                        <!--<div class="card-body">-->
                          <!--<div class="table-responsive">-->
	
                             <table id="datatable" class="table align-middle" style="width:100% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th>Action</th>
									<th>Id</th>
									<th>Category</th>
									<th>Data</th>
									<th>Status</th>
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
						
						
						<form >

						<div class="form-group">
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Select Type</label>
							<select class="form-control mb-3" placeholder="Gender" required>
							<option value="">select</option>
							<option value="1">General</option>
							<option value="2">Course</option>
							</select>
							</div>
							
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Select Course</label>
							<select class="form-control mb-3" placeholder="Gender" required>
							<option value="">select</option>
							<option value="1">LDC</option>
							<option value="2">HS-ASST</option>
							<option value="3">Forest Guard</option>
							<option value="4">Primary Teacher</option>
							</select>
							</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label>Notification</label>
						<textarea class="form-control mb-3" placeholder="Message" required></textarea>
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
						<form >

						<div class="form-group">
						<div class="row">
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Select Type</label>
							<select class="form-control mb-3" placeholder="Gender" required>
							<option value="">select</option>
							<option value="1" selected>General</option>
							<option value="2">Course</option>
							</select>
							</div>
							
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Select Course</label>
							<select class="form-control mb-3" placeholder="Gender" required>
							<option value="">select</option>
							<option value="1" selected>LDC</option>
							<option value="2">HS-ASST</option>
							<option value="3">Forest Guard</option>
							<option value="4">Primary Teacher</option>
							</select>
							</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label>Notification</label>
						<textarea class="form-control mb-3" placeholder="Message" required>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </textarea>
						</div>
						</div>
						</div>
		
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Update changes</button>
						</div>
						</form>
						</div>
					</div>
				</div>
			</div>


		<div class="modal fade" id="BasicModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">View</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>

					<div class="modal-body">
					<textarea class="form-control" id="policy-data"> </textarea>
					
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
					</div>
					
				</div>
			</div>
		</div>


		
@push('scripts')
<script>

$('#policy-data').summernote({
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
			url:"view-policy",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
        },
		
		columnDefs:[
				  {"width":"40px","targets":1},
				],
	
        columns: [
            {"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "id" },
			{"data": "cat" },
			{"data": "policy" },
			{"data": "status" },
			{"data": "addedby" },
			
        ],

});


$("#datatable tbody").on('click','.more',function()
{
	var id=$(this).attr('id');
			jQuery.ajax({
			type: "GET",
			url: "{{url('get-policy-data')}}"+"/"+id,
			dataType: 'json',
			//data: {vid: vid},
			success: function(res)
			{
			   $(".note-editable").html(res.policy);
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
			url: "act-deact-policy/1"+"/"+id,
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
			url: "act-deact-policy/2"+"/"+id,
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
