<form id="updateTabHeading">
@csrf
<input text="hidden" name="tab_head_id" value="{{$eth->id}}">

<div class="form-group">
		<label>Course</label>
		<select class="form-control mb-3" name="course_id_edit" placeholder="course" required>
		<option value="">select</option>
		@foreach($crs as $r)
		<option value="{{$r->id}}" @if($r->id==$eth->course_id){{__('selected')}}@endif>{{$r->course_name}}</option>
		@endforeach
		</select>
	</div>

<div class="form-group">
<div class="row">
<div class="col-lg-12 col-xl-12 col-xxl-12">
<label>Tab Heading</label>
<input class="form-control mb-3" type="text" name="tab_heading_edit" placeholder="Tab headings" value="{{$eth->tab_heading}}" required>
</div>
</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>

<script>
$("form#updateTabHeading").submit(function(e)
{
   e.preventDefault();
   
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('update-tab-heading')}}",
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
				$('#updateTbHeading')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				$('#updateTabHeading')[0].reset();
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
});

</script>