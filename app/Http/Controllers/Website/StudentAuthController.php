<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Subscription;
use App\Models\TestResult;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\PdfFile;
use App\Models\LiveClass;
use App\Models\RecordedLiveClass;
use App\Models\VideoCompletedStatus;
use App\Models\VideoComment;
use App\Models\Video;
use App\Models\SuccessStory;
use App\Models\EasyTips;
use Session;
use DB;

class StudentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('website.student.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $user = User::where('email', $request->email)
                    ->where('status', 1)
                    ->first();

 
        if ($user && Hash::check($request->password, $user->password)) {
            // Get student details
            $student = Student::find($user->student_id);
            if (!$student) {
                Session::flash('message', 'danger#Student profile not found.');
                return redirect()->back();
            }

            Auth::guard('student')->login($user);
            session(['student_details' => $student]);

            // Check if there's an intended purchase course
            if (session('intended_purchase_course')) {
                $courseId = session('intended_purchase_course');
                session()->forget('intended_purchase_course');
                Session::flash('message', 'success#Welcome back, ' . $student->student_name . '!');
                return redirect()->route('purchase-course', $courseId);
            }

            Session::flash('message', 'success#Welcome back, ' . $student->student_name . '!');
            return redirect()->route('student.dashboard');
        }

        Session::flash('message', 'danger#Invalid mobile number or password.');
        return redirect()->back()->withInput($request->except('password'));
    }

    public function dashboard()
    {
        $user = Auth::guard('student')->user();
        $student = session('student_details') ?? Student::find($user->student_id);

        // Fetch all active courses directly from courses table
        $activeCourses = Course::select('id', 'course_name', 'course_square_icon',
                                       'start_date', 'end_date', 'rate', 'discount_rate')
                              ->where('status', 1)
                              ->get();

        // Add days calculation for each course
        foreach ($activeCourses as $course) {
            $startDate = \Carbon\Carbon::parse($course->start_date);
            $endDate = \Carbon\Carbon::parse($course->end_date);
            $today = \Carbon\Carbon::now();

            // Calculate total days and remaining days
            $course->total_days = $startDate->diffInDays($endDate);

            if ($today->lt($startDate)) {
                // Course hasn't started yet
                $course->valid_status = 'Starts in ' . $today->diffInDays($startDate) . ' days';
                $course->valid_date = $startDate->format('d M Y');
            } elseif ($today->gt($endDate)) {
                // Course has ended
                $course->valid_status = 'Ended';
                $course->valid_date = $endDate->format('d M Y');
            } else {
                // Course is active
                $course->valid_status = $today->diffInDays($endDate) . ' days remaining';
                $course->valid_date = 'Valid till ' . $endDate->format('d M Y');
            }
        }

        // Use join query for user's subscriptions - get subscribed courses
        $myCourses = Subscription::select('subscriptions.*',
                                         'courses.course_name',
                                         'courses.course_details',
                                         'courses.course_wide_icon',
                                         'courses.course_square_icon',
                                         'courses.rate',
                                         'courses.discount_rate')
                                ->leftJoin('courses', 'subscriptions.course_id', '=', 'courses.id')
                                ->where('subscriptions.student_id', $user->student_id)
                                ->where('subscriptions.status', 1)
                                ->orderBy('subscriptions.created_at', 'desc')
                                ->get();

        // Add validity status for subscribed courses and prepare for sorting
        $today = \Carbon\Carbon::now();
        foreach ($myCourses as $course) {
            $endDate = \Carbon\Carbon::parse($course->end_date);

            if ($today->gt($endDate)) {
                $course->subscription_status = 'Expired';
                $course->status_color = 'danger';
                $course->is_expired = true;
            } else {
                $daysRemaining = $today->diffInDays($endDate);
                $course->subscription_status = $daysRemaining . ' days left';
                $course->status_color = 'success';
                $course->is_expired = false;
            }
            $course->valid_till = $endDate->format('d M Y');
        }

        // Sort courses: Active first, then expired
        $myCourses = $myCourses->sortBy(function ($course) {
            return $course->is_expired ? 1 : 0;
        })->values();

        $recentResults = TestResult::where('student_id', $user->student_id)
                                  ->orderBy('created_at', 'desc')
                                  ->limit(5)
                                  ->get();

        $totalCourses = Course::where('status',1)->count();
        $totalTests = TestResult::where('student_id', $user->student_id)->count();

        $avgScore = TestResult::where('student_id', $user->student_id)
                             ->selectRaw('AVG((score / (total_questions * marks)) * 100) as avg_percentage')
                             ->value('avg_percentage') ?? 0;

        // Get student's purchased course IDs
        $purchasedCourseIds = Subscription::where('student_id', $user->student_id)
                                          ->where('status', 1)
                                          ->pluck('course_id')
                                          ->toArray();

        // Get Live Classes based on purchased courses
        $liveClasses = LiveClass::select('live_classes.*', 'courses.course_name')
                                ->join('courses', 'live_classes.course_id', '=', 'courses.id')
                                ->whereIn('live_classes.course_id', $purchasedCourseIds)
                                ->where('live_classes.status', 1)
                                ->orderBy('live_classes.start_date', 'DESC')
                                ->orderBy('live_classes.start_time', 'DESC')
                                ->limit(5)
                                ->get();

        // Get Recorded Live Classes based on purchased courses
        $recordedClasses = RecordedLiveClass::select('recorded_live_classes.*', 'courses.course_name')
                                            ->join('courses', 'recorded_live_classes.course_id', '=', 'courses.id')
                                            ->whereIn('recorded_live_classes.course_id', $purchasedCourseIds)
                                            ->where('recorded_live_classes.status', 1)
                                            ->orderBy('recorded_live_classes.created_at', 'DESC')
                                            ->limit(5)
                                            ->get();

        // Get total mock tests available for student's purchased courses
        $totalMockTests = DB::table('qpaper_attended')
                            ->where('student_id', $user->student_id)
                            ->groupBy('student_id')
                            ->count();

        return view('website.student.dashboard', compact('student', 'activeCourses', 'myCourses',
                                                        'recentResults', 'totalCourses',
                                                        'totalTests', 'avgScore', 'liveClasses', 'recordedClasses',
                                                        'totalMockTests'));
    }

    public function profile()
    {
        $user = Auth::guard('student')->user();
        $student = session('student_details') ?? Student::find($user->student_id);
        return view('website.student.profile', compact('student', 'user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('student')->user();
        $student = Student::find($user->student_id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:50|unique:users,email,' . $user->id,
            'mobile' => 'required|digits:10|unique:users,mobile,' . $user->id,
            'date_of_birth' => 'nullable|date',
            'place' => 'nullable|string|max:50',
            'password' => 'nullable|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update user table
        $userUpdate = [
            'email' => $request->email,
            'mobile' => $request->mobile
        ];

        if ($request->filled('password')) {
            $userUpdate['password'] = Hash::make($request->password);
        }

        User::where('id', $user->id)->update($userUpdate);

        // Update student table
        Student::where('id', $student->id)->update([
            'student_name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'date_of_birth' => $request->date_of_birth,
            'place' => $request->place
        ]);

        // Update session data
        session(['student_details' => Student::find($student->id)]);

        Session::flash('message', 'success#Profile updated successfully!');
        return redirect()->back();
    }

    public function myCourses()
    {
        $user = Auth::guard('student')->user();

        // Use join query instead of relationship
        $subscriptions = Subscription::select('subscriptions.*',
                                             'courses.course_name',
                                             'courses.course_details',
                                             'courses.course_wide_icon',
                                             'courses.rate',
                                             'courses.discount_rate')
                                    ->leftJoin('courses', 'subscriptions.course_id', '=', 'courses.id')
                                    ->where('subscriptions.student_id', $user->student_id)
                                    ->where('subscriptions.status', 1)
                                    ->paginate(9);

        return view('website.student.my-courses', compact('subscriptions'));
    }

    public function myResults()
    {
        $user = Auth::guard('student')->user();

        $results = TestResult::where('student_id', $user->student_id)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view('website.student.my-results', compact('results'));
    }

    public function logout()
    {
        Auth::guard('student')->logout();
        Session::flash('message', 'success#You have been logged out successfully.');
        return redirect()->route('student.login');
    }

    public function showRegisterForm()
    {
        return view('website.student.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|max:100',
            'email' => 'required|email|max:50|unique:users,email',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'password' => 'required|min:6|confirmed',
            'date_of_birth' => 'nullable|date',
            'place' => 'nullable|string|max:50',
            'terms' => 'accepted'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            DB::beginTransaction();

            // Create student first
            $student = Student::create([
                'student_name' => $request->student_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'date_of_birth' => $request->date_of_birth,
                'place' => $request->place,
                'status' => 1
            ]);

            // Create user account
            $user = User::create([
                'student_id' => $student->id,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'status' => 1
            ]);

            DB::commit();

            // Auto-login after registration
            Auth::guard('student')->login($user);
            session(['student_details' => $student]);

            Session::flash('message', 'success#Registration successful! Welcome to AIM Learning Platform, ' . $student->student_name . '!');
            return redirect()->route('student.dashboard');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Registration error: ' . $e->getMessage());

            Session::flash('message', 'danger#Registration failed. Please try again.');
            return redirect()->back()->withInput($request->except('password', 'password_confirmation'));
        }
    }

    public function showForgotPasswordForm()
    {
        return view('website.student.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|exists:users,mobile'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Session::flash('message', 'info#Password reset instructions have been sent to your registered mobile number.');
        return redirect()->route('student.login');
    }

    public function courseContent($id)
    {
        try {
            $user = Auth::guard('student')->user();

            // Check subscription with simple query
            $subscription = DB::table('subscriptions')
                            ->where('student_id', $user->student_id)
                            ->where('course_id', $id)
                            ->where('status', 1)
                            ->first();

            if (!$subscription) {
                Session::flash('message', 'danger#You do not have access to this course.');
                return redirect()->route('student.dashboard');
            }

            // Get course details
            $course = DB::table('courses')
                      ->select('id', 'course_name', 'course_square_icon','description','course_details')
                      ->where('id', $id)
                      ->first();

            if (!$course) {
                Session::flash('message', 'danger#Course not found.');
                return redirect()->route('student.dashboard');
            }

            // Get subjects for this course
            $subjects = DB::table('subjects')
                        ->select('id', 'subject_name')
                        ->where('course_id', $id)
                        ->where('status', 1)
                        ->orderBy('subject_name', 'asc')
                        ->get();

            // Get chapters for first subject if exists
            $chapters = collect();
            if ($subjects->isNotEmpty()) {
                $firstSubjectId = $subjects->first()->id;
                $chapters = DB::table('chapters')
                            ->select('id', 'chapter_name')
                            ->where('subject_id', $firstSubjectId)
                            ->where('status', 1)
                            ->orderBy('id', 'asc')
                            ->get();
            }

            return view('website.student.course-content', compact('course', 'subjects', 'chapters', 'subscription'));

        } catch (\Exception $e) {
            \Log::error('Course content error: ' . $e->getMessage());

            // Return with minimal data on error
            $subscription = (object)['start_date' => '2024-01-01', 'end_date' => '2024-12-31'];
            $course = (object)['id' => $id, 'course_name' => 'Course'];
            $subjects = collect();
            $chapters = collect();

            Session::flash('message', 'warning#Error loading some data. Showing limited information.');
            return view('website.student.course-content', compact('course', 'subjects', 'chapters', 'subscription'));
        }
    }




    public function courseMockTest()
    {
        try {
            $user = Auth::guard('student')->user();

               // Get all enrolled courses for the student (for dropdown)
            $myCourses = DB::table('subscriptions')
                        ->join('courses', 'subscriptions.course_id', '=', 'courses.id')
                        ->select('courses.id', 'courses.course_name')
                        ->where('subscriptions.student_id', $user->student_id)
                        ->where('subscriptions.status', 1)
                        ->where('courses.status', 1)
                        ->orderBy('courses.course_name', 'asc')
                        ->get();

            return view('website.student.course-mock-test', compact('myCourses'));

        } catch (\Exception $e) {
            \Log::error('Course mock test error: ' . $e->getMessage());
            Session::flash('message', 'danger#Error loading mock test page. Please try again.');
            return redirect()->route('student.dashboard');
        }
    }


    public function getExamSectionsByCourse(Request $request)
    {
        try {
            $courseId = $request->input('course_id');

            // Get exam tab headings for the selected course
            $examSections = DB::table('exam_tab_headings')
                            ->select('id', 'tab_heading')
                            ->where('course_id', $courseId)
                            ->where('status', 1)
                            ->orderBy('id', 'asc')
                            ->get();

            return response()->json($examSections);

        } catch (\Exception $e) {
            \Log::error('Error fetching exam sections: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    public function getQuestionPapersByCourse(Request $request)
    {
        try {
            $user = Auth::guard('student')->user();
            $courseId = $request->input('course_id');
            $examSectionId = $request->input('exam_section_id');

            // Build query for question papers
            $query = DB::table('question_papers')
                     ->select('id', 'question_paper_name', 'duration', 'description', 'free_test')
                     ->where('course_id', $courseId)
                     ->where('status', 1);

            // Add exam section filter if provided
            if ($examSectionId) {
                $query->where('exam_tab_heading_id', $examSectionId);
            }

            $questionPapers = $query->orderBy('id', 'desc')->get();

            // Get question count and attempt count for each test
            foreach ($questionPapers as $paper) {
                $paper->total_questions = DB::table('questions')
                                        ->where('question_paper_id', $paper->id)
                                        ->count();
                $paper->total_marks = $paper->total_questions * 1; // Assuming 1 mark per question

                // Get number of times this student attempted this test
                $paper->attempt_count = DB::table('qpaper_attended')
                                        ->where('student_id', $user->student_id)
                                        ->where('question_paper_id', $paper->id)
                                        ->count();
            }

            return response()->json($questionPapers);

        } catch (\Exception $e) {
            \Log::error('Error fetching question papers: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }


    public function getChaptersBySubject($subjectId)
    {
        try {
            // Get chapters for the selected subject
            $chapters = DB::table('chapters')
                        ->select('id', 'chapter_name')
                        ->where('subject_id', $subjectId)
                        ->where('status', 1)
                        ->orderBy('id', 'asc')
                        ->get();

            return response()->json(['chapters' => $chapters]);

        } catch (\Exception $e) {
            \Log::error('Get chapters error: ' . $e->getMessage());
            return response()->json(['chapters' => [], 'error' => 'Failed to load chapters']);
        }
    }

    public function getPdfFilesByChapter(Request $request)
    {
        try {
            $chapterId = $request->input('chapter_id');
            $courseId = $request->input('course_id');
            $subjectId = $request->input('subject_id');

           // dd($courseId."|".$subjectId."|".$chapterId);

            // Get PDF files for the selected chapter
            $pdfFiles = PdfFile::select('id', 'title', 'pdf_file', 'description')
                        ->where('course_id', 19)
                        ->where('subject_id', 30)
                        ->where('chapter_id', 30)
                        ->where('status', 1)
                        ->orderBy('id', 'asc')
                        ->get();


            // Add full URL for PDF files
            foreach ($pdfFiles as $pdf) {
                if ($pdf->pdf_file) {
                    // Use config constant for PDF path
                    $pdf->pdf_url = config('constants.pdf_file') . $pdf->pdf_file;
                }
            }

            return response()->json($pdfFiles);

        } catch (\Exception $e) {
            \Log::error('Error fetching PDF files: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    public function recordedClassesPage($courseId)
    {
        try {
            $user = Auth::guard('student')->user();

            // Check subscription
            $subscription = DB::table('subscriptions')
                            ->where('student_id', $user->student_id)
                            ->where('course_id', $courseId)
                            ->where('status', 1)
                            ->first();

            if (!$subscription) {
                Session::flash('message', 'danger#You do not have access to this course.');
                return redirect()->route('student.dashboard');
            }

            // Get course details
            $course = DB::table('courses')
                      ->select('id', 'course_name', 'course_square_icon')
                      ->where('id', $courseId)
                      ->first();

            if (!$course) {
                Session::flash('message', 'danger#Course not found.');
                return redirect()->route('student.dashboard');
            }

            // Get all recorded classes for this course
            $recordedClasses = RecordedLiveClass::where('course_id', $courseId)
                                                ->where('status', 1)
                                                ->orderBy('created_at', 'DESC')
                                                ->get();

            return view('website.student.recorded-classes', compact('course', 'recordedClasses', 'subscription'));

        } catch (\Exception $e) {
            \Log::error('Recorded classes page error: ' . $e->getMessage());
            Session::flash('message', 'danger#Error loading recorded classes. Please try again.');
            return redirect()->route('student.dashboard');
        }
    }

    // Mark video as completed
    public function markVideoCompleted(Request $request)
    {
        try {
            $user = Auth::guard('student')->user();

            $validator = Validator::make($request->all(), [
                'video_id' => 'required|integer|exists:videos,id',
                'course_id' => 'required|integer|exists:courses,id',
                'subject_id' => 'required|integer|exists:subjects,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid data provided'
                ], 400);
            }

            // Check if already marked as completed
            $existing = VideoCompletedStatus::where('student_id', $user->student_id)
                                            ->where('video_id', $request->video_id)
                                            ->where('course_id', $request->course_id)
                                            ->where('subject_id', $request->subject_id)
                                            ->first();

            if ($existing) {
                return response()->json([
                    'success' => true,
                    'message' => 'Video already marked as completed',
                    'already_completed' => true
                ]);
            }

            // Create new completed status
            VideoCompletedStatus::create([
                'student_id' => $user->student_id,
                'video_id' => $request->video_id,
                'course_id' => $request->course_id,
                'subject_id' => $request->subject_id,
                'completed_status' => 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Video marked as completed successfully!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Mark video completed error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark video as completed'
            ], 500);
        }
    }

    // Check if video is completed
    public function checkVideoCompleted(Request $request)
    {
        try {
            $user = Auth::guard('student')->user();

            $videoId = $request->input('video_id');

            if (!$videoId) {
                return response()->json([
                    'completed' => false
                ]);
            }

            $completed = VideoCompletedStatus::where('student_id', $user->student_id)
                                             ->where('video_id', $videoId)
                                             ->where('completed_status', 1)
                                             ->exists();

            return response()->json([
                'completed' => $completed
            ]);

        } catch (\Exception $e) {
            \Log::error('Check video completed error: ' . $e->getMessage());
            return response()->json([
                'completed' => false
            ]);
        }
    }

    // Add comment to video
    public function addVideoComment(Request $request)
    {
        try {
            $user = Auth::guard('student')->user();

            $validator = Validator::make($request->all(), [
                'video_id' => 'required|integer|exists:videos,id',
                'course_id' => 'required|integer|exists:courses,id',
                'subject_id' => 'required|integer|exists:subjects,id',
                'comment' => 'required|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid data provided'
                ], 400);
            }

            // Create new comment
            $comment = VideoComment::create([
                'student_id' => $user->student_id,
                'video_id' => $request->video_id,
                'course_id' => $request->course_id,
                'subject_id' => $request->subject_id,
                'comments' => $request->comment
            ]);

            // Get student name
            $student = Student::find($user->student_id);

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully!',
                'comment' => [
                    'id' => $comment->id,
                    'student_name' => $student->student_name ?? 'Student',
                    'comments' => $comment->comments,
                    'created_at' => $comment->created_at->format('d M Y, h:i A')
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Add video comment error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add comment'
            ], 500);
        }
    }

    // Get comments for a video
    public function getVideoComments(Request $request)
    {
        try {
            $videoId = $request->input('video_id');

            if (!$videoId) {
                return response()->json([
                    'success' => false,
                    'comments' => []
                ]);
            }

            // Get comments with student details
            $comments = VideoComment::select('video_comments.*', 'students.student_name')
                                   ->join('students', 'video_comments.student_id', '=', 'students.id')
                                   ->where('video_comments.video_id', $videoId)
                                   ->orderBy('video_comments.created_at', 'DESC')
                                   ->get()
                                   ->map(function($comment) {
                                       return [
                                           'id' => $comment->id,
                                           'student_name' => $comment->student_name,
                                           'comments' => $comment->comments,
                                           'created_at' => \Carbon\Carbon::parse($comment->created_at)->format('d M Y, h:i A')
                                       ];
                                   });

            return response()->json([
                'success' => true,
                'comments' => $comments
            ]);

        } catch (\Exception $e) {
            \Log::error('Get video comments error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'comments' => []
            ]);
        }
    }

    // Success Stories Page
    public function successStories()
    {
        try {
            $user = Auth::guard('student')->user();
            $student = session('student_details') ?? Student::find($user->student_id);

            // Get all active success stories
            $successStories = SuccessStory::where('status', 1)
                                         ->orderBy('created_at', 'DESC')
                                         ->get();

            return view('website.student.success-stories', compact('student', 'successStories'));

        } catch (\Exception $e) {
            \Log::error('Success stories error: ' . $e->getMessage());
            Session::flash('message', 'danger#Error loading success stories. Please try again.');
            return redirect()->route('student.dashboard');
        }
    }

    // Show delete account request form
    public function showDeleteAccountForm()
    {
        try {
            $user = Auth::guard('student')->user();
            $student = session('student_details') ?? Student::find($user->student_id);

            return view('website.student.delete-account', compact('student'));

        } catch (\Exception $e) {
            \Log::error('Delete account form error: ' . $e->getMessage());
            Session::flash('message', 'danger#Error loading delete account page. Please try again.');
            return redirect()->route('student.dashboard');
        }
    }

    // Submit delete account request
    public function submitDeleteAccountRequest(Request $request)
    {
        try {
            $user = Auth::guard('student')->user();
            $student = Student::find($user->student_id);

            // Validation
            $validator = Validator::make($request->all(), [
                'message' => 'required|string|min:20|max:1000'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Check if student already has a pending delete request
            $existingRequest = \App\Models\DeleteAccountRequest::where('mobile', $student->mobile)
                                                               ->orderBy('created_at', 'DESC')
                                                               ->first();

            if ($existingRequest) {
                // Check if request was made within last 30 days
                $daysSinceRequest = \Carbon\Carbon::parse($existingRequest->created_at)->diffInDays(\Carbon\Carbon::now());

                if ($daysSinceRequest < 30) {
                    Session::flash('message', 'warning#You already have a pending delete account request submitted on ' .
                                            \Carbon\Carbon::parse($existingRequest->created_at)->format('d M Y') .
                                            '. Please wait for admin review.');
                    return redirect()->back();
                }
            }

            // Create delete account request
            \App\Models\DeleteAccountRequest::create([
                'name' => $student->student_name,
                'mobile' => $student->mobile,
                'student_id'=>Auth::user()->student_id,
                'message' => $request->message
            ]);

            Session::flash('message', 'success#Your account deletion request has been submitted successfully. Our admin team will review and process your request soon.');
            return redirect()->route('student.dashboard');

        } catch (\Exception $e) {
            \Log::error('Delete account request error: ' . $e->getMessage());
            Session::flash('message', 'danger#Failed to submit delete account request. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    // Easy Tips Page
    public function easyTips()
    {
        try {
            $user = Auth::guard('student')->user();

            // Get student's purchased courses
            $courses = DB::table('subscriptions')
                        ->join('courses', 'subscriptions.course_id', '=', 'courses.id')
                        ->select('courses.id', 'courses.course_name')
                        ->where('subscriptions.student_id', $user->student_id)
                        ->where('subscriptions.status', 1)
                        ->where('courses.status', 1)
                        ->orderBy('courses.course_name', 'asc')
                        ->get();

            // Get course IDs
            $courseIds = $courses->pluck('id')->toArray();

            // Get total easy tips count for student's purchased courses
            $totalTipsCount = EasyTips::whereIn('course_id', $courseIds)
                                      ->where('status', 1)
                                      ->count();

            return view('website.student.easy-tips', compact('courses', 'totalTipsCount'));

        } catch (\Exception $e) {
            \Log::error('Easy tips page error: ' . $e->getMessage());
            Session::flash('message', 'danger#Error loading easy tips page. Please try again.');
            return redirect()->route('student.dashboard');
        }
    }

    // Get initial easy tips (first 10)
    public function getInitialEasyTips()
    {
        try {
            $user = Auth::guard('student')->user();

            // Get student's purchased course IDs
            $courseIds = DB::table('subscriptions')
                        ->where('student_id', $user->student_id)
                        ->where('status', 1)
                        ->pluck('course_id')
                        ->toArray();

            // Get first 10 easy tips for student's purchased courses
            $tips = EasyTips::select('id', 'course_id', 'subject_id', 'chapter_id', 'title', 'description', 'tips_icon', 'tips_file', 'file_type')
                            ->whereIn('course_id', $courseIds)
                            ->where('status', 1)
                            ->orderBy('id', 'ASC')
                            ->limit(10)
                            ->get();

            return response()->json([
                'success' => true,
                'tips' => $tips
            ]);

        } catch (\Exception $e) {
            \Log::error('Get initial easy tips error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load tips',
                'tips' => []
            ], 500);
        }
    }

    // Filter easy tips by chapter
    public function filterEasyTips(Request $request)
    {
        try {
            $chapterId = $request->input('chapter_id');

            if (!$chapterId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chapter ID is required',
                    'tips' => []
                ]);
            }

            // Get easy tips for the selected chapter
            $tips = EasyTips::select('id', 'course_id', 'subject_id', 'chapter_id', 'title', 'description', 'tips_icon', 'tips_file', 'file_type')
                            ->where('chapter_id', $chapterId)
                            ->where('status', 1)
                            ->orderBy('id', 'ASC')
                            ->get();

            return response()->json([
                'success' => true,
                'tips' => $tips
            ]);

        } catch (\Exception $e) {
            \Log::error('Filter easy tips error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load tips',
                'tips' => []
            ], 500);
        }
    }
}