	<form  id="editQuestion" >
		@csrf
		<input type="hidden" name="question_id" value="{{$qq->id}}">
		
		<div class="form-group">
		<div class="row">
		<div class="col-lg-6 col-xl-6 col-xxl-6">
		<label>Subjects</label>
		  <select class="form-control mb-3" name="subject_id_edit" placeholder="subject" required>
			<option value="">select</option>
			@foreach($qbsub as $r)
			<option value="{{$r->id}}" @if($r->id==$qq->qbank_subject_id){{__('selected')}}@endif>{{$r->subject_name}}</option>
			@endforeach
		  </select>
		</div>
		</div>
		</div>

		<div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
			<label>Question</label>
			<textarea class="form-control mb-3" name="question_edit" placeholder="question" required>{{$qq->question}}</textarea>
		</div>
		</div>
		</div>
		
	
		<div class="form-group">
		<div class="row">
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			<label>Answer-1</label>
			<input class="form-control mb-3" type="text" name="answer1_edit" placeholder="Answer-1" value="{{$qq->answer1}}" required>
			</div>
		
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			<label>Answer-2</label>
			<input class="form-control mb-3" type="text" name="answer2_edit" placeholder="Answer-2"  value="{{$qq->answer2}}" required>
			</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			<label>Answer-3</label>
			<input class="form-control mb-3" type="text" name="answer3_edit" placeholder="Answer-3"  value="{{$qq->answer3}}" required>
			</div>
		
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			<label>Answer-4</label>
			<input class="form-control mb-3" type="text" name="answer4_edit"  placeholder="Answer-4"  value="{{$qq->answer4}}" required>
			</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			<label>Correct Answer</label>
			<select class="form-control mb-3" name="currect_answer_edit" required>
			<option value="">--select--</option>
			<option value="1" @if($qq->correct_answer==1){{__('selected')}}@endif>Answer-1</option>
			<option value="2" @if($qq->correct_answer==2){{__('selected')}}@endif>Answer-2</option>
			<option value="3" @if($qq->correct_answer==3){{__('selected')}}@endif>Answer-3</option>
			<option value="4" @if($qq->correct_answer==4){{__('selected')}}@endif>Answer-4</option>
			</select>
			</div>
		</div>
		</div>

		
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Save changes</button>
		</div>
		</form>
<script>

$("form#editQuestion").submit(function(e)
{
   e.preventDefault(); 
   
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('update-qbank-question')}}",
          type: 'post',
          data: formData,
		  dataType:'json',
          success: function (res) 
		  {
			 if(res.status==true)
			 {
				$('#BasicModal2').modal('hide');
				toastr.success(res.msg);
				$('#datatable').DataTable().ajax.reload(null, false);
				$('#editQuestion')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				$('#editQuestion')[0].reset();
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
});

</script>