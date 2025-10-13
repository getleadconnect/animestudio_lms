@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')


<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
  <div class="col">
	<div class="card radius-10 border-0 border-start border-tiffany border-3">
	  <div class="card-body">
		<div class="d-flex align-items-center">
		  <div class="">
			<p class="mb-1">Students  </p>
			<h4 class="mb-0 text-tiffany">{{$st_cnt}}</h4>
		  </div>
		  <div class="ms-auto widget-icon bg-tiffany text-white">
			<i class="lni lni-user"></i>
		  </div>
		</div>
	  </div>
	</div>
   </div>
   <div class="col">
	<div class="card radius-10 border-0 border-start border-success border-3">
	  <div class="card-body">
		<div class="d-flex align-items-center">
		  <div class="">
			<p class="mb-1">Subscriptions</p>
			<h4 class="mb-0 text-success">{{$sub_cnt}}</h4>
		  </div>
		  <div class="ms-auto widget-icon bg-success text-white">
			<i class="lni lni-users"></i>
		  </div>
		</div>
	  </div>
	</div>
   </div>
   <div class="col">
	<div class="card radius-10 border-0 border-start border-pink border-3">
	  <div class="card-body">
		<div class="d-flex align-items-center">
		  <div class="">
			<p class="mb-1">&nbsp;</p>
			<h4 class="mb-0 text-pink">&nbsp;</h4>
		  </div>
		  <div class="ms-auto widget-icon bg-pink text-white">
			<i class="bi bi-bar-chart-fill"></i>
		  </div>
		</div>
	  </div>
	</div>
   </div>
   <div class="col">
	<div class="card radius-10 border-0 border-start border-orange border-3">
	  <div class="card-body">
		<div class="d-flex align-items-center">
		  <div class="">
			<p class="mb-1">&nbsp;</p>
			<h4 class="mb-0 text-orange">&nbsp;</h4>
		  </div>
		  <div class="ms-auto widget-icon bg-orange text-white">
			<i class="bi bi-person-plus-fill"></i>
		  </div>
		</div>
	  </div>
	</div>
   </div>

  </div><!--end row-->

<div class="row">
  <div class="col-12 col-lg-6 d-flex">
	<div class="card radius-10 w-100">
	  <div class="card-body">
		<div class="d-flex align-items-center">
		  <h6 class="mb-0">Year wise - Students/Subscriptions </h6>
		</div>
		<hr/>
				
				<input type="hidden" id="stud_years" value="{{$stud_years}}">
				<input type="hidden" id="stud_count" value="{{$stud_cnt}}">
				<input type="hidden" id="subs_count" value="{{$subs_cnt}}">
								
				<div class="row">
					<div class="col-xl-12 mx-auto">
						<div class="chart-container1">
							<canvas id="chart2"></canvas>
						</div>
					</div>
				</div>
	  </div>
	</div>
  </div>
  
  <div class="col-12 col-lg-6 d-flex">
	<div class="card radius-10 w-100">
	  <div class="card-body">
		<div class="d-flex align-items-center">
		   <h6 class="mb-0">Course Wise Subscriptions</h6>
		   </div>
			<hr/>
			
				<input type="hidden" id="cr_lbl" value="{{$cr_lbl}}">
				<input type="hidden" id="cr_cnt" value="{{$cr_cnt}}">
				
				<div class="row">
					<div class="col-xl-12 mx-auto">
						<div class="chart-container1">
				  		   <canvas id="chart6"></canvas>
						</div>
					</div>
				</div>
		   
		   
		</div>
		<!-- content here -->
	  </div>
	</div>
  </div>
</div><!--end row-->


			
@push('scripts')
<script>

</script>
@endpush
@endsection
