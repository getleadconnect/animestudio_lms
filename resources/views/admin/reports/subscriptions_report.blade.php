@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')
<style>
.card-body{
	padding-top:2px !important;
}
</style>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Subscriptions List Report</div>
 
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
                  <h6 class="mb-0 pt5">Subscription List</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
				  
				   <button class="btn btn-info btn-xs btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="padding-left:3px;" aria-expanded="true" aria-controls="flush-collapseOne">
                       <i class="lni lni-funnel"></i>
                  </button>&nbsp;
					<a href="javascript:void(0);" class="btn btn-primary btn-xs btn-sm" id="export_to_excel"><i class="fa fa-plus"></i>&nbsp;Export To Excel</a>
				  </div>
				  				  
				  
				  </div>
                </div>
                <div class="card-body">
					<div class="accordion-item accordion-item-bm" >
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" >
                          <div class="accordion-body">
						   <div class="row" style="padding:3px 10px 0px 10px;" >
						   
						    @php
							$cid=Auth::guard('admin')->user()->center_id;
						    @endphp

							<div class="col-3 col-lg-3">
								<label>Center</label>
								<select class="form-control mb-3" id="flt_center" placeholder="center" required>
								<option value="">select</option>
								@foreach($center as $r)
								<option value="{{$r->id}}" @if($r->id==$cid){{__('selected')}}@endif>{{$r->center_name}}</option>
								@endforeach
								</select>
							</div>
							
							<div class="col-3 col-lg-3">
								<label>Course</label>
								<select class="form-control mb-3" id="flt_course" placeholder="course" required>
								<option value="">select</option>
								@foreach($crs as $r)
								<option value="{{$r->id}}" >{{$r->course_name}}</option>
								@endforeach
								</select>
							</div>
						   </div>
						</div>
					  </div>
					</div>
							
				
                   <div class="row mt-2">
                     <div class="col-12 col-lg-12 d-flex">
                      <div class="card  shadow-none w-100">
                        <!--<div class="card-body">-->
                          <div class="table-responsive">
	
                             <table id="datatable" class="table align-middle" style="width:130% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th>Slno</th>
									<th>Reg.Id</th>
									<th>Center</th>
									<th>Student_Name</th>
									<th>Course_name</th>
									<th>Start_Date</th>
									<th>End_Date</th>
									<th>Rate</th>
									<th>Ref.Code</th>
									<th>Ref.Value</th>
									<th>Amount</th>
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


$("#export_to_excel").click(function()
{
	var cent=$("#flt_center").val();
	var crs=$("#flt_course").val();
	if(cent!="" && crs!="")
	{
		var lnk="{{url('export-subscription-list')}}"+"/"+cent+"/"+crs;
	    $("#export_to_excel").attr('href',lnk);	
	}
	else
	{
		crs="0";
		var lnk="{{url('export-subscription-list')}}"+"/"+cent+"/"+crs;
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
			url:"view-subscription-reports",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.searchCourseId = $('#flt_course').val();
			   data.searchCenterId = $('#flt_center').val();
		    },
        },
		
		columnDefs:[
				  {"width":"40px","targets":[0,1]},
				],
	
        columns: [
			{"data": "slno" },
			{"data": "id" },
			{"data": "center" },
			{"data": "sname" },
			{"data": "cname" },
			{"data": "sdate" },
			{"data": "edate" },
			{"data": "rate" },
			{"data": "rcode" },
			{"data": "rvalue" },
			{"data": "netamt" },
        ],

});


$("#flt_course").change(function()
{
	$('#datatable').DataTable().ajax.reload(null, false);
	
});

$("#flt_center").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
		type: "GET",
		url: "get-course-by-center-id"+"/"+id,
		dataType: 'json',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#flt_course").html(res);
		}
	});
	$('#datatable').DataTable().ajax.reload(null, false);
});


</script>
@endpush
@endsection
