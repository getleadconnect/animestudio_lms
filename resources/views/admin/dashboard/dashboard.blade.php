@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')
<style>
.theme-icons {
    background-color: #cdeaf3 !important;
    color: #434547;
}
</style>


<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
  <div class="col">
	<div class="card radius-10 border-0 border-start border-tiffany border-3">
	  <div class="card-body">
		<div class="d-flex align-items-center">
		  <div class="">
			<p class="mb-1">Students  </p>
			<h4 class="mb-0 text-tiffany">{{$data['st_cnt']}}</h4>
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
			<h4 class="mb-0 text-success">{{$data['sub_cnt']}}</h4>
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
			<p class="mb-1">Courses</p>
			<h4 class="mb-0 text-pink">{{$data['course_cnt']}}</h4>
		  </div>
		  <div class="ms-auto widget-icon bg-pink text-white">
			<i class="lni lni-graduation"></i>
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
  

		   <label class="mb-2" style="font-size:14px;font-weight:600;">Quick Access</label>
  
			<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-5 g-1 mb-3 p-1" style="border:1px solid #cdeaf3;">
					<div class="col">
					<a href="{{url('students')}}">
						<div class="d-flex align-items-center theme-icons shadow-sm p-1 cursor-pointer rounded">
							<div class="font-22">	<i class="bi bi-person-lines-fill"></i>
							</div>
							<div class="ms-2"><span>Add Student</span>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
						<a href="{{url('admin/courses')}}">
						<div class="d-flex align-items-center theme-icons shadow-sm p-1 cursor-pointer rounded">
							<div class="font-22">	<i class="lni lni-graduation"></i>
							</div>
							<div class="ms-2">	<span>Courses</span>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
						<a href="{{url('live-classes')}}">
						<div class="d-flex align-items-center theme-icons shadow-sm p-1 cursor-pointer rounded">
							<div class="font-22">	<i class="lni lni-play"></i>
							</div>
							<div class="ms-2">	<span>Live Class</span>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
						<a href="{{url('recorded-video-comments')}}">
						<div class="d-flex align-items-center theme-icons shadow-sm p-1 cursor-pointer rounded">
							<div class="font-22">	<i class="lni lni-display"></i>
							</div>
							<div class="ms-2">	<span>Recorded Live Class</span>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
					<a href="{{url('add-videos')}}">
						<div class="d-flex align-items-center theme-icons shadow-sm p-1 cursor-pointer rounded">
							<div class="font-22">	<i class="lni lni-video"></i>
							</div>
							<div class="ms-2">	<span>Add Videos</span>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
					<a href="{{url('pdf-files')}}">
						<div class="d-flex align-items-center theme-icons shadow-sm p-1 cursor-pointer rounded">
							<div class="font-22">	<i class="lni lni-files"></i>
							</div>
							<div class="ms-2">	<span>Add PDF Files</span>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
					<a href="{{url('question-papers')}}">
						<div class="d-flex align-items-center theme-icons shadow-sm p-1 cursor-pointer rounded">
							<div class="font-22">	<i class="lni lni-empty-file"></i>
							</div>
							<div class="ms-2">	<span>Question Papers</span>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
					<a href="{{url('prepare-questions')}}">
						<div class="d-flex align-items-center theme-icons shadow-sm p-1 cursor-pointer rounded">
							<div class="font-22">	<i class="fadeIn animated bx bx-file"></i>
							</div>
							<div class="ms-2">	<span>Prepare Questions</span>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
					<a href="{{url('rank-list')}}">
						<div class="d-flex align-items-center theme-icons shadow-sm p-1 cursor-pointer rounded">
							<div class="font-22">	<i class="fadeIn animated bx bx-detail"></i>
							</div>
							<div class="ms-2">	<span>Rank List</span>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
					<a href="{{url('notifications')}}">
						<div class="d-flex align-items-center theme-icons shadow-sm p-1 cursor-pointer rounded">
							<div class="font-22">	<i class="fadeIn animated bx bx-notification"></i>
							</div>
							<div class="ms-2">	<span>Notifications</span>
							</div>
						</div>
						</a>
					</div>
					
					
				</div>
		</fieldset>




<div class="row">
  <div class="col-12 col-lg-6 d-flex">
	<div class="card radius-10 w-100">
	  <div class="card-body">
		<div class="d-flex align-items-center">
		  <h6 class="mb-0">Year wise - Students/Subscriptions </h6>
		</div>
		<hr/>
				
				<input type="hidden" id="stud_years" value="{{$data['stud_years']}}">
				<input type="hidden" id="stud_count" value="{{$data['stud_cnt']}}">
				<input type="hidden" id="subs_count" value="{{$data['subs_cnt']}}">
								
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
			
				<input type="hidden" id="cr_lbl" value="{{$data['cr_lbl']}}">
				<input type="hidden" id="cr_cnt" value="{{$data['cr_cnt']}}">
				
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
