<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Common\Common;

use App\Models\Center;
use App\Models\Course;
use App\Models\Student;
use App\Models\TestResult;
use App\Models\QuestionPaper;

use App\Exports\RankList;

use Validator;
use DataTables;
use Session;
use Auth;

class TestResultController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    $qpaper=[];
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	
	if(!$crs->isEmpty())
	{$qpaper=QuestionPaper::where('course_id',$crs[0]->id)->where('status',1)->get();}
		
	return view('admin.model_tests.test_results',compact('crs','qpaper'));
  }	
  
  public function rank_list()
  {
    $cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	return view('admin.model_tests.rank_list',compact('crs'));
  }	
 
 
  public function store(Request $request)
  {

  }
  

public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getTestResultData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action',])
                    ->make(true);
        }
	}
		
	public function getTestResultData($request)  //view data
	{

		$search=$request->search;
		$qpaper_id=$request->searchQpaper;
		
		$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=TestResult::select('test_results.*','students.student_name','question_papers.question_paper_name')
		->leftJoin('students','test_results.student_id','=','students.id')
		->leftJoin('question_papers','test_results.question_paper_id','=','question_papers.id')
		->where('test_results.question_paper_id',$qpaper_id)
		->where(function($where) use($search)
			    {
					$where->where("test_results.marks", 'like', '%' .$search . '%')
					->orWhere("test_results.score", 'like', '%' .$search . '%')
					->orWhere("students.student_name", 'like', '%' .$search . '%')
					->orWhere("question_papers.question_paper_name", 'like', '%' .$search . '%');
				});
					  
		$dats=$dts->orderBy('test_results.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				
				$uData['id'] = ++$key;
				$uData['sname'] =$r->student_name;
				$uData['qpname'] =$r->question_paper_name;
				$uData['ans'] =$r->answer;
				$uData['wrong'] =$r->wrong;
				$uData['skip'] =$r->skipped;
				$uData['mark'] =$r->marks;
				$uData['nega'] =$r->negative;
				$uData['score'] =$r->score;
				

				$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
							  <li><a class="dropdown-item btnDel" href="javascript:void(0)" id="'.$r->id.'" >Delete</a></li>
                            </ul>
                        </div>';

				$uData['action'] = $dr_btn;
				
				

			    $data[] = $uData;
			}
        }
		return $data;
	}		
	
	public function getQuestionPapersForTestResult($course_id)
	{
		$opt=Common::getQuestionPapersByCourseId($course_id);
	    return $opt;
	}
	
		
   public function destroy($id)
	{
		$dat=TestResult::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'Test result successfuly removed.!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				
	}
		

 //======================get rank list ===================================================

	public function view_rank_list(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getRankListData($request);
			
			return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','rank'])
                    ->make(true);
        }
	}
	
	
	public function getRankListData($request)
	{
		
		$search=$request->search;
		$qpid=$request->searchQpaperId;
			
		try
		{
			
			$rank_list=TestResult::select('test_results.*','students.student_name','question_papers.question_paper_name')
					->leftJoin('students','test_results.student_id','=','students.id')
					->leftJoin('question_papers','test_results.question_paper_id','=','question_papers.id')
					->where('test_results.question_paper_id',$qpid)->get()->toArray();

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
		
			$data = array();
			$uData = array();
			
			$rank_list=collect($rank_list)->sortBy('rank')->toArray();

			if(!empty($rank_list))
			{
				foreach ($rank_list as $key=>$r)
				{
					$uData['slno'] = ++$key;
					$uData['id'] = $r['student_id'];
					$uData['name'] =$r['student_name'];
					$uData['qpname'] =$r['question_paper_name'];
					$uData['tdate'] =date_create($r['test_date'])->format('d-m-Y');
					$uData['answer']=$r['answer'];
					$uData['wrong']=$r['wrong'];
					$uData['skipped']=$r['skipped'];
					$uData['mark']=$r['marks'];
					$uData['score']=$r['score'];
					$uData['rank']="<b>".$r['rank']."</b>";
							
					$data[] = $uData;
				}
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
		}
		
		return $data;

	}

	public function sortByMark($a, $b)
	{
		$a = $a['score'];
		$b = $b['score'];

		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}

	
	
	public function export_rank_list($qpid)
	{
		 //return Excel::download($export, 'test.xlsx');
        return Excel::download(new RankList($qpid), 'rank_list'.'_'.date('Y-m-d').'.'.'xlsx');
    }
	
	
	
}
