<form method="post" action="{{url('update-notification')}}">
@csrf
<input type="hidden" name="notify_id" value="{{$nt->id}}">

	<div class="form-group">
	<div class="row">
		<div class="col-lg-6 col-xl-6 col-xxl-6">
		<label>Select Type</label>
		<select class="form-control mb-3" id="notification_type_edit" name="notification_type_edit" placeholder="type" required>
		<option value="">select</option>
		@foreach($ntype as $r)
			<option value="{{$r->id}}" @if($r->id==$nt->notification_type_id){{__('selected')}}@endif>{{$r->type_name}}</option>
			@endforeach
		</select>
		</div>
		
		<div class="col-lg-6 col-xl-6 col-xxl-6">
		<label>Select Course</label>
		<select class="form-control mb-3" id="course_id_edit" name="course_id_edit" placeholder="course" required>
		<option value="">select</option>
		@foreach($crs as $r)
			<option value="{{$r->id}}" @if($r->id==$nt->course_id){{__('selected')}}@endif>{{$r->course_name}}</option>
		@endforeach
		</select>
		</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-12 col-xl-12 col-xxl-12">
	<label>Notification Title</label>
	<input type="text" class="form-control mb-3" id="notification_title_edit" name="notification_title_edit" placeholder="Title" value="{{$nt->notification_title}}" required>
	</div>
	</div>
	</div>
						
	<div class="form-group">
	<div class="row">
	<div class="col-lg-12 col-xl-12 col-xxl-12">
	<label>Notification Message</label>
	<textarea class="form-control mb-3" id="message_edit" name="message_edit" placeholder="Message" required>{{$nt->message}}</textarea>
	</div>
	</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Update changes</button>
	</div>
	</form>
	
<script>

$(document).ready(function()
{
	var ntype=$("#notification_type_edit").val();
	check_type(ntype);
});

$("#notification_type_edit").change(function()
{
	var ntype=$(this).val();
	check_type(ntype);
	
});

function check_type(ntype)
{
	if(ntype==1)
	{
		$("#course_id_edit").prop('required',false)
		$("#course_id_edit").prop('disabled',true)
	}
	else
	{
		$("#course_id_edit").prop('required',true)
		$("#course_id_edit").prop('disabled',false)
	}
}
</script>