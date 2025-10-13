@extends('admin.layouts.master')
@section('title','Question bank')
@section('contents')
<style>
.card-body{
	padding-top:2px !important;
}
 
.opt-radio
 {
	 width:20px ;
	 height:20px ;
	 display:flex ;
	 margin:auto ;
	 border-color:#4460eb ;
 }
.show{ display:inline-block;}
.hide{display:none;}	
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Edit Question Bank Question</div>
 
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
                  <h6 class="mb-0 pt5">Question</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
                   <a href="{{route('questions')}}" class="btn btn-primary btn-xs btn-sm"><i class="fa fa-plus"></i>&nbsp;View Questions</a>
				  </div>

				  </div>
                </div>
                <div class="card-body">

                   <div class="row mt-2">
                     <div class="col-8 col-lg-8 col-xxl-8col-xl-8">
					 
							<form  method="POST" action="{{route('update-qbank-question')}}" enctype="multipart/form-data" >
							@csrf
							
							<input type="hidden" name="quest_id" value="{{$qs->id}}">
							<input type="hidden" name="quest_type" value="{{$qs->question_type}}">

							<input type="hidden" name="quest_image" 
							@if($qs->question_type==1)
							value="{{$qs->question}}" @else value="" @endif >
						

							<div class="form-group">
							<div class="row">

							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Question Bank Subject</label>
							  <select class="form-control mb-3" name="subject_id" placeholder="subject" required>
								<option value="">select</option>
								@foreach($qbsub as $r)
									<option value="{{$r->id}}" @if($r->id==$qs->qbank_subject_id){{__('selected')}}@endif>{{$r->subject_name}}</option>
								@endforeach
							  </select>
							</div>
							</div>
							</div>
							
							@if($qs->question_type==1)
									<label>Question Image</label>
									<input type="file" class="form-control" placeholder="image" id="image_question" name="image_question" >
									Image: <a href="{{config('constants.image_question').$qs->question}}" target="_blank">{{$qs->question}}</a>
								@else
									<label>Question</label>
									<textarea class="form-control mb-3" placeholder="question" name="question" @if($qs->question_type==0){{ __('required')}}@endif>{{$qs->question}}</textarea>
								@endif
							
													
							<div class="form-group">
							<div class="row">
							<div class="col-lg-6 col-xl-6 col-xxl-6">
								<label>Answer-1</label>
								<input class="form-control mb-3" type="text" name="answer1" placeholder="Answer-1"  value="{{$qs->answer1}}"required>
							</div>
							<div class="col-lg-6 col-xl-6 col-xxl-6">
								<label>Answer-2</label>
								<input class="form-control mb-3" type="text" name="answer2" placeholder="Answer-2"  value="{{$qs->answer2}}" required>
							</div>
							</div>
							</div>
							
							<div class="form-group">
							<div class="row">
							<div class="col-lg-6 col-xl-6 col-xxl-6">
								<label>Answer-3</label>
								<input class="form-control mb-3" type="text" name="answer3" placeholder="Answer-3"  value="{{$qs->answer3}}" required>
							</div>
							<div class="col-lg-6 col-xl-6 col-xxl-6">
								<label>Answer-4</label>
								<input class="form-control mb-3" type="text" name="answer4"  placeholder="Answer-4"  value="{{$qs->answer4}}" required>
							</div>
							</div>
							</div>
							
							<div class="form-group">
							<div class="row">
							<div class="col-lg-4 col-xl-4 col-xxl-4">
								<label>Correct Answer</label>
								<select class="form-control mb-3" name="currect_answer" required>
								<option value="">--select--</option>
								<option value="1" @if($qs->correct_answer==1){{__('selected')}}@endif>Answer-1</option>
								<option value="2" @if($qs->correct_answer==2){{__('selected')}}@endif>Answer-2</option>
								<option value="3" @if($qs->correct_answer==3){{__('selected')}}@endif>Answer-3</option>
								<option value="4" @if($qs->correct_answer==4){{__('selected')}}@endif>Answer-4</option>
								</select>
							</div>
							<div class="col-lg-8 col-xl-8 col-xxl-8 text-right">
							<label>&nbsp;&nbsp;&nbsp;</label>
							<div class="form-group ">
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
							</div>
							
							</div>
							</div>
						
							</form>

                    </div>
					<div class="col-lg-4 col-xl-4 col-xxl-4 ">
					@if($qs->question_type==1)
					  <img id="prev" src="{{config('constants.image_question').$qs->question}}" alt="Question image"  style="width:100%;"/>
					@endif
					</div>
					
                   </div><!--end row-->
                </div>
              </div>
	
		
@push('scripts')
<script>

image_question.onchange = evt => {
  const [file] = image_question.files
  if (file) {
    prev.src = URL.createObjectURL(file)
	$("#prev").css('display','block');
  }
  
  
}

$("#question").prop('required',false);

var mes=$('#view_message').val().split('#');

if(mes[0]=="success")
{	
	toastr.success(mes[1]);
}
else if(mes[0]=="danger")
{
	toastr.error(mes[1]);
}

$(".quest_option").change(function()
{
	
	$("#fSet").prop('disabled',false);
	
	var vl=parseInt($('input[name="quest_option"]:checked').val());
	if(vl==1)
	{
		$("#quest").removeClass('show').addClass('hide');
		
		$("#img_quest").removeClass('hide').addClass('show');
		$("#image_question").prop('required',true).val('');
		$("#question").prop('required',false);
	}
	else
	{
		$("#img_quest").removeClass('show').addClass('hide');
		$("#quest").removeClass('hide').addClass('show');
		
		$("#image_question").prop('required',false).val('');
		$("#question").prop('required',true);
		$("#prev").css('display','none');
	}

});

//---------------------------------------------------------------------------
	

</script>
@endpush
@endsection
