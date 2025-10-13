@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')
<style>
.card-body{
	padding-top:2px !important;
}
.dropdown-toggle::after{ content:none !important; }
</style>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Edit Privacy</div>
 
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
				<div class="col-lg-6 col-xl-6 col-xxl-6 col-6">
                  <h6 class="mb-0 pt5">Edit</h6>
				  </div>
				  <div class="col-lg-6 col-xl-6 col-xxl-6 col-6 text-right">
				  <a href="{{url('policy')}}" type="button" class="btn btn-primary btn-xs btn-sm"><i class="fa fa-file"></i>&nbsp;Policy</a>
				  </div>

				  </div>
                </div>
                <div class="card-body">
					
                   <div class="row mt-2">
                     <div class="col-12 col-lg-12 ">
                      <div class="card  shadow-none w-100">
                        <div class="card-body">
						<form method="POST" action="{{url('update-policy')}}" enctype="multipart/form-data">
						@csrf
							<input type="hidden" name="policy_id" value="{{$ss->id}}">
							
							<div class="form-group">
							<div class="row">
							<div class="col-lg-12 col-xl-12 col-xxl-12">
							<label>Privacy Policy</label>
							<textarea id="privacy_policy" class="form-control mb-3" name="policy" placeholder="Enter data" required>{{$ss->policy}}</textarea>
							</div>
							</div>
							</div>
							<div class="form-group mt-3">
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
						</form>
						
						
                      </div>
                      </div> 
                    </div>
                   </div><!--end row-->
                </div>
              </div>
			  
		
@push('scripts')
<script>
$(document).ready(function()
{
 
	 $('#privacy_policy').summernote({
		  dialogsInBody: true,
          height: '500',
		   placeholder: 'Enter Details',
			tabsize: 2,
		  
          toolbar: [
			  ['fontname', ['fontname']],
              ['fontsize', ['fontsize']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['height', ['height']]
			  
			  ['style', ['style']],
			  ['font', ['bold', 'italic', 'underline','strikethrough', 'superscript', 'subscript', 'clear']],
			  
			  ['para', ['ul', 'ol', 'paragraph']],
			  ['table', ['table']],
			  ['insert', ['link', 'picture', 'hr']],
			  ['view', ['fullscreen', 'codeview']],
			  ['help', ['help']]
          ],
          disableDragAndDrop: true
      });
 
});
	
</script>
@endpush
@endsection
