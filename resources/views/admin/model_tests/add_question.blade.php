@extends('admin.layouts.master')
@section('title','Dashboard')
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
              <div class="breadcrumb-title pe-3">Add Question(Text/Image)</div>
 
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
                   <a href="{{route('view-questions')}}" class="btn btn-primary btn-xs btn-sm"><i class="fa fa-plus"></i>&nbsp;View Questions</a>
				  </div>

				  </div>
                </div>
                <div class="card-body">

                   <div class="row mt-2">
                     <div class="col-8 col-lg-8 col-xxl-8col-xl-8">
							<form  method="POST" action="{{route('save-question')}}" enctype="multipart/form-data" >
							@csrf
							
							<div class="form-group">
								<label> Select Option</label>
								
								<div class="row mt-2 mb-3">
								
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="form-check">
										<input class="form-check-input quest_option opt-radio" type="radio" name="quest_option" value="1" required>
										<label class="form-check-label" for="free_test_edit1" style="font-weight:500;">&nbsp;&nbsp;IMAGE QUESTION</label>
									</div>
								</div>
								<div class="col-lg-4 col-xl-4 col-xxl-4 ">
									<div class="form-check">
										<input class="form-check-input quest_option opt-radio" type="radio" name="quest_option" value="0" required>
										<label class="form-check-label" for="free_test_edit2" style="font-weight:500;">&nbsp;&nbsp;TEXT QUESTION</label>
									</div>
								</div>
								
								</div>
								</div>
								
							<fieldset id="fSet" disabled>
							
							<div class="form-group">
							<div class="row">
							<div class="col-lg-4 col-xl-4 col-xxl-4">
							<label>Course</label>
							  <select class="form-control mb-3" id="course_id" name="course_id" placeholder="course" required>
								<option value="">select</option>
								@foreach($crs as $r)
									<option value="{{$r->id}}" >{{$r->course_name}}</option>
								@endforeach
							  </select>
							 </div>
							<div class="col-lg-4 col-xl-4 col-xxl-4">
							<label>Question Paper</label>
							  <select class="form-control mb-3" id="qpaper_id" name="qpaper_id" placeholder="question paper" required>
							     <option value="">select</option>
							  </select>
							</div>
							<div class="col-lg-4 col-xl-4 col-xxl-4">
							<label>Question Bank Subject</label>
							  <select class="form-control mb-3" name="subject_id" placeholder="subject" required>
								<option value="">select</option>
								@foreach($qsubj as $r)
									<option value="{{$r->id}}" >{{$r->subject_name}}</option>
								@endforeach
							  </select>
							</div>
							</div>
							</div>

							<div class="form-group hide" id="quest"  style="width:100%;">
								<label>Question</label>
								<textarea class="form-control mb-3" id="question" name="question" placeholder="question"  required></textarea>
							</div>
							
							<div class="form-group show" id="img_quest"  style="width:100%;">
								<label>Question Image (Width:300px)</label>
								<input class="form-control mb-3" type="file" id="image_question" name="image_question" placeholder="image question"  required>
							</div>
								
													
							<div class="form-group">
							<div class="row">
							<div class="col-lg-6 col-xl-6 col-xxl-6">
								<label>Answer-1</label>
								<input class="form-control mb-3" type="text" name="answer1" placeholder="Answer-1"  required>
							</div>
							<div class="col-lg-6 col-xl-6 col-xxl-6">
								<label>Answer-2</label>
								<input class="form-control mb-3" type="text" name="answer2" placeholder="Answer-2"  required>
							</div>
							</div>
							</div>
							
							<div class="form-group">
							<div class="row">
							<div class="col-lg-6 col-xl-6 col-xxl-6">
								<label>Answer-3</label>
								<input class="form-control mb-3" type="text" name="answer3" placeholder="Answer-3"  required>
							</div>
							<div class="col-lg-6 col-xl-6 col-xxl-6">
								<label>Answer-4</label>
								<input class="form-control mb-3" type="text" name="answer4"  placeholder="Answer-4"  required>
							</div>
							</div>
							</div>
							
							<div class="form-group">
							<div class="row">
							<div class="col-lg-4 col-xl-4 col-xxl-4">
								<label>Correct Answer</label>
								<select class="form-control mb-3" name="correct_answer" required>
								<option value="">--select--</option>
								<option value="1">Answer-1</option>
								<option value="2">Answer-2</option>
								<option value="3">Answer-3</option>
								<option value="4">Answer-4</option>
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
							</fieldset>
													
							
							</form>

                    </div>
					<div class="col-lg-4 col-xl-4 col-xxl-4 ">
						<img id="prev" src="#" alt="Question image"  style="display:none; width:100%;"/>
					</div>
					
                   </div><!--end row-->
                </div>
              </div>
			  
	
	<div class="modal fade" id="BasicModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
				
			
				
				</div>
			</div>
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

$("#prev").css('display','none');
$("#image_question").prop('required',true);
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

//---------------------------------------------------------------------------
	

</script>
@endpush
@endsection
