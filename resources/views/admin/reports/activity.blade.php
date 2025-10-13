@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')
<style>
.card-body{
	padding-top:2px !important;
}
</style>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Activities</div>
 
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
                  <h6 class="mb-0 pt5">View Activities </h6>
				  </div>
				  <div class="col-lg-6 col-xl-6 col-xxl-6 col-6 text-right">
				  
				  <!-- <button class="btn btn-info btn-xs btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="padding-left:3px;" aria-expanded="true" aria-controls="flush-collapseOne">
                       <i class="lni lni-funnel"></i>
                  </button>&nbsp;
					<!--<a href="javascript:;" class="btn btn-primary btn-xs btn-sm" ><i class="fa fa-download"></i>&nbsp;Export to Excel</a>-->
				  </div>

				  </div>
                </div>
                <div class="card-body">
				{{-- <!--<div class="accordion-item accordion-item-bm" >
                        <div id="flush-collapseOne" class="accordion-collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" >
                          <div class="accordion-body">
						   <div class="row" style="padding:3px 10px 0px 10px;" >

							<div class="col-3 col-lg-3">
								<label>Select Course</label>
								<select class="form-control mb-3" placeholder="Gender" required>
								<option value="">select</option>
								<option value="LDC" >LDC</option>
								<option value="HSASST">HSASST</option>
								</select>
							</div>

						   </div>
						</div>
					  </div>
					</div>--> --}}
							
				
                   <div class="row mt-2">
                     <div class="col-12 col-lg-12 ">
                      <div class="card  shadow-none w-100">
                        <!--<div class="card-body">-->
                          <div class="table-responsive">
	
                             <table id="table-course" class="table align-middle" style="width:100% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th>Id</th>
									<th>Student</th>
									<th>Joined_Date</th>
									<th>Exam_attempted</th>
									<th>Video_Watched</th>
									<th>App-Usage</th>
								</tr>
                               </thead>
                               <tbody>
                                   <tr>
									<td>1</td>
									<td>Renju Jose</td>
									<td>1-3-2024</td>
									<td>100 Nos</td>
									<td>250 Minuts</td>
									<td>200 Minuts</td>
								</tr>
								
								<tr>
									<td>2</td>
									<td>Ceema A. J</td>
									<td>2-4-2024</td>
									<td>85 Nos</td>
									<td>160 Minuts</td>
									<td>200 Minuts</td>
								</tr>
								
								<tr>
									<td>3</td>
									<td>Renny A. M</td>
									<td>5-3-2024</td>
									<td>75 Nos</td>
									<td>175 Minuts</td>
									<td>200 Minuts</td>
								</tr>
								<tr>
									<td>4</td>
									<td>Davis John</td>
									<td>10-5-2024</td>
									<td>55 Nos</td>
									<td>75 Minuts</td>
									<td>90 Minuts</td>
								</tr>
								
								<tr>
									<td>5</td>
									<td>Arunitha M.</td>
									<td>15-5-2024</td>
									<td>80 Nos</td>
									<td>150 Minuts</td>
									<td>170 Minuts</td>
								</tr>
								
								<tr>
									<td>6</td>
									<td>Amrutha  K.P</td>
									<td>6-3-2024</td>
									<td>120 Nos</td>
									<td>200 Minuts</td>
									<td>250 Minuts</td>
								</tr>
								
								<tr>
									<td>7</td>
									<td>Remya Satheesh</td>
									<td>1-2-2024</td>
									<td>90 Nos</td>
									<td>200 Minuts</td>
									<td>170 Minuts</td>
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
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add Question Paper</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<form >
						<div class="modal-body">
						
						
						<div class="form-group">
						
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Select Course</label>
						<select class="form-control mb-3" placeholder="Course" required>
						<option value="">select</option>
						<option value="1">LDC</option>
						<option value="2">HS-ASST</option>
						<option value="3">Forest Guard</option>
						<option value="4">Primary Teacher</option>
						</select>
						</div>
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Select Tab</label>
						<select class="form-control mb-3" placeholder="Tab Name" required>
						<option value="">select</option>
						<option value="1">SERT</option>
						<option value="2">NCRT</option>
						<option value="3">Model Eams</option>
						</select>
						</div>
						</div>
						</div>
						
						<div class="form-group">
							<div class="row">
							<div class="col-lg-12 col-xl-12 col-xxl-12">
							<label>Question Paper Name</label>
							<input class="form-control mb-3" type="text" placeholder="Name" required>
							</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
							<div class="col-lg-5 col-xl-5 col-xxl-5">
							<label>Start Date</label>
							<input class="form-control mb-3" type="date" placeholder="start date" required>
							</div>
							<div class="col-lg-4 col-xl-4 col-xxl-4">
							<label>Duration(Mins)</label>
							<input class="form-control mb-3" type="number" placeholder="Duration" value="45" required>
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
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<form >
						<div class="modal-body">
						<div class="form-group">
						
						<div class="row">
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
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label>Select Tab</label>
						<select class="form-control mb-3" placeholder="Tab Name" required>
						<option value="">select</option>
						<option value="1" selected>SERT</option>
						<option value="2">NCRT</option>
						<option value="3">Model Eams</option>
						</select>
						</div>
						</div>
						</div>
						
							<div class="form-group">
							<div class="row">
							<div class="col-lg-12 col-xl-12 col-xxl-12">
							<label>Question Paper Name</label>
							<input class="form-control mb-3" type="text" placeholder="Name"  value="question papaer ldc-1" required>
							</div>
							</div>
							</div>
							
							<div class="form-group">
							<div class="row">
							<div class="col-lg-5 col-xl-5 col-xxl-5">
							<label>Start Date</label>
							<input class="form-control mb-3" type="date" placeholder="start date" value="2024-05-05" required>
							</div>
							
							<div class="col-lg-4 col-xl-4 col-xxl-4">
							<label>Duration(Mins)</label>
							<input class="form-control mb-3" type="number" placeholder="Duration" value="45" required>
							</div> 
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
	

</script>
@endpush
@endsection
