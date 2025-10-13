<form id="editPdfQuestion"  enctype="multipart/form-data" >
@csrf

<input type="hidden" name="pdf_quest_id" value="{{$pq->id}}">
<input type="hidden" name="pdf_quest_file" value="{{$pq->pdf_question_file}}">

<div class="form-group">
<div class="row">
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	<label>Select Course</label>
		<select class="form-control mb-3" name="course_id_edit" placeholder="course" required>
		<option value="">select</option>
		@foreach($crs as $r)
			<option value="{{$r->id}}" @if($r->id==$pq->course_id){{__('selected')}}@endif>{{$r->course_name}}</option>
		@endforeach
		</select>
	</div>
	<div class="col-lg-4 col-xl-4 col-xxl-4">
	<label>Start Date</label>
	<input class="form-control mb-3" type="date" name="start_date_edit" placeholder="start_date" value="{{$pq->start_date}}" required>
	</div>
</div>
</div>
						
<div class="form-group">
	<div class="row">
	<div class="col-lg-12 col-xl-12 col-xxl-12">
	<label>Title</label>
	  <input class="form-control mb-3" type="text" name="title_edit" placeholder="title" value="{{$pq->title}}" required>
	</div>
	</div>
</div>
																		
<div class="form-group">
	<div class="row">
	<div class="col-lg-12 col-xl-12 col-xxl-12">
	<label>Questions(PDF) file</label>
	<input class="form-control" type="file" name="pdf_file_edit" placeholder="question pdf file" >
	<label>File: <a href="{{config('constants.pdf_question').$pq->pdf_question_file}}" target="_blank">{{$pq->pdf_question_file}}</a></label>
	</div>
	</div>
</div>

<div class="modal-footer mt-3">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	<button type="submit" class="btn btn-primary">Save changes</button>
</div>

</form>

<script>



$("form#editPdfQuestion").submit(function(e)
{
   e.preventDefault(); 
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('update-pdf-question')}}",
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
				$('#editPdfQuestion')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				$('#editPdfQuestion')[0].reset();
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
});


</script>
