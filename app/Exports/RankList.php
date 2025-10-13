<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Student;
use App\Models\Course;
use App\Models\TestResult;


class RankList implements FromCollection,WithHeadings
{
	//use Exportable;
		
	protected $qpaper_id =null;
		

	function __construct($qpid)
	{
		$this->qpaper_id=$qpid;
	}
	
	
    /**
    * @return \Illuminate\Support\Collection
    */

	  public function headings():array{
        return[
            'Slno',
            'Student_Id',
			'Student_name',
			'Question Paper',
			'Test_Date',
            'Correct',
			'Wrong',
			'Skipped',
			'Score',
			'Rank',
        ];
    } 
	
    public function collection()
    {
		$qpid=$this->qpaper_id;

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
					$uData['correct']=$r['answer'];
					$uData['wrong']=$r['wrong'];
					$uData['skipped']=$r['skipped'];
					$uData['score']=$r['score'];
					$uData['rank']=$r['rank'];
							
					$data[] = $uData;
				}
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
		}
		
		return collect($data); 

	}

	public function sortByMark($a, $b)
	{
		$a = $a['score'];
		$b = $b['score'];

		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}

	
}
