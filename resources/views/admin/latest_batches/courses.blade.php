@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Course</div>
 
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
                  <h6 class="mb-0 pt5">Course List</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
                  <button type="button" class="btn btn-primary btn-xs btn-sm" data-bs-toggle="modal" data-bs-target="#BasicModal1"><i class="fa fa-plus"></i>&nbsp;Add Course</button>
				  </div>
				  				  
				  
				  </div>
                </div>
                <div class="card-body">
                   <div class="row">
                     
                     <div class="col-12 col-lg-12 d-flex">
                      <div class="card  shadow-none w-100">
                        <!--<div class="card-body">-->
                          <div class="table-responsive">
	
                             <table id="table-course" class="table align-middle" style="width:150% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th class="no-content">Action</th>
									<th>Id</th>
									<th>Company</th>
									<th>Course_Name</th>
									<th>Icon</th>
									<th>Description</th>
									<th>Start_Date</th>
									<th>Rate</th>
									<th>IOS_Rate</th>
									<th>App_store_id</th>
									<th>Subscription_Type</th>
									<th>Status</th>
									<th>Added_By</th>
									
								</tr>
                               </thead>
                               <tbody>
                                   <tr>
								   
									<td class="no-content">
										<a href="javascript:void(0)" class="btnDeact btn btn-warning btn-rect btn-xs btn-sm fap pr8" title="Deactivate Course" ><i class="fa fa-times"></i></a>
										<a href="javascript:void(0)" class="btnEdit btn btn-primary btn-rect btn-xs btn-sm fap" data-bs-toggle="modal" data-bs-target="#BasicModal2"  title="Edit course" ><i class="fa fa-edit"></i></a>
										<a href="javascript:void(0)" class="btnDel btn btn-danger btn-rect btn-xs btn-sm fap pr8" title="Delete Course" ><i class="fa fa-trash"></i></a>
									</td>
									<td>1</td>
									<td>Aim Blsy</td>
									<td>LDC</td>
									<td><img src="uploads/course_icons/picture-1.png" style="width:50px;height:50px;"></td>
									<td>This is Lower Division Clerck Trainig</td>
									<td>10-4-2024</td>
									<td>3500</td>
									<td>4500</td>
									<td>iosldc2024</td>
									<td>Subscription</td>
									<td><span class="badge bg-success">Active</span></td>
									<td>Admin</td>
								</tr>
								
								<tr>
								<td class="no-content">
										<a href="javascript:void(0)" class="btnAct btn btn-success btn-rect btn-xs btn-sm fap pr8" title="Activate Course" ><i class="fa fa-check"></i></a>
										<a href="javascript:void(0)" class="btnEdit btn btn-primary btn-rect btn-xs btn-sm fap " data-bs-toggle="modal" data-bs-target="#BasicModal2"  title="Edit course" ><i class="fa fa-edit"></i></a>
										<a href="javascript:void(0)" class="btnDel btn btn-danger btn-rect btn-xs btn-sm fap pr8" title="Delete Course" ><i class="fa fa-trash"></i></a>
									</td>
									<td>2</td>
									<td>Aim Blsy</td>
									<td>SeAst</td>
									<td><img src="uploads/course_icons/picture-2.png" style="width:50px;height:50px;"></td>
									<td>This is testing course</td>
									<td>10-4-2024</td>
									<td>3500</td>
									<td>4500</td>
									<td>iosldc2024</td>
									<td>Subscription</td>
									<td><span class="badge bg-warning">Inactive</span></td>
									<td>Admin</td>
									
								</tr>
								
								    <tr>
									<td class="no-content">
										<a href="javascript:void(0)" class="btnDeact btn btn-warning btn-rect btn-xs btn-sm fap pr8" title="Deactivate Course" ><i class="fa fa-times"></i></a>
										<a href="javascript:void(0)" class="btnEdit btn btn-primary btn-rect btn-xs btn-sm fap " data-bs-toggle="modal" data-bs-target="#BasicModal2"  title="Edit course" ><i class="fa fa-edit"></i></a>
										<a href="javascript:void(0)" class="btnDel btn btn-danger btn-rect btn-xs btn-sm fap pr8" title="Delete Course" ><i class="fa fa-trash"></i></a>
									</td>
									<td>3</td>
									<td>Aim Blsy</td>
									<td>LDC</td>
									<td><img src="uploads/course_icons/picture-3.png" style="width:50px;height:50px;"></td>
									<td>This is Lower Division Clerck Trainig</td>
									<td>10-4-2024</td>
									<td>3500</td>
									<td>4500</td>
									<td>iosldc2024</td>
									<td>Subscription</td>
									<td><span class="badge bg-success">Aactive</span></td>
									<td>Admin</td>
									
								</tr>
								
								<tr>
									<td class="no-content">
										<a href="javascript:void(0)" class="btnAct btn btn-success btn-rect btn-xs btn-sm fap pr8" title="Activate Course" ><i class="fa fa-check"></i></a>
										<a href="javascript:void(0)" class="btnEdit btn btn-primary btn-rect btn-xs btn-sm fap" data-bs-toggle="modal" data-bs-target="#BasicModal2"  title="Edit course" ><i class="fa fa-edit"></i></a>
										<a href="javascript:void(0)" class="btnDel btn btn-danger btn-rect btn-xs btn-sm fap pr8" title="Delete Course" ><i class="fa fa-trash"></i></a>
									</td>
									<td>4</td>
									<td>Aim Blsy</td>
									<td>SeAst</td>
									<td><img src="uploads/course_icons/picture-4.png" style="width:50px;height:50px;"></td>
									<td>This is testing course</td>
									<td>10-4-2024</td>
									<td>3500</td>
									<td>4500</td>
									<td>iosldc2024</td>
									<td>Subscription</td>
									<td><span class="badge bg-warning">Inactive</span></td>
									<td>Admin</td>
								</tr>
			
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
							<h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<form method="POST" action="{{url('courses')}}">
						<div class="modal-body">
						<div class="form-group">
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Course</label>
						<input class="form-control mb-3" type="text" placeholder="Course Name" required>
						</div>
						
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<label>Rate</label>
						<input class="form-control mb-3" type="text" placeholder="Rate" required>
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Start-Date</label>
						<input class="form-control mb-3" type="text" placeholder="Start date" required>
						</div>
					
						</div>
						</div>
						
						
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-3 col-xl-3 col-xxl-3">
						<label>IOS-Rate</label>
						<input class="form-control mb-3" type="text" placeholder="IOS rate" required>
						</div>
						
						<div class="col-lg-5 col-xl-5 col-xxl-5">
						<label>App Product Id</label>
						<input class="form-control mb-3" type="text" placeholder="App store product id" required>
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Subscription Type</label>
						<select class="form-control mb-3" required>
						<option value="">Select Type</option>
						<option value="1">Subscription</option>	
						<option value="2">Consumable</option>
						</select>
						</div>
					
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label>Description</label>
						<textarea class="form-control mb-3" placeholder="Description" style="text-align:left;"></textarea>
						</div>
						
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Course Icon</label>
						<input type="file" class="form-control mb-3" placeholder="select file">
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


		<div class="modal fade" id="BasicModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<form >
						<div class="modal-body">
						<div class="form-group">
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Course</label>
						<input class="form-control mb-3" type="text" placeholder="Course Name" value="LDC" required>
						</div>
						
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<label>Rate</label>
						<input class="form-control mb-3" type="text" placeholder="Rate"  value="3500" required>
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Start-Date</label>
						<input class="form-control mb-3" type="text" placeholder="Start date" value="10-04-2024" required>
						</div>
					
						</div>
						</div>
						
						
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-3 col-xl-3 col-xxl-3">
						<label>IOS-Rate</label>
						<input class="form-control mb-3" type="text" placeholder="IOS rate" value="4000" required>
						</div>
						
						<div class="col-lg-5 col-xl-5 col-xxl-5">
						<label>App Product Id</label>
						<input class="form-control mb-3" type="text" placeholder="App store product id" value="iosldc2024" required>
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Subscription Type</label>
						<select class="form-control mb-3" required>
						<option value="">Select Type</option>
						<option value="1" selected>Subscription</option>
						<option value="2">Consumable</option>
						</select>
						</div>
					
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label>Description</label>
						<textarea class="form-control mb-3" placeholder="Description">this is testing course</textarea>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Course Icon</label>
						<input type="file" class="form-control mb-3" placeholder="select file">
						</div>
						
						<div class="col-lg-3 col-xl-3 col-xxl-3">
							<img src="uploads/course_icons/picture-1.png" style="width:50px;height:50px;">
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

var table = $('#table-course').DataTable({
        processing: true,
        //serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :50,
		scrollX: true,
});

$(document).on('click','.btnDel',function()
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
		Swal.fire({
		  title: "Deleted!",
		  text: "Your file has been deleted.",
		  icon: "success"
		});
	  }
	});

});


$(document).on('click','.btnAct',function()
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
		Swal.fire({
		  title: "Activated!",
		  text: "Your this item has been activated.",
		  icon: "success"
		});
	  }
	});

});


$(document).on('click','.btnDeact',function()
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
		Swal.fire({
		  title: "Deactivated!",
		  text: "Your this item has been deactivated.",
		  icon: "success"
		});
	  }
	});

});


/*$(document).ready(function()
{
	var table = $('#table-company').DataTable({
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
			url:"view-company",
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
			{"data": "add" },
			{"data": "email" },
			{"data": "mob" },
			{"data": "status" },
			{"data": "addedby" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
			
        });
		
		});

*/
	
	/*var table = $('#html5-extension').DataTable({
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
			url:"view-clients",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  {"width":"40px","targets":0},
				  {"width":"50px","targets":1},
				  {"width":"150px","targets":4},
				  
				],
	
        columns: [
            {"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "cname" },
			{"data": "cperson" },
			{"data": "add" },
			{"data": "gstno" },
			{"data": "other" },
			{"data": "addedby" },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });*/
	
	
	



</script>
@endpush
@endsection
