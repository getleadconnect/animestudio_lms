<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
  <!-- Bootstrap CSS -->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/bootstrap-extended.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  <!-- loader-->
  <link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/plugins/toastr/css/toastr.min.css')}}" rel="stylesheet" />
	

  <title>AIM-Balussery</title>
</head>
<style>
.c-para
{
	padding-left:35px;
	margin:3px;
}
</style>
<body class="bg-surface">

  <!--start wrapper-->
  <div class="wrapper">

       <header>
          <nav class="navbar navbar-expand-lg navbar-light bg-white rounded-0 border-bottom">
            <div class="container">
              <a class="navbar-brand" href="#" style="margin-right:50px;">
			  <!--<img src="{{asset('assets/images/brand-logo-2.png')}}" width="140" alt=""/>-->
			  <h4>AIM</h4>
			  </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">
				
                <!--<li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                 </li> -->
				  
                 <!-- <li class="nav-item">
                    <a class="nav-link" href="javascript:;">About Us</a>
                  </li> -->
				  
				   <li class="nav-item">
                    <a class="nav-link" href="{{url('privacy-policy')}}">Privacy</a>
                  </li>
				  
				   <li class="nav-item">
                    <a class="nav-link" href="{{url('terms')}}">Terms & Conditions</a>
                  </li>
				  
				   <li class="nav-item">
                    <a class="nav-link" href="{{url('delete-account')}}">Delete Account</a>
                  </li>
				  
                  <!--<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                       Services <i class="bi bi-chevron-down align-middle ms-2"></i>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li> -->
				  
                  <li class="nav-item">
                    <a class="nav-link" href="javascript:;"  style="color:blue;"><u>Contact Us</u></a>
                  </li>
                </ul>

              </div>
            </div>
          </nav>
       </header>
	   
    
       <!--start content-->
       <main class="authentication-content">
        <div class="container">
          <div class="mt-4">
            <div class="card rounded-0 overflow-hidden shadow-none border mb-5 mb-lg-0">
              <div class="row g-0">
                <!--<div class="col-12 order-1 col-xl-4 d-flex align-items-center justify-content-center border-end">
                  <img src="{{asset('assets/images/error/auth-img-7.png')}}" class="img-fluid" alt="">
				  <img src="{{asset('assets/images/privacy.jpg')}}" class="img-fluid" alt="">
                </div>-->
                <div class="col-12 col-xl-12 order-xl-2">
                  <div class="card-body p-4 p-sm-5">
                    
					<h4 class="card-title" style="text-align:center;"><u>CONTACT US</u></h4>
					
                    <!--<p class="card-text mb-4">See your growth and get consulting support!</p> -->


					<div class="row g-3 mt-5">
					<div class="col-1"></div>
					<div class="col-lg-5 col-xl-5 col-xxl-5">
					<h4> <i class="lni lni-map-marker"></i> Address</h4>
					<p class="c-para">Aim-PSC</p>
					<p class="c-para">Balussery</p>
					<p class="c-para">Kozhikode(dt), Kerala, India</p>
					</div>
					
					<div class="col-lg-5 col-xl-5 col-xxl-5">
					<p style="display-flex;align-items:center;"><i class="lni lni-mobile fs-5" ></i> +91 1234567890</p>
					<p style="display-flex;align-items:center;" > <i class="lni lni-envelope fs-5" ></i> aimappbalussery@gmail.com</p>
					</div>
					<div class="col-1"></div>

					</div>
					
					

				<h3 class="card-title  mt-5" style="text-align:center;">GET IN TOUCH</h3>


					 <div class="row g-3 mt-1">
					 <div class="col-1"></div>
					 <div class="col-10" style="background:#e4e4e4;padding:20px;">
					 
						<div>
						
						
						<form id="saveContactUsMessage">
						@csrf
						
						<div class="row">
                          <div class="col-lg-4 col-xl-4 col-xxl-4 mt-2">
                            <label for="inputEmailAddress" class="form-label" >Name</label>
                            <div class="ms-auto position-relative">
                              <input type="text" class="form-control radius-30 ps-5" name="name" id="inputName" placeholder="Name" required>
                            </div>
                          </div>
						  <div class="col-lg-4 col-xl-4 col-xxl-4 mt-2">
                            <label for="inputChoosePassword" class="form-label" >Mobile</label>
                            <div class="ms-auto position-relative">
                              <input type="number" class="form-control radius-30 ps-5" name="mobile"  id="inputMobile" placeholder="Mobile" required>
                            </div>
                          </div>
                          <div class="col-lg-4 col-xl-4 col-xxl-4 mt-2">
                            <label for="inputChoosePassword" class="form-label" >Email</label>
                            <div class="ms-auto position-relative">
                              <input type="email" class="form-control radius-30 ps-5" name="email"  id="inputEmail" placeholder="Email" required>
                            </div>
                          </div>
						  </div>
						  
						<div class="row mb-5">
						  <div class="col-12 mt-2">
                            <label for="inputChoosePassword" class="form-label">Message</label>
                            <div class="ms-auto position-relative">
                              <textarea class="form-control radius-30 ps-5" id="inputMessage" name="message"  placeholder="message" required></textarea>
                            </div>
                          </div>
						  
						  <div class="col-12">
                            <div class="d-grid mt-3">
                              <button type="submit" class="btn btn-primary radius-30">Submit</button>
                            </div>
                          </div>
						</div>
						
						</form>
						
						</div>
						
						</div>
						<div class="col-1"></div>
                 </div>
				 
                </div>
              </div>
            </div>
          </div>
        </div>
		</div>
       </main>
        
       <!--end page main-->

       <footer class="bg-white border-top p-3 text-center fixed-bottom">
        <p class="mb-0">Copyright © Aim-Balussery,2021. All right reserved.</p>
      </footer>

</div>

  <!--end wrapper-->


  <!-- Bootstrap bundle JS -->
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

  <!--plugins-->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/pace.min.js')}}"></script>
  <script src="{{asset('assets/plugins/toastr/js/toastr.min.js')}}"></script>
<script>


$("form#saveContactUsMessage").submit(function(e)
{
   e.preventDefault(); 
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('save-contact-us-message')}}",
          type: 'post',
          data: formData,
		  dataType:'json',
          success: function (res) 
		  {
			 if(res.status==true)
			 {
				toastr.success(res.msg);
				$("#inputName").val('');
				$("#inputMobile").val('');
				$("#inputEmail").val('');
				$("#inputMessage").val('');
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


</body>

</html>