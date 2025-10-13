<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Video;
use App\Models\VideoCompletedStatus;
use Illuminate\Support\Facades\Auth;

class VideoContentController extends Controller
{
    /*public function courseContent($courseId)
    {
        $course = Course::findOrFail($courseId);
        $subjects = Subject::where('course_id', $courseId)
                          ->where('status', 1)
                          ->orderBy('id', 'asc')
                          ->get();

        \Log::info('Course Content Page', [
            'course_id' => $courseId,
            'course_name' => $course->course_name,
            'subjects_count' => $subjects->count()
        ]);

        return view('website.student.course-content', compact('course', 'subjects'));
    }*/

    public function getChaptersByCourse(Request $request)
    {
        $chapters = Chapter::where('course_id', $request->course_id)
                          ->where('subject_id', $request->subject_id)
                          ->where('status', 1)
                          ->orderBy('id', 'asc')
                          ->get();

        return response()->json($chapters);
    }

    public function getVideosByChapter(Request $request)
    {
        // Log the request for debugging
        \Log::info('Getting videos for chapter', [
            'course_id' => $request->course_id,
            'subject_id' => $request->subject_id,
            'chapter_id' => $request->chapter_id
        ]);

        $videos = Video::where('course_id', $request->course_id)
                       ->where('subject_id', $request->subject_id)
                       ->where('chapter_id', $request->chapter_id)
                       ->where('status', 1)
                       ->orderBy('id', 'asc')
                       ->get();

        // Get current authenticated student
        $user = Auth::guard('student')->user();
        $studentId = $user ? $user->student_id : null;

        // Get all completed video IDs for this student
        $completedVideoIds = [];
        if ($studentId) {
            $completedVideoIds = VideoCompletedStatus::where('student_id', $studentId)
                                                     ->where('completed_status', 1)
                                                     ->pluck('video_id')
                                                     ->toArray();
        }

        // Transform the videos to match expected format
        $videos->transform(function ($video) use ($completedVideoIds) {
            $transformed = [
                'id' => $video->id,
                'video_name' => $video->title,
                'video_link' => null,
                'video_thumbnail' => config('constants.video_file').$video->video_icon,
                'video_duration' => $video->duration ?? '00:00',
                'description' => $video->description,
                'explanation'=>$video->explanation,
                'is_free' => rand(0, 1), // Random for demo, you can use actual field if exists
                'is_completed' => in_array($video->id, $completedVideoIds) // Add completion status
            ];

            // Handle video file URL
            if ($video->video_file) {
                $transformed['video_link'] = config('constants.video_file') . $video->video_file;
            }

            // Handle thumbnail URL
            if ($video->video_icon) {
                $transformed['video_thumbnail'] = config('constants.video_file') . $video->video_icon;
            }

            return $transformed;
        });

        \Log::info('Videos found', ['count' => $videos->count()]);

        return response()->json($videos);
    }


    public function playVideo($videoId)
    {
        $video = Video::findOrFail($videoId);

        $video->video_name = $video->title;
        $video->video_link = $video->video_file ? config('constants.video_file') . $video->video_file : '';
        $video->video_thumbnail = $video->video_icon ? config('constants.video_file') . $video->video_icon : asset('assets/images/default-video-thumb.jpg');
        $video->video_duration = $video->duration;
        $video->is_free = rand(0, 1);

        $relatedVideos = Video::where('chapter_id', $video->chapter_id)
                              ->where('id', '!=', $videoId)
                              ->where('status', 1)
                              ->limit(10)
                              ->get();

        $relatedVideos->transform(function ($relVideo) {
            $relVideo->video_name = $relVideo->title;
            $relVideo->video_duration = $relVideo->duration;
            if ($relVideo->video_icon) {
                $relVideo->video_thumbnail = config('constants.video_file') . $relVideo->video_icon;
            } else {
                $relVideo->video_thumbnail = asset('assets/images/default-video-thumb.jpg');
            }
            return $relVideo;
        });

        $video->subject = Subject::find($video->subject_id);
        $video->chapter = Chapter::find($video->chapter_id);

        return view('website.play-video', compact('video', 'relatedVideos'));
    }


    /*public function testVideos()
    {
        // Get sample data from database for testing
        $courses = Course::where('status', 1)->take(5)->get(['id', 'course_name']);
        $subjects = Subject::where('status', 1)->take(10)->get(['id', 'subject_name', 'course_id']);
        $chapters = Chapter::where('status', 1)->take(10)->get(['id', 'chapter_name', 'course_id', 'subject_id']);
        $videos = Video::where('status', 1)->take(10)->get();

        $data = [
            'total_courses' => Course::where('status', 1)->count(),
            'total_subjects' => Subject::where('status', 1)->count(),
            'total_chapters' => Chapter::where('status', 1)->count(),
            'total_videos' => Video::where('status', 1)->count(),
            'sample_courses' => $courses,
            'sample_subjects' => $subjects,
            'sample_chapters' => $chapters,
            'sample_videos' => $videos->map(function($video) {
                return [
                    'id' => $video->id,
                    'title' => $video->title,
                    'course_id' => $video->course_id,
                    'subject_id' => $video->subject_id,
                    'chapter_id' => $video->chapter_id,
                    'video_file' => $video->video_file,
                    'video_icon' => $video->video_icon,
                    'duration' => $video->duration,
                    'status' => $video->status
                ];
            }),
            'config_urls' => [
                'video_file' => config('constants.video_file'),
                'course_icon' => config('constants.course_icon')
            ]
        ];

        return response()->json($data);
    }*/


}