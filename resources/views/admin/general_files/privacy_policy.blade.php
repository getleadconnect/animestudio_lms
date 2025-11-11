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

  <title>AnimeStudio</title>
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
                    <a class="nav-link" href="javascript:;" style="color:blue;"><u>Privacy</u></a>
                  </li>
				  
				   <li class="nav-item">
                    <a class="nav-link" href="{{url('terms')}}">Terms & Conditions</a>
                  </li>
				  
				   <li class="nav-item">
                    <a class="nav-link" href="{{url('delete-account')}}" >Delete Account</a>
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
                  <!--<li class="nav-item">
                    <a class="nav-link" href="{{url('contact')}}">Contact Us</a>
                  </li> -->
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
					 
					 {!! $privacy->policy !!}
					 
					 </div></div>

                 </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       </main>
        
       <!--end page main-->

       <footer class="bg-white border-top p-3 text-center fixed-bottom">
        <p class="mb-0">Copyright © AnimeStudio, 2025. All right reserved.</p>
      </footer>

  </div>
  <!--end wrapper-->


  <!-- Bootstrap bundle JS -->
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

  <!--plugins-->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/pace.min.js')}}"></script>


</body>

</html>