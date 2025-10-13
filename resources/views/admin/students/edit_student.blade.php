<form id="editStudent" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden" name="student_id" value="{{$st->id}}">
	
	<div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Name</label>
		<input class="form-control mb-3" type="text" name="student_name_edit" placeholder="Name"  value="{{$st->student_name}}" required>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<div class="col-lg-6 col-xl-6 col-xxl-6">
		<label>Date Of birth</label>
		<input class="form-control mb-3" type="date" name="dob_edit" placeholder="Date of birth" value="{{$st->date_of_birth}}" required>
		</div>
		<div class="col-lg-6 col-xl-6 col-xxl-6">
		<label>Mobile</label>
		<input class="form-control mb-3" type="number" name="mobile_edit" placeholder="mobile" value="{{$st->mobile}}" required>
		</div>
		
		</div>
	</div>
	
	 <div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Email</label>
		<input class="form-control mb-3" type="email" name="email_edit" placeholder="email" value="{{ $st->email}}" required>
		</div>
		</div>
	  </div>
	
	<div class="form-group">
		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>District</label>
		<select class="form-control mb-3" id="district_edit" name="district_edit" placeholder="district" required>
			<option value="">select</option>
			@foreach($dist as $r)
			 <option value="{{$r->id}}" @if(strtoupper($r->id)==strtoupper($st->district_id)){{__('selected')}}@endif>{{$r->district}}</option>
			@endforeach
		</select>
		</div>
	</div>
	</div>
		
	<div class="form-group">
	<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
		<label>Place</label>
		<input class="form-control mb-3" type="text" name="place_edit" placeholder="Place" value="{{$st->place}}" required>
		</div>
		</div>
	</div>	

	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Update changes</button>
	</div>
	</form>
	
<script>
   
$("form#editStudent").submit(function(e)
{
   e.preventDefault(); 
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('update-student')}}",
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
				$('#editStudent')[0].reset();
			  }
			  else
			 {
				toastr.error(res.msg); 
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
});


</script>