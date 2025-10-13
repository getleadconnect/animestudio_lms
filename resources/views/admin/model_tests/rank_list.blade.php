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
              <div class="breadcrumb-title pe-3">Rank List</div>
 
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
                  <h6 class="mb-0 pt5">Rank List </h6>
				  </div>
				  <div class="col-lg-6 col-xl-6 col-xxl-6 col-6 text-right">
				  
				   <button class="btn btn-info btn-xs btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="padding-left:3px;" aria-expanded="true" aria-controls="flush-collapseOne">
                       <i class="lni lni-funnel"></i>
                  </button>&nbsp;
					<a href="javascript:void(0);" class="btn btn-primary btn-xs btn-sm" id="export_to_excel"><i class="fa fa-plus"></i>&nbsp;Export To Excel</a>
				  </div>

				  </div>
                </div>
                <div class="card-body">
					<div class="accordion-item accordion-item-bm" >
                        <div id="flush-collapseOne" class="accordion-collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" >
                          <div class="accordion-body">
						   <div class="row" style="padding:3px 10px 0px 10px;" >

							<div class="col-3 col-lg-3">
								<label>Course</label>
								<select class="form-control mb-3" id="flt_course_id" placeholder="course" required>
								<option value="">select</option>
								@foreach($crs as $r)
									<option value="{{$r->id}}">{{$r->course_name}}</option>
								@endforeach
								</select>
							</div>
							
							<div class="col-3 col-lg-3">
								<label>Select Q-paper</label>
								<select class="form-control mb-3" id="flt_qpaper_id" placeholder="Course" required>
								<option value="">select</option>
								
								</select>
							</div>

						   </div>
						</div>
					  </div>
					</div>
							
				
                   <div class="row mt-2">
                     <div class="col-12 col-lg-12 ">
                      <div class="card  shadow-none w-100">
                        <!--<div class="card-body">-->
                          <div class="table-responsive">
	
                             <table id="datatable" class="table align-middle" style="width:100% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th>SlNo</th>
									<th>Stud.Id</th>
									<!--<th>Question Papers</th>-->
									<th>Student_Name</th>
									<th>Test_Date</th>
									<th>Answer</th>
									<th>Wrong</th>
									<th>Skipped</th>
									<th>Mark</th>
									<th>Rank</th>
											
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



$("#export_to_excel").click(function()
{
	var qpid=$("#flt_qpaper_id").val();
	if(qpid!="")
	{
		var lnk="{{url('export-rank-list')}}"+"/"+qpid;
	    $("#export_to_excel").attr('href',lnk);	
	}
	else
	{
		qpid="0";
		var lnk="{{url('export-rank-list')}}"+"/"+qpid;
	    $("#export_to_excel").attr('href',lnk);
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
		url:"view-rank-list",
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
		{"data": "slno" },
		{"data": "id" },
		//{"data": "qpname" },
		{"data": "name" },
		{"data": "tdate" },
		{"data": "answer" },
		{"data": "wrong" },
		{"data": "skipped" },
		{"data": "score" },
		{"data": "rank" },
	],

});


$("#flt_qpaper_id").change(function()
{
	$('#datatable').DataTable().ajax.reload(null, false);
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







</script>
@endpush
@endsection
