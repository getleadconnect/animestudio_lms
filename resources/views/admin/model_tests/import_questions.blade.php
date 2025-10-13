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
              <div class="breadcrumb-title pe-3">Import Questions (Question Paper)</div>
 
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
                  <h6 class="mb-0 pt5">Import</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
				    <a href="{{url('view-questions')}}" class="btn btn-primary btn-xs btn-sm" ><i class="fa fa-plus"></i>&nbsp;View Questions</button></a>
				  </div>

				  </div>
                </div>
                <div class="card-body">

                <div class="row mt-2">
				   <div class="col-12 col-lg-12 col-xl-12 col-xxl-12">
				   
                    <div class="card  shadow-none w-100">
					
					<div class="row mt-2" >
					<div class="col-12 col-lg-12 col-xl-12 col-xxl-12">
					<ul>
						<li> 1. To download excel file template, <a href="{{url('model_test_questions.xlsx')}}" download >Click Here.</a> And add questions into the file</li>
						<li> 2. Click on the 'Choose File' button and select questions excel file</li>
						<li> 3. Then click 'Import Question' button.</li>
					</ul>
					
					</div>
					</div>
					
					<div class="row mt-2" >
					<div class="col-8 col-lg-8 col-xl-8 col-xxl-8">

						<form method="POST" action="{{url('qpaper-questions-import')}}" enctype="multipart/form-data">
						@csrf
						<div class="form-group mt-2">
								<label >Select Course </label>
							    	<select class="form-control mb-3"  id="course_id" name="course_id" required>
										<option value="">--select--</option>
										@foreach($crs as $r)
										<option value="{{$r->id}}">{{$r->course_name}}</option>
										@endforeach
							        </select>
							</div>
							
							<div class="form-group">
								<label >Question Paper </label>
							    	<select class="form-control" id="qpaper_id" name="qpaper_id" required>
										<option value="">--select--</option>
							        </select>
							</div>
						
						<div class="form-group mt-3">
							<div class="row">
							<div class="col-lg-8 col-xl-8 col-xxl-8">
							<label>Choose File (.xlsx)</label>
							<input class="form-control mb-3" type="file" name="question_file" placeholder="select excel file" required>
							</div>
							</div>
						</div>

							<button type="submit" id="btn_submit" class="btn btn-primary">Import Questions</button>
						</form>

				    </div>

                    </div>
					
                   </div><!--end row-->
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


$("#course_id").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
		type: "GET",
		url: "get-question-papers-by-course-id"+"/"+id,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#qpaper_id").html(res);
		}
	});
});


</script>
@endpush
@endsection
