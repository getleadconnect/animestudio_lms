<form method="POST" action="{{url('update-center')}}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="center_id" value="{{$ce->id}}" required>
	
	<div class="form-group">
	<label>Center Name</label>
	<input class="form-control mb-3" type="text" placeholder="Center name" name="center_name_edit" value="{{$ce->center_name}}" required>
	</div>
	
	<div class="form-group">
	<label>Address</label>
	<textarea class="form-control mb-3" placeholder="Address" name="address_edit" required>{{$ce->address}}</textarea>
	</div>
	
	<div class="form-group">
	<label>Email</label>
	<input class="form-control mb-3" type="text" placeholder="Email" name="email_edit" value="{{$ce->email}}" required>
	</div>
	
	<div class="form-group">
	<label>Mobile</label>
	<input class="form-control mb-3" type="text" placeholder="Mobile" name="mobile_edit" value="{{$ce->mobile}}" required>
	</div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
	
</form>


<script>

$("form#centerForm").submit(function(e)
{
   e.preventDefault();    

       $.ajax({
          url: "{{url('update-center')}}",
          type: 'POST',
          data: new FormData(this),
		  dataType:'json',
		  success: function (res) 
		  {
			if(res.status=="true")
			{
				$('#table-center').DataTable().ajax.reload(null, false);
				toastr.success(res.msg);
			}
			else
			{
				toastr.success(res.msg);
			}
          },
			cache: false,
			contentType: false,
			processData: false
		});
});

</script>
