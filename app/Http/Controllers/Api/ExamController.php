<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Str;

use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use App\Models\QuestionPaper;
use App\Models\Question;
use App\Models\PdfQuestion;

use App\Models\ExamTabHeading;
use App\Models\TestResult;
use App\Models\TestAllResult;
use App\Models\TestRankList;
use App\Models\SubjectProficiency;
use App\Models\QpaperAttended;
use DB;

class ExamController extends Controller
{
	 /**
	 * Function get_question_papers
	 * Function to get the active question papers
	 * Method:POST
	 * @params: course_id (int),
	 * @params: question_paper_id (int)
	 * return [ list ]
	 */
	
	public function get_question_papers(Request $request)  
	{

		$crs_id=$request->course_id;
		$st_id=$request->student_id;
		
		try
		{
			$tbh=ExamTabHeading::where('course_id',$crs_id)->where('status',1)->get()->map(function($q) use($st_id,$crs_id)
			{
				$qpaper=QuestionPaper::where('course_id',$crs_id)->where('exam_tab_heading_id',$q->id)->where('status',1)->get()->map(function($qp) use($st_id,$crs_id)
				{
					$qp['explanation_video']=($qp->explanation_video!="")?config('constants.exam_exp_video').$qp->explanation_video:null;

					$acnt=QpaperAttended::where('student_id',$st_id)->where('question_paper_id',$qp->id)->count();
					$qp['attended_count']=$acnt;
					
					$qcnt=Question::where('question_paper_id',$qp->id)->count();
					$qp['question_count']=$qcnt;
	
					return $qp;
				});
				$q['question_paper']=$qpaper;
				
				return $q;
			});

			
			$response=[
			'status'=>TRUE,
			'tab'=>$tbh
			];		
		}
		catch(\Exception $e)
		{
			$response=['status'=>FALSE,'message'=>$e->getMessage()];		
		}
		
		return response($response, 200);
		
    }
		
		
	public function get_free_question_papers(Request $request)  
	{
		$st_id=$request->student_id;
		
		try
		{
			$qpaper=QuestionPaper::where('free_test',1)->where('status',1)->get()->map(function($q) use($st_id)
				{
					$q['explanation_video']=($q->explanation_video!="")?config('constants.exam_exp_video').$q->explanation_video:null;

					$acnt=QpaperAttended::where('student_id',$st_id)->where('question_paper_id',$q->id)->count();
					$q['attended_count']=$acnt;
					
					return $q;
				});
			
			$response=[
			'status'=>TRUE,
			'qpapers'=>$qpaper
			];		
		}
		catch(\Exception $e)
		{
			$response=['status'=>FALSE,'message'=>$e->getMessage()];		
		}
		
		return response($response, 200);
		
    }	
		
		
		
	 /**
	 * Function get_questions
	 * Function to get questions based on question paper
	 * Method:POST
	 * @params: question_paper_id (int)
	 * return [ list ]
	 */
	
	public function get_questions(Request $request)  
	{

		$qp_id=$request->question_paper_id;
		
		try
		{
			$dura=QuestionPaper::where('id',$qp_id)->pluck('duration')->first();
			
			$quest=Question::where('question_paper_id',$qp_id)->orderBy('id','ASC')->get()
			->map(function($q)
			  {
				  if($q->question_type==1)
				  {
				     $q['question']=config('constants.image_question').$q->question;
				  }
				  return $q;
			  });
						
			$response=[
			'status'=>TRUE,
			'duration'=>$dura,
			'questions'=>$quest,
			];		
		}
		catch(\Exception $e)
		{
			$response=['status'=>FALSE,'message'=>$e->getMessage()];		
		}
		
		return response($response, 200);
		
    }
	
	/**
	 * Function get_pdf_questions
	 * Function to get the active pdf questions
	 * Method:POST
	 * @params: course_id (int),
	 * return [ list ]
	 */
	
	public function get_pdf_questions(Request $request)  
	{

		$crs_id=$request->course_id;
		
		try
		{
			$pdfq=PdfQuestion::where('course_id',$crs_id)->where('status',1)->get()->map(function($q)
			  {
				  $q['pdf_question_file']=config('constants.pdf_question').$q->pdf_question_file;
				  return $q;
				});
			
			$response=['status'=>TRUE,
			'pdf_question'=>$pdfq,
			'message'=>"pdf question found",
			];		
		}
		catch(\Exception $e)
		{
			$response=['status'=>FALSE,'message'=>$e->getMessage()];		
		}
		
		return response($response, 200);
		
    }

	
   /**
   
	 * Function set_test_results
	 * Function to set the test questions  result of specified question paper
	 * Methiod: POST
	 * @param question_paper_id (int)
	 * @param student_id (int)
	 * @param exam_result json
	 
		exam_result : {"test_result":[{"question_id":"1","answer":"3"},{"question_id":"2","answer":"4"},
		{"question_id":"3","answer":"2"},{"question_id":"4","answer":"3"},
		{"question_id":"5","answer":"4"}]}
		
	 * return [ results ]
	 
	 */
	
	
	public function set_test_results(Request $request) 
	{

		$tdate=date('Y-m-d');
		$qpid=$request->question_paper_id;
		$stid=$request->student_id;
		$tresult=$request->exam_result;
		$ttime=$request->total_time;
		
		$answer=0;
		$wrong=0;
		$skipped=0;		
		$qcount=0;
		
		try
		{

			//$arr = json_decode($tresult,true);
			$arr =$tresult;
					
			//delete existing result ------------------------
			$where=["question_paper_id"=>$qpid,'student_id'=>$stid];
			TestAllResult::where($where)->delete();
			//----------------------------------------------

			$qcount=Question::where("question_paper_id",$qpid)->count(); 			
					
			foreach ($arr['test_result'] as $pt)
			{		
				$tquestid=$pt['question_id'];
				$tanswer=$pt['answer'];
				
								
				//-------------------------------------------

				$res=Question::whereId($tquestid)->get()->toArray();

				$sk_status=0;
				$wr_status=0;
				
				if($tanswer==0)
				{
					$skipped++;
					$sk_status=1;
				}
				else
				{
					if($res[0]['correct_answer']==$tanswer)
					{
						$answer++;
					}
					else
					{
						$wrong++;
						$wr_status=1;
					}
				}
				
				//insert question and result ------------------------
				$mar=TestAllResult::create(['result_date'=>date('Y-m-d'),
					'student_id'=>$stid,
					'qbank_subject_id'=>$res[0]['qbank_subject_id'],
					'question_paper_id'=>$qpid,
					'question_id'=>$tquestid,
					'correct_answer'=>$res[0]['correct_answer'],
					'answer'=>$tanswer,
					'wrong_status'=>$wr_status,
					'skipped_status'=>$sk_status,
				]);
				//-------------------------------------------

			}
			
			//delete old result ---------
			$prec=TestResult::where('student_id',$stid)->where('question_paper_id',$qpid);
			$prec->delete();

			//--------------------------

				$mark=$answer;
				$neg=($wrong)/3;
				$score=$mark-$neg;
				
				$result_data=[
					'question_paper_id'=>$qpid,   
					'student_id'=>$stid,
					'test_date'=>date('Y-m-d'),
					'total_questions'=>$qcount,
					'answer'=>$answer,
					'wrong'=>$wrong,
					'skipped'=>$skipped,
					'marks'=>$mark,
					'total_questions'=>$qcount,
					'negative'=>$neg,
					'score'=>(float)$score,
					'total_time'=>$ttime,
					'status'=>"1",
				];
				
				$res1=TestResult::create($result_data);
				
				//for rank list first attempt exam only-----
				$tcnt=TestRankList::where('question_paper_id',$qpid)->where('student_id',$stid)->count();
				if($tcnt<=0)
				{
					$rank_result=TestRankList::create($result_data);
				}
				//-----------------------------------------

				$res2=QpaperAttended::create([
					'question_paper_id'=>$qpid,   
					'student_id'=>$stid,
				]);

				$response=[
				'status'=>TRUE,
				'result'=>$res1,
				'message'=>"Test result successfully added",
				];		
			
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE, "message" =>$e->getMessage()];
		}

		return response($response, 200);
    }
	
	/**
	 * Function get_test_results
	 * Function to get the already attended test result and analytics
	 * Method:POST
	 * @params: student_id (int),
	 * @params: question_paper_id (int)
	 * return [ list ]
	 */
	
	
	public function get_test_results(Request $request)  //already attended test results
	{

		$qpid=$request->question_paper_id;
		$stid=$request->student_id;
		
		try
		{
		
		$where=["question_paper_id"=>$qpid,'student_id'=>$stid];
		$test_res=TestResult::where($where)->orderBy('id','DESC')->get()->first();
		
		$res1=["questions"=>0,"correct" =>0,"wrong"=>0,"skipped"=>0,"score"=>0,'total_time'=>0];
		
		if(!empty($test_res))
		{
		
		  $qcount=explode("/",$test_res->marks);
				
		  $res1=["questions"=>$test_res->total_questions,
				"correct" =>$test_res->answer,
				"wrong"=>$test_res->wrong,
				"skipped"=>$test_res->skipped,
				"score"=>$test_res->score,
				"total_time"=>$test_res->total_time,
			];
		}

			$response=[
			'status'=>TRUE,
			'test_result'=>$res1,
			'message'=>'Test result found.',
			];		
		}
		catch(\Exception $e)
		{
			$response=['status'=>FALSE,'message'=>$e->getMessage()];		
		}
		
		return response($response, 200);
    }
	
	
	/**
	 * Function get_improved_subjects
	 * Function to get the improved subjects after the test
	 * Method:POST
	 * @params: student_id (int),
	 * @params: question_paper_id (int)
	 * return [ list ]
	 */


public function get_improved_subjects(Request $request)
{
	
	$stid=$request->student_id;
	$qpid=$request->question_paper_id;
	
	$imp_subj=TestAllResult::select('qbank_subject_id','qbank_subjects.subject_name',
		DB::raw('COUNT(test_all_results.qbank_subject_id) as subject_quest_count'),
		DB::raw('SUM(test_all_results.wrong_status) as wrong_count'),
		DB::raw('SUM(test_all_results.skipped_status) as skipped_count'))
	->join('qbank_subjects','test_all_results.qbank_subject_id','=','qbank_subjects.id')
	->groupBy('qbank_subject_id','qbank_subjects.subject_name')
	->where('test_all_results.question_paper_id',$qpid)
	->get()->map(function($q)
	{
		
		$avg=(($q['wrong_count']+$q['skipped_count'])*100)/$q['subject_quest_count'];
		$q['subject_average']=$avg;	
		if($avg>50)
			return $q;
	})->filter();
	
	$imp_subj = $imp_subj->sortBy([
    ['subject_average', 'desc']
	]);

	$resp=collect($imp_subj->values()->all());
	
	$response=[
			'status'=>TRUE,
			'subjects'=>$resp,
			'message'=>'subject to  improve.',
			];		

	return response($response, 200);
	
}

   /**
	 * Function get_test_worng_skipped_answer
	 * Function to get revised test result with questions and mark correct answer and wrong/skipped result
	 * Method:POST
	 * @params: student_id (int),
	 * @params: question_paper_id (int)
	 * return [ list ]
	 */

	public function get_test_wrong_skipped_answer(Request $request)  
	{

		$qpid=$request->question_paper_id;
		$stid=$request->student_id;
		
		try
		{
		
			$where=["test_all_results.question_paper_id"=>$qpid,'test_all_results.student_id'=>$stid];
			
			$test_res=Question::select('questions.*','test_all_results.wrong_status','test_all_results.skipped_status','test_all_results.answer as student_answer')
					  ->leftJoin('test_all_results','questions.id','test_all_results.question_id')
					  ->where($where)->orderBy('id','ASC')->get()
					  ->map(function($q)
						  {
							  if($q->question_type==1)
							  {
								 $q['question']=config('constants.image_question').$q->question;
							  }
							  return $q;
						  });
					  			
			if(!$test_res->isEmpty())
			{
				$response=[
				'status'=>TRUE,
				'test_result'=>$test_res,
				'message'=>'Test result found.',
				];		
			}
			else
			{
				$response=[
				'status'=>False,
				'test_result'=>[],
				'message'=>'No result were found.',
				];	
			}
		}
		catch(\Exception $e)
		{
			$response=['status'=>FALSE,'message'=>$e->getMessage()];		
		}
		
		return response($response, 200);
    }

   /**
	 * Function get_subject_proficiency
	 * Function to get subject proficiency details based on last 3 test results
	 * Method:POST
	 * @params: student_id (int),
	 * @params: course_id (int)
	 * return [ list ]
	 */

public function get_subject_proficiency(Request $request)
{
	$stid=$request->student_id;
	$crsid=$request->course_id;
	
	$qprs=QuestionPaper::select('question_papers.*')
		  ->join('test_results','question_papers.id','=','test_results.question_paper_id')
		  ->where('question_papers.course_id',$crsid)->where('test_results.student_id',$stid)
		  ->take(3)->get();
	
	$data=[];
	
	if(!$qprs->isEmpty())
	{
  	    foreach($qprs as $r)
		{
			$sub_res=TestAllResult::select('qbank_subject_id','qbank_subjects.subject_name',
				DB::raw('COUNT(test_all_results.qbank_subject_id) as subject_quest_count'),
				DB::raw('SUM(test_all_results.wrong_status) as wrong_count'),
				DB::raw('SUM(test_all_results.skipped_status) as skipped_count'))
			->join('qbank_subjects','test_all_results.qbank_subject_id','=','qbank_subjects.id')
			->groupBy('qbank_subject_id','qbank_subjects.subject_name')
			->where('test_all_results.question_paper_id',$r->id)
			->get()->map(function($q)
			{
				$avg=(($q['wrong_count']+$q['skipped_count'])*100)/$q['subject_quest_count'];
				$q['subject_average']=$avg;	
				if($avg>50)
					return $q;
			})->filter()->toArray();
			
			$data=array_merge($data,$sub_res);
		}
		
		if(!empty($data))
		{
			SubjectProficiency::where('student_id',$stid)->delete();		
			foreach($data as $r)
			{
				$result=SubjectProficiency::create([
				  'student_id'=>$stid,
				  'qbank_subject_id'=>$r['qbank_subject_id'],
				  'subject_name'=>$r['subject_name'],
				  'subject_average'=>$r['subject_average'],
				]);
			}
		}
		
		$sub_avg=SubjectProficiency::select('qbank_subject_id','subject_name',
				DB::raw('AVG(subject_average) as subject_avg'))
				->groupBy('qbank_subject_id','subject_name')
				->get()->map(function($q)
				{
					$q['subject_avg']=number_format($q->subject_avg,2,'.','');
					
					if($q->subject_avg>=90)
					{
						$q['subject_proficiency']="Exceptional Achivement!";
						$q['proficiency_status']=true;
					}
					else if($q->subject_avg>=75)
					{
						$q['subject_proficiency']="Impressive!";
						$q['proficiency_status']=true;
					}
					else if($q->subject_avg>=50)
					{
						$q['subject_proficiency']="Well Done!";
						$q['proficiency_status']=true;
					}
					else
					{
						$q['subject_proficiency']="Need Improvement!";
						$q['proficiency_status']=false;
					}
					
					return $q;
					
				});

		$response=[
			'status'=>true,
			'subjects'=>$sub_avg,
		  ];	
	}
	else
	{
		$response=[
			'status'=>false,
			'subjects'=>$data,
		  ];	
	}

	return response($response, 200);
}

//----------- get test rank list ------------------------------------

   /** 
	 * Function get_rank_list
	 * Function to get the rank list of specified question paper
	 * Method:POST
	 * @params: question_paper_id (int), 
	 * return [ list ]
	 **/
	
	public function get_rank_list(Request $request)
	{
		$studid=$request->student_id;
		$qpid=$request->question_paper_id;
				
		/*$rank_list=TestResult::select('test_results.*','students.student_name','question_papers.question_paper_name')
				->leftJoin('students','test_results.student_id','=','students.id')
				->leftJoin('question_papers','test_results.question_paper_id','=','question_papers.id')
				->where('test_results.question_paper_id',$qpid)->get()->toArray();*/
				
		$rank_list=TestRankList::select('test_rank_list.*','students.student_name','question_papers.question_paper_name')
				->leftJoin('students','test_rank_list.student_id','=','students.id')
				->leftJoin('question_papers','test_rank_list.question_paper_id','=','question_papers.id')
				->where('test_rank_list.question_paper_id',$qpid)->get()->toArray();
							
			$last_v=0;$i=0;
			usort($rank_list,array($this,'sortByMark'));
			
				foreach ($rank_list as $m => $v) 
				{
						if ($v['score'] != $last_v)
						{
						   $i++;
						   $last_v = $v['score'];
						}
					  $rank_list[$m]['student_id'] = $v['student_id'];
					  $rank_list[$m]['rank'] = $i;
				}
	
		$rlist = [];
		$my_rank = [];
		$uData = [];
		
		$rank_list=collect($rank_list)->sortBy('rank')->toArray();
				
        if(!empty($rank_list))
        {
			foreach ($rank_list as $key=>$r)
            {
				
				if($r['student_id']==$studid)
				{
					$my_rank['id'] =$r['student_id'];
					$my_rank['name'] =$r['student_name'];
					$my_rank['tdate'] =date_create($r['test_date'])->format('d-m-Y');
					$my_rank['correct']=$r['answer'];
					$my_rank['wrong']=$r['wrong'];
					$my_rank['skipped']=$r['skipped'];
					$my_rank['score']=$r['score'];
					$my_rank['rank']=$r['rank'];
				}
				else
				{

					$uData['slno'] = ++$key;
					$uData['id'] =$r['student_id'];
					$uData['name'] =$r['student_name'];
					$uData['tdate'] =date_create($r['test_date'])->format('d-m-Y');
					$uData['correct']=$r['answer'];
					$uData['wrong']=$r['wrong'];
					$uData['skipped']=$r['skipped'];
					$uData['score']=$r['score'];
					$uData['rank']=$r['rank'];
					
					$rlist[] = $uData;
				}

			}

				$response=[
					'status'=>TRUE,
					'my_rank'=>$my_rank,
					'rank_list'=>$rlist,
				 ];	
        }
		else
		{
			$response=[
					'status'=>FALSE,
					'my_rank'=>[],
					'rank_list'=>[],
				 ];	
		}
		
		return response($response, 200);

	}

	public function sortByMark($a, $b)
	{
		$a = $a['score'];
		$b = $b['score'];

		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}


}
