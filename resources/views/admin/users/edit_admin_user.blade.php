
	<form Method="POST" action="{{url('update-admin-user')}}" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden" name="admin_id" value="{{$au->id}}">

	<div class="form-group">
	<label>Name</label>
	<input class="form-control mb-3" type="text" name="name_edit" placeholder="Name" value="{{$au->name}}" required>
	</div>

	<div class="form-group">
	<label>Email</label>
	<input class="form-control mb-3" type="email" name="email_edit" placeholder="email" value="{{$au->email}}" required>
	</div>

	<div class="form-group">
	<label>Mobile</label>
	<input class="form-control mb-3" type="number" name="mobile_edit" placeholder="mobile" value="{{$au->mobile}}"  required>
	</div>
	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label>Select Role</label>
	<select name="role_id_edit" class="form-control mb-3" required>
	<option value="">--select--</option>
	@foreach($rol as $r)
	<option value="{{$r->id}}" @if($r->id==$au->role_id){{__('selected')}}@endif>{{$r->role}}</option>
	@endforeach
	</select>
	</div>
	
	@if(Session::get('admin_role_id')==1)
	<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label>Password</label>
	<input class="form-control mb-3" type="text" name="password_edit" placeholder="password">
	</div>
	@endif
	</div>
	</div>
	

	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
	</form>
	
						