<form Method="POST" action="{{url('update-staff')}}" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden" name="staff_id" value="{{$st->id}}">
	
	<div class="form-group">
	<label>Center</label>
	<select class="form-control mb-3" name="center_id_edit" required>
	<option value="">select</option>
		@foreach($center as $r)
			<option value="{{$r->id}}"@if($r->id==$st->center_id){{__('selected')}}@endif>{{$r->center_name}}</option>
		@endforeach
	</select>
	</div>
	
	<div class="form-group">
	<label>Name</label>
	<input class="form-control mb-3" type="text" name="staff_name_edit" placeholder="Name"  value="{{$st->staff_name}}" required>
	</div>
	<div class="form-group">
	<label>Address</label>
	<textarea class="form-control mb-3" name="address_edit" placeholder="Name" required>{{$st->staff_name}}</textarea>
	</div>
	
	<div class="form-group">
	<label>Email</label>
	<input class="form-control mb-3" type="email" name="email_edit" placeholder="email" value="{{$st->email}}" required>
	</div>
	
	<div class="form-group">
	<label>Mobile</label>
	<input class="form-control mb-3" type="number" name="mobile_edit" placeholder="mobile" value="{{$st->mobile}}" required>
	</div>
	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label>Reff.Code</label>
	<input class="form-control mb-3" type="text" name="ref_code_edit" placeholder="Code" value="{{$st->referral_code}}" required>
	</div>
	
	<div class="col-lg-3 col-xl-3 col-xxl-3">
	<label>Percentage(%)</label>
	<input class="form-control mb-3" type="number" name="percentage_edit" placeholder="percentage" value="{{$st->percentage}}" required>
	</div>
	</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
	</form>