<!doctype html>
<html lang="en" class="light-theme">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
  <!--plugins-->
  <link href="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"/>
  <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/plugins/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/plugins/toastr/css/toastr.min.css')}}" rel="stylesheet" />
  
  <link href="{{asset('assets/fontawesome-free-5.15-web/css/all.css')}}" rel="stylesheet" />
    
  <!-- Bootstrap CSS -->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/bootstrap-extended.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- loader-->
  <link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />

  <!--Theme Styles-->
  <link href="{{asset('assets/css/dark-theme.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/light-theme.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/semi-dark.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/header-colors.css')}}" rel="stylesheet" />
 
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

  <title>AnimeStudio</title>
</head>

<body class="pace-done">

  <!--start wrapper-->
  <div class="wrapper">
    <!--start top header-->
      <header class="top-header">        
        <nav class="navbar navbar-expand gap-3">
          <div class="mobile-toggle-icon fs-3 d-flex d-lg-none">
              <i class="bi bi-list"></i>
            </div>
			<h4>Administration</h4>
            <!--<form class="searchbar">
                <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>
                <input class="form-control" type="text" placeholder="Type here to search">
                <div class="position-absolute top-50 translate-middle-y search-close-icon"><i class="bi bi-x-lg"></i></div>
            </form> -->
            <div class="top-navbar-right ms-auto">
              <ul class="navbar-nav align-items-center gap-1">
			
              </ul>
              </div>
              <div class="dropdown dropdown-user-setting">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                  <div class="user-setting d-flex align-items-center gap-3">
                    <img src="{{asset('assets/images/avatars/animestudio-logo-white.png')}}" class="user-img" alt="" style="background-color:#666363;">
                    <div class="d-none d-sm-block">
                       <p class="user-name mb-0">AnimeStudio</p>
                      <small class="mb-0 dropdown-user-designation">{{Session::get('admin_name')}}</small>
                    </div>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                   
                    <li>
                      <a class="dropdown-item" href="javacript:void(0)" data-bs-toggle="modal" data-bs-target="#CPassModal">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bx bx-lock-open-alt"></i></div>
                           <div class="ms-3"><span>Change Password</span></div>
                         </div>
                       </a>
                    </li>
					
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a href="{{ route('admin.logout') }}"  class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form2').submit();">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bx bx-log-out"></i></div>
                           <div class="ms-3"><span>Logout</span></div>
                         </div>
                       </a>
					   
					   <form id="logout-form2" action="{{ route('admin.logout') }}" method="POST" class="d-none">
						@csrf
						</form>
                    </li>
                </ul>
              </div>
        </nav>
      </header>
       <!--end top header-->

       @include('admin.layouts.sidebar');
	   
       <!--start content-->
          <main class="page-content">
              
            @yield('contents')
			
          </main>
       <!--end page main-->

       <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
       <!--end overlay-->

       <!--start footer-->
       <footer class="footer">
        <div class="footer-text">
           Copyright ©Aim, Balussery 2024. All right reserved.
        </div>
        </footer>
        <!--end footer-->


			<div class="modal fade" id="CPassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<div class="modal-body">
						
						<form id="changePass" enctype="multipart/form-data">
						@csrf
						
						<input type="hidden" name="admin_id" value="{{Session::get('admin_id')}}">
						
						<div class="form-group">
							<div class="row">
							<div class="col-lg-12 col-xl-12 col-xxl-12">
							<label>New Password</label>
							<input class="form-control mb-3" type="text" name="new_pass" placeholder="new password" required>
							</div>
						</div>
						</div>
						
						<div class="form-group">
							<div class="row">
							<div class="col-lg-12 col-xl-12 col-xxl-12">
							<label>Confirm Password</label>
							<input class="form-control mb-3" type="text" name="confirm_pass" placeholder="confirm password" required>
							</div>
						</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Change</button>
						</div>
						</form>
						
						</div>
						
					</div>
				</div>
			</div>
  </div>
  
  <!--end wrapper-->


  <!-- Bootstrap bundle JS -->
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <!--plugins-->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
  <script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
  <script src="{{asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
  <script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
  <script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
  <script src="{{asset('assets/js/pace.min.js')}}"></script>
  <script src="{{asset('assets/plugins/chartjs/js/Chart.min.js')}}"></script>
  <script src="{{asset('assets/plugins/chartjs/js/Chart.extension.js')}}"></script>
  <script src="{{asset('assets/plugins/chartjs/js/chartjs-custom.js')}}"></script>
  
  <!--<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>-->
  <script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
  <script src="{{asset('assets/plugins/toastr/js/toastr.min.js')}}"></script>
  <script src="{{asset('assets/plugins/jquery-form/jquery.form.min.js')}}"></script>

	  <!--app-->
  <script src="{{asset('assets/js/app.js')}}"></script>
  <script src="{{asset('assets/js/index.js')}}"></script>
  
  <script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
  <script src="{{asset('assets/js/table-datatable.js')}}"></script>
  
  <!--<script src="assets/plugins/summernote/summernote-bs4.min.js"></script>-->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    
 <!--<script>
    new PerfectScrollbar(".best-product")
 </script>-->

@stack('scripts')
<script>
//
$("form#changePass").submit(function(e)
{
   e.preventDefault(); 

	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('change-password')}}",
          type: 'post',
          data: formData,
		  dataType:'json',
          success: function (res) 
		  {
			 if(res.status==true)
			 {
				$('#CPassModal').modal('hide');
				toastr.success(res.msg);
				$('#changePass')[0].reset();
			 }
			 else
			 {
				toastr.error(res.msg); 
				$('#changePass')[0].reset();
		     }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
});

</script>
</body>

</html>