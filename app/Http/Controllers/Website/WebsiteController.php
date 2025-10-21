<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\BannerImage;
use App\Models\SuccessStory;
use App\Models\Center;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Video;
use App\Models\PdfFile;
use App\Models\StudentReview;
use DB;

class WebsiteController extends Controller
{
    public function index()
    {
        // Fetch course categories with active status (excluding id=1)
        $categories = DB::table('course_category')
                        ->select('id', 'category')
                        ->where('status', 1)
                        ->where('id', '!=', 1)
                        ->orderBy('id', 'ASC')
                        ->get();

        // Fetch courses with subjects using JOIN query
        $coursesWithSubjects = DB::table('courses')
                                ->select(
                                    'courses.id as course_id',
                                    'courses.course_name',
                                    'courses.course_square_icon',
                                    'courses.course_wide_icon',
                                    'courses.description',
                                    'courses.rate',
                                    'courses.discount_rate',
                                    'courses.start_date',
                                    'courses.end_date',
                                    'courses.course_category_id',
                                    'course_category.category',
                                    DB::raw('GROUP_CONCAT(subjects.subject_name SEPARATOR "|||") as subjects'),
                                    DB::raw('COUNT(DISTINCT subjects.id) as subject_count')
                                )
                                ->leftJoin('course_category', 'courses.course_category_id', '=', 'course_category.id')
                                ->leftJoin('subjects', function($join) {
                                    $join->on('courses.id', '=', 'subjects.course_id')
                                         ->where('subjects.status', '=', 1);
                                })
                                ->where('courses.status', 1)
                                ->groupBy('courses.id', 'courses.course_name', 'courses.course_square_icon',
                                         'courses.course_wide_icon', 'courses.description', 'courses.rate',
                                         'courses.discount_rate', 'courses.start_date', 'courses.end_date',
                                         'courses.course_category_id', 'course_category.category')
                                ->orderBy('courses.id', 'DESC')
                                ->limit(20)
                                ->get();

        // Store all courses in a separate variable
        $allCourses = [];

        // Group courses by category
        $coursesByCategory = [];
        foreach ($coursesWithSubjects as $course) {
            $categoryId = $course->course_category_id;
            if (!isset($coursesByCategory[$categoryId])) {
                $coursesByCategory[$categoryId] = [];
            }

            // Convert subject string to array
            $course->subjects_array = $course->subjects ? explode('|||', $course->subjects) : [];

            $coursesByCategory[$categoryId][] = $course;
            $allCourses[] = $course; // Add to all courses array
        }

        // Fetch banners, success stories
        $banners = collect();
        $successStories = collect();

        // Fetch student reviews with student details
        $studentReviews = DB::table('student_reviews')
                            ->join('students', 'student_reviews.student_id', '=', 'students.id')
                            ->select('student_reviews.*', 'students.student_name', 'students.place')
                            ->orderBy('student_reviews.id', 'DESC')
                            ->limit(10)
                            ->get();

        // Use static values for stats
        $totalStudents = Student::count() ?: 1000;
        $totalCourses = Course::where('status', 1)->count() ?: 0;
        $totalVideos = Video::where('status', 1)->count() ?: 0;
        $totalPdfs = PdfFile::where('status', 1)->count() ?: 0;

        /*return view('website.index', compact('categories', 'coursesByCategory', 'allCourses', 'banners',
                                            'successStories', 'totalStudents', 'totalCourses',
                                            'totalVideos', 'totalPdfs', 'studentReviews'));*/
        return view('website.index-new');

    }

    public function about()
    {
        // Get real statistics from database
        $totalStudents = DB::table('students')->where('status', 1)->count();
        $totalCourses = DB::table('courses')->where('status', 1)->count();
        $totalInstructors = DB::table('admins')->where('status', 1)->count();
        $totalCategories = DB::table('course_category')->where('status', 1)->where('id', '!=', 1)->count();
        $totalVideos = DB::table('videos')->where('status', 1)->count();
        $totalCenters = DB::table('centers')->where('status', 1)->count();

        return view('website.about', compact(
            'totalStudents',
            'totalCourses',
            'totalInstructors',
            'totalCategories',
            'totalVideos',
            'totalCenters'
        ));
    }

    public function courses()
    {
        // Fetch all active course categories
        $categories = DB::table('course_category')
                        ->select('id', 'category')
                        ->where('status', 1)
                        ->where('id', '!=', 1)
                        ->orderBy('id', 'ASC')
                        ->get();

        // Fetch all active courses with category information and subject count
        $coursesWithDetails = DB::table('courses')
                                ->select(
                                    'courses.id',
                                    'courses.course_name',
                                    'courses.course_square_icon',
                                    'courses.course_wide_icon',
                                    'courses.description',
                                    'courses.course_details',
                                    'courses.rate',
                                    'courses.discount_rate',
                                    'courses.start_date',
                                    'courses.end_date',
                                    'courses.premium',
                                    'courses.course_category_id',
                                    'course_category.category as category_name',
                                    DB::raw('COUNT(DISTINCT subjects.id) as subject_count'),
                                    DB::raw('(SELECT COUNT(*) FROM videos WHERE videos.course_id = courses.id AND videos.status = 1) as video_count'),
                                    DB::raw('(SELECT COUNT(*) FROM pdf_files WHERE pdf_files.course_id = courses.id AND pdf_files.status = 1) as pdf_count'),
                                    DB::raw('(SELECT COUNT(*) FROM subscriptions WHERE subscriptions.course_id = courses.id) as students_count'),
                                    DB::raw('(SELECT SUM(TIMESTAMPDIFF(MINUTE, 0, videos.duration)) FROM videos WHERE videos.course_id = courses.id AND videos.status = 1) as total_duration')
                                )
                                ->leftJoin('course_category', 'courses.course_category_id', '=', 'course_category.id')
                                ->leftJoin('subjects', function($join) {
                                    $join->on('courses.id', '=', 'subjects.course_id')
                                         ->where('subjects.status', '=', 1);
                                })
                                ->where('courses.status', 1)
                                ->groupBy(
                                    'courses.id',
                                    'courses.course_name',
                                    'courses.course_square_icon',
                                    'courses.course_wide_icon',
                                    'courses.description',
                                    'courses.course_details',
                                    'courses.rate',
                                    'courses.discount_rate',
                                    'courses.start_date',
                                    'courses.end_date',
                                    'courses.premium',
                                    'courses.course_category_id',
                                    'course_category.category'
                                )
                                ->orderBy('courses.course_category_id', 'ASC')
                                ->orderBy('courses.id', 'DESC')
                                ->get();

        // Group courses by category_id
        $coursesByCategory = [];
        foreach ($coursesWithDetails as $course) {
            $categoryId = $course->course_category_id;
            if (!isset($coursesByCategory[$categoryId])) {
                $coursesByCategory[$categoryId] = [];
            }
            $coursesByCategory[$categoryId][] = $course;
        }

        // Get real counts from database
        $totalCategories = DB::table('course_category')
                            ->where('status', 1)
                            ->where('id', '!=', 1)
                            ->count();

        $totalCourses = DB::table('courses')
                         ->where('status', 1)
                         ->count();

        $totalStudents = DB::table('students')
                          ->where('status', 1)
                          ->count();

        return view('website.courses-new', compact('categories', 'coursesByCategory', 'totalCategories', 'totalCourses', 'totalStudents'));
    }

    public function courseDetails($id)
    {
        try {
            $course = Course::findOrFail($id);

            // Get subjects for this course
            $subjects = DB::table('subjects')
                        ->where('course_id', $id)
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')
                        ->get();

            // Get chapters for the first subject (if exists)
            $chapters = collect();
            $firstSubject = $subjects->first();

            if ($firstSubject) {
                $chapters = DB::table('chapters')
                            ->select(
                                'chapters.*',
                                DB::raw('(SELECT COUNT(*) FROM videos WHERE videos.chapter_id = chapters.id AND videos.status = 1) as video_count'),
                                DB::raw('(SELECT COUNT(*) FROM pdf_files WHERE pdf_files.chapter_id = chapters.id AND pdf_files.status = 1) as pdf_count')
                            )
                            ->where('course_id', $id)
                            ->where('subject_id', $firstSubject->id)
                            ->where('status', 1)
                            ->orderBy('id', 'ASC')
                            ->get();
            }

            $relatedCourses = Course::where('status', 1)
                                   ->where('id', '!=', $id)
                                   ->where('course_category_id', $course->course_category_id)
                                   ->limit(3)
                                   ->get();

            return view('website.course-details', compact('course', 'relatedCourses', 'subjects', 'chapters', 'firstSubject'));
        } catch (\Exception $e) {
            \Log::error('Course Details Error: ' . $e->getMessage());
            return redirect()->route('courses')->with('error', 'Course not found or an error occurred.');
        }
    }

    public function contact()
    {
        $centers = Center::where('status', 1)->get();
        return view('website.contact', compact('centers'));
    }

    public function getChaptersBySubject(Request $request)
    {
        try {
            $subjectId = $request->subject_id;
            $courseId = $request->course_id;

            $chapters = DB::table('chapters')
                        ->select(
                            'chapters.*',
                            DB::raw('(SELECT COUNT(*) FROM videos WHERE videos.chapter_id = chapters.id AND videos.status = 1) as video_count'),
                            DB::raw('(SELECT COUNT(*) FROM pdf_files WHERE pdf_files.chapter_id = chapters.id AND pdf_files.status = 1) as pdf_count')
                        )
                        ->where('course_id', $courseId)
                        ->where('subject_id', $subjectId)
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')
                        ->get();

            $subject = DB::table('subjects')->where('id', $subjectId)->first();

            return response()->json([
                'success' => true,
                'chapters' => $chapters,
                'subject' => $subject
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function purchaseCourse($id)
    {
        try {
            // Check if user is logged in using student guard
            if (!auth()->guard('student')->check()) {
                // Store the intended URL to redirect after login
                session(['intended_purchase_course' => $id]);
                return redirect()->route('student.login')->with('info', 'Please login to purchase this course.');
            }

            $course = Course::findOrFail($id);

            // Get course category name
            $category = DB::table('course_category')
                        ->where('id', $course->course_category_id)
                        ->first();

            // Get subjects count
            $subjectsCount = DB::table('subjects')
                            ->where('course_id', $id)
                            ->where('status', 1)
                            ->count();

            // Get total videos count
            $videosCount = DB::table('videos')
                          ->where('course_id', $id)
                          ->where('status', 1)
                          ->count();

            // Get total PDF files count
            $pdfCount = DB::table('pdf_files')
                       ->where('course_id', $id)
                       ->where('status', 1)
                       ->count();

            return view('website.purchase-course', compact('course', 'category', 'subjectsCount', 'videosCount', 'pdfCount'));
        } catch (\Exception $e) {
            \Log::error('Purchase Course Error: ' . $e->getMessage());
            return redirect()->route('courses')->with('error', 'Course not found.');
        }
    }
}