<form id="renewSubscription" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="subscription_id" value="{{$dat->id}}" required>
	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-7 col-xl-7 col-xxl-7">
	<label>Student Name</label>
	<input class="form-control mb-3" type="text" name="student_name" value="{{$dat->student_name}}" readonly>
	</div>
	
	<div class="col-lg-5 col-xl-5 col-xxl-5">
	<label>Mobile</label>
	<input class="form-control mb-3" type="text" name="mobile" value="{{$dat->mobile}}" readonly>
	</div>
	</div>
	</div>
		
	<div class="form-group">
	<div class="row">
	<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label>Start Date</label>
	<input class="form-control mb-3" type="date" name="start_date" value="{{$dat->start_date}}" readonly>
	</div>
	<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label>End Date</label>
	<input class="form-control mb-3" type="date" name="end_date" value="{{$dat->end_date}}" readonly>
	</div>
	</div>
	</div>

<fieldset style="border:1px solid #e4e4e4;padding:10px;background:#e4e4e4;">
<legend style="font-size:14px;color:blue;">Enter New Period</legend>

	<div class="form-group">
	<div class="row">
	<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label>Start Date</label>
	<input class="form-control mb-3" type="date" name="start_date_new" value="{{date('Y-m-d')}}" required>
	</div>
	<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label>End Date</label>
	<input class="form-control mb-3" type="date" name="end_date_new" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
	</div>
	</div>
	</div>
</fieldset>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
	
</form>


<script>


$("form#renewSubscription").submit(function(e)
{
   e.preventDefault(); 
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('update-subscription-period')}}",
          type: 'post',
          data: formData,
		  dataType:'json',
          success: function (res) 
		  {
			 if(res.status==true)
			 {
				$('#BasicModal1').modal('hide');
				toastr.success(res.msg);
				$('#datatable').DataTable().ajax.reload(null, false);
				$('#renewSubscription')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				//$('#renewSubscription')[0].reset();
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
});
</script>
