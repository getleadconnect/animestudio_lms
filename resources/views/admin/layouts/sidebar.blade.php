 <!--start sidebar -->
        <aside class="sidebar-wrapper" data-simplebar="true">
          <div class="sidebar-header">
            <div>
             <img src="{{asset('assets/images/avatars/animestudio-logo-white.png')}}" class="logo-icon" alt="logo icon" style="background-color:#666363;">
            </div>
            <div>
              <h4 class="logo-text" style="font-size:20px;" >AnimeStudio</h4>
            </div>
            <div class="toggle-icon ms-auto"><i class="bi bi-list"></i>
            </div>
          </div>
          <!--navigation-->
          <ul class="metismenu" id="menu">
		  
			<li>
              <a href="{{url('dashboard')}}">
                <div class="parent-icon"><i class="bi bi-house-fill"></i>
                </div>
                <div class="menu-title">Dashboard</div>
              </a>
            </li>

            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-agenda"></i>
                </div>
                <div class="menu-title">Master</div>
              </a>
              <ul>
			   <li> <a href="{{url('splash-slides')}}"><i class="bi bi-circle"></i>Splash Slides</a>
                </li>
				<li> <a href="{{url('banners')}}"><i class="bi bi-circle"></i>Banners</a>
                </li>
                <li> <a href="{{url('centers')}}"><i class="bi bi-circle"></i>Centers</a>
                </li>
				 <li> <a href="{{url('course_category')}}"><i class="bi bi-circle"></i>Course Category</a>
                </li>
				 <li> <a href="{{url('admin/courses')}}"><i class="bi bi-circle"></i>Courses</a>
                </li>
				 <li> <a href="{{url('add-course')}}"><i class="bi bi-circle"></i>Add Courses</a>
                </li>
				 <li> <a href="{{url('easy-tips')}}"><i class="bi bi-circle"></i>Easy Tips</a>
                </li>
				 <!--<li> <a href="{{url('latest-batches')}}"><i class="bi bi-circle"></i>Latest Batches</a>
                </li> -->
				
                <li> <a href="{{url('subjects')}}"><i class="bi bi-circle"></i>Subjects</a>
                </li>
                <li> <a href="{{url('chapters')}}"><i class="bi bi-circle"></i>Chapters</a>
                </li>
                
              </ul>
            </li>
			
			<li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-person-lines-fill"></i>
                </div>
                <div class="menu-title">Students</div>
              </a>
              <ul>
                <li> <a href="{{url('students')}}"><i class="bi bi-circle"></i>Students</a>
                </li>
				 <!--<li> <a href="{{url('add-students')}}"><i class="bi bi-circle"></i>Add Students</a>
                </li>-->
                <li> <a href="{{url('subscriptions')}}"><i class="bi bi-circle"></i>Subscriptions</a>
                </li>
				
				 <li> <a href="{{url('activity')}}"><i class="bi bi-circle"></i>Activities</a>
                </li>
                
              </ul>
            </li>
			
						
			<li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-link-external"></i>
                </div>
                <div class="menu-title">Live Class</div>
              </a>
              <ul>
			  
				<li> <a href="{{url('live-classes')}}"><i class="bi bi-circle"></i>Live Class</a>
                </li>
				<li> <a href="{{url('recorded-live-classes')}}"><i class="bi bi-circle"></i>Recorded Live Class</a>
				</li>
				<li> <a href="{{url('recorded-video-comments')}}"><i class="bi bi-circle"></i>Recorded Class Comments</a>
				</li>
              </ul>
            </li>
				
			
            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-movie"></i>
                </div>
                <div class="menu-title">Videos</div>
              </a>
              <ul>
                <li> <a href="{{url('videos')}}"><i class="bi bi-circle"></i>Videos</a>
                </li>
                <li> <a href="{{url('add-videos')}}"><i class="bi bi-circle"></i>Add Videos</a>
                </li>
                 <li> <a href="{{url('view-comments')}}"><i class="bi bi-circle"></i>View Comments</a>
                </li>
				
              </ul>
            </li>
			
			<li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-note"></i>
                </div>
                <div class="menu-title">PDF Notes</div>
              </a>
              <ul>
                <li> <a href="{{url('pdf-files')}}"><i class="bi bi-circle"></i>PDF Files</a>
                </li>
                <li> <a href="{{url('add-pdf-file')}}"><i class="bi bi-circle"></i>Add Pdf files</a>
                </li>
                
              </ul>
            </li>
			
			<li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-collection"></i>
                </div>
                <div class="menu-title">Question Bank</div>
              </a>
              <ul>
			  
				<li> <a href="{{url('question-bank-subjects')}}"><i class="bi bi-circle"></i>Subjects</a>
                </li>
                <li> <a href="{{url('questions')}}"><i class="bi bi-circle"></i>Questions</a>
                </li>
				<li> <a href="{{url('import-qbank-questions')}}"><i class="bi bi-circle"></i>Import Questions</a>
                </li>

              </ul>
            </li>			
			
			<li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-edit"></i>
                </div>
                <div class="menu-title">Model Tests</div>
              </a>
              <ul>
			  
				<li> <a href="{{url('tab-headings')}}"><i class="bi bi-circle"></i>Tab Headings</a> </li>
				
				<li> <a href="{{url('question-papers')}}"><i class="bi bi-circle"></i>Question Papers</a> </li>
				
                <li> <a href="{{url('prepare-questions')}}"><i class="bi bi-circle"></i>Prepare Questions</a></li>
				 
				<li> <a href="{{url('import-qpaper-questions')}}"><i class="bi bi-circle"></i>Import Qpaper Questions</a></li>
				
				<li> <a href="{{url('add-question')}}"><i class="bi bi-circle"></i>Add Image/Text Question</a></li>
				
				<li> <a href="{{url('pdf-questions')}}"><i class="bi bi-circle"></i>PDF Questions</a> </li>
				
				<li> <a href="{{url('view-questions')}}"><i class="bi bi-circle"></i>View Questions</a> </li>
                
              </ul>
            </li>
			
			<li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-spreadsheet"></i>
                </div>
                <div class="menu-title">Tests Results</div>
              </a>
              <ul>
			  
				<li> <a href="{{url('test-results')}}"><i class="bi bi-circle"></i>Test Results</a>
                </li>
				<li> <a href="{{url('rank-list')}}"><i class="bi bi-circle"></i>Rank List</a>
                </li>
              </ul>
            </li>
			
			<li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-person-lines-fill"></i>
                </div>
                <div class="menu-title">Staff</div>
              </a>
              <ul>
                <li> <a href="{{url('staffs')}}"><i class="bi bi-circle"></i>Staffs</a>
                </li>
                
              </ul>
            </li>
			
			
			<li>
              <a href="javascript:;" class="has-arrow">
                 <div class="parent-icon"><i class="bx bx-notification"></i>
                </div>
                <div class="menu-title">Notifications</div>
              </a>
              <ul>
			  
				<li> <a href="{{url('notifications')}}"><i class="bi bi-circle"></i>Notifications</a>
                </li>

              </ul>
            </li>
			
			<li class="">
              <a href="{{url('success-story')}}" aria-expanded="true">
                <div class="parent-icon"><i class="bx bx-movie"></i>
                </div>
                <div class="menu-title">Success Stories</div>
              </a>
            </li>
			
			
			<li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-person-lines-fill"></i>
                </div>
                <div class="menu-title">Reports</div>
              </a>
              <ul>
                <li> <a href="{{url('student-reports')}}"><i class="bi bi-circle"></i>Students List</a>
                </li>
				<li> <a href="{{url('subscription-reports')}}"><i class="bi bi-circle"></i>Subscriptions List</a>
                </li>
				                
              </ul>
            </li>
			
			<li class="">
              <a href="{{url('policy')}}" aria-expanded="true">
                <div class="parent-icon"><i class="bx bx-book-content"></i>
                </div>
                <div class="menu-title">Privacy Policy</div>
              </a>
            </li>
			
			
			<li>
              <a href="javascript:;" class="has-arrow">
                 <div class="parent-icon"><i class="bx bx-notification"></i>
                </div>
                <div class="menu-title">Users</div>
				</a>
              <ul>
			  
				<li> <a href="{{url('users')}}"><i class="bi bi-circle"></i>Student Users</a> </li>
				
				@if(Session::get('admin_role_id')==1)
				<li> <a href="{{url('admin-users')}}"><i class="bi bi-circle"></i>Admin Users</a></li>
				@endif
				
              </ul>
            </li>
			
			<li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-link-external"></i>
                </div>
                <div class="menu-title">General Options</div>
              </a>
              <ul>
			  
				<li> <a href="{{url('contact-us')}}"><i class="bi bi-circle"></i>Contact Us Messages</a>
                </li>
				<li> <a href="{{url('account-delete-requests')}}"><i class="bi bi-circle"></i>Account Delete Rquests</a>
				</li>
              </ul>
            </li>
				
			
			

          </ul>
          <!--end navigation-->
       </aside>
       <!--end sidebar -->
