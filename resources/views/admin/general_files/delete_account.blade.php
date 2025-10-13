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
  <style>
    .warning-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .warning-box h5 {
        color: #856404;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .warning-box ul {
        margin-bottom: 0;
        padding-left: 20px;
    }

    .warning-box li {
        color: #856404;
        margin-bottom: 8px;
    }

    </style>
</head>

<body class="bg-surface">

  <!--start wrapper-->
  <div class="wrapper">

       <header>
          <nav class="navbar navbar-expand-lg navbar-light bg-white rounded-0 border-bottom">
            <div class="container">
              <a class="navbar-brand" href="#">
			          <img src="{{asset('assets/images/avatars/animestudio-logo-white.png')}}" width="70" alt="" style="background-color:#666363;"/>
			          <h4 style="float:right;margin-top:19px;">&nbsp;AnimeStudio</h4>
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
                    <a class="nav-link" href="javascript:;" style="color:blue;"><u>Delete Account</u></a>
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
                    <a class="nav-link" href="{{url('contact')}}">Contact Us</a>
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
                    
					<!--<h5 class="card-title">Privacy Policy</h5>
                    <p class="card-text mb-4">See your growth and get consulting support!</p> -->

					 <div class="row g-3">
					 <div class="col-12">
            					 
						<h3 class="mb-3">Delete User Account</h3>

                    <div class="warning-box">
                        <h5><i class="fas fa-exclamation-circle"></i> Important Notice</h5>
                        <ul>
                            <li>Once your account is deleted, all your data will be permanently removed.</li>
                            <li>You will lose access to all your enrolled courses and course materials.</li>
                            <li>Your test results and progress will be deleted.</li>
                            <li>This action cannot be undone after admin approval.</li>
                            <li>Admin will review your request and process it accordingly.</li>
                        </ul>
                    </div>

						<p class="text-center">To delete your app account, please fill the following details and send. </p>
						<p class="text-center">We will check your account and delete with in 24 hrs. Thank You. </p>
												
						<div class="row g-3 mb-5">
						<div class="col-12" style="margin:12px auto">

           <div class="card rounded-0 overflow-hidden shadow-none border mb-5 mb-lg-0" style="width:650px; margin:20px auto;">
           <div class="card-body p-4 p-sm-5">
            <div class="container">
             					
						      <form id="sendMessage">
						          @csrf
						
						            <div class="row">
                          <div class="col-12 col-md-12 mt-2">
                            <label for="inputEmailAddress" class="form-label" >Name</label>
                            <div class="ms-auto position-relative">
                              <input type="text" class="form-control radius-30 ps-5" name="name" id="inputName" placeholder="Name" required>
                            </div>
                          </div>

                          <div class="col-12 col-md-12 mt-2">
                            <label for="inputChoosePassword" class="form-label" >Registred Mobile</label>
                            <div class="ms-auto position-relative">
                              <input type="number" class="form-control radius-30 ps-5" name="mobile"  id="inputMobile" placeholder="Mobile" required>
                            </div>
                          </div>
						
						             <div class="col-12  col-md-12 mt-2">
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
						</div>
						</div>
					 </div>

          </div>
  
                 </div>
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


$("form#sendMessage").submit(function(e)
{
   e.preventDefault(); 
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('save-delete-account-request')}}",
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