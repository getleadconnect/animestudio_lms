<?php
namespace App\Common;

use App\Models\Subject;
use App\Models\Chapter;
use App\Models\ExamTabHeading;
use App\Models\QuestionPaper;
use App\Models\Course;

class Common
{
	
 public static function getSubjectsByCourseId($id)
 {
	$subj=Subject::where('course_id',$id)->get();
	$opt='<option value="">--select--</option>';
	if(!$subj->isEmpty())
	{
		foreach($subj as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->subject_name.'</option>';
		}
	}

	return $opt;
 }
 
public static function getChaptersBySubjectId($id)
 {
	$cpt=Chapter::where('subject_id',$id)->get();
	$opt='<option value="">--select--</option>';
	if(!$cpt->isEmpty())
	{
		foreach($cpt as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->chapter_name.'</option>';
		}
	}

	return $opt;
 }
 
 
 public static function getTabHeadingsByCourseId($id)
 {
	$etab=ExamTabHeading::where('course_id',$id)->get();
	$opt='<option value="">--select--</option>';
	if(!$etab->isEmpty())
	{
		foreach($etab as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->tab_heading.'</option>';
		}
	}

	return $opt;
 }
 
  
 public static function getQuestionPapersBySubjectId($id)
 {
	$qpaper=QuestionPaper::where('subject_id',$id)->where('status',1)->get();
	$opt='<option value="">--select--</option>';
	if(!$qpaper->isEmpty())
	{
		foreach($qpaper as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->question_paper_name.'</option>';
		}
	}

	return $opt;
 }
 
 
 public static function getQuestionPapersByCourseId($id)  //prepare questions and other
 {
	$qpaper=QuestionPaper::where('course_id',$id)->where('status',1)->orWhere('course_id',null)->get();

	$opt='<option value="">--select--</option>';
	if(!$qpaper->isEmpty())
	{
		foreach($qpaper as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->question_paper_name.'</option>';
		}
	}

	return $opt;
 }
  
 
 public static function getQuestionPapersByCourseIdForViewQuestions($id)   //view questions
 {
	$qpaper=QuestionPaper::where('course_id',$id)->orWhere('course_id',null)->where('status',1)->get();

	$opt='<option value="">--select--</option>';
	if(!$qpaper->isEmpty())
	{
		foreach($qpaper as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->question_paper_name.'</option>';
		}
	}

	return $opt;
 }
 
  
 public static function getFreeQuestionPapers()   //prepare questions
 {
	$qpaper=QuestionPaper::where('free_test',1)->where('status',1)->get();
	$opt='<option value="">--select--</option>';
	if(!$qpaper->isEmpty())
	{
		foreach($qpaper as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->question_paper_name.'</option>';
		}
	}

	return $opt;
 }
  
 
 public static function getCourseByCenterId($id)
 {
	$subj=Course::where('center_id',$id)->get();
	$opt='<option value="">--select--</option>';
	if(!$subj->isEmpty())
	{
		foreach($subj as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->course_name.'</option>';
		}
	}

	return $opt;
 }
 
}
