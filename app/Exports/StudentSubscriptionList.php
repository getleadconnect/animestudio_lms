<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Student;
use App\Models\Center;
use App\Models\Subscription;

class StudentSubscriptionList implements FromCollection,WithHeadings
{
	//use Exportable;
		
	protected $center_id =null;
	protected $course_id =null;
		

	function __construct($center, $crsid)
	{
		$this->center_id=$center;
		$this->course_id=$crsid;
	}
	
	
    /**
    * @return \Illuminate\Support\Collection
    */

	  public function headings():array{
        return[
            'Slno',
            'Reg_Id',
			'Center',
			'Name',
            'Subscribed_Course',
			'Rate',
			'Ref_Code',
			'Ref_Value',
			'Paid Amount',
			'Start Date',
			'End Date'
        ];
    } 
	
    public function collection()
    {
		$center_id=$this->center_id;
		$course_id=$this->course_id;
					
		
		$dts=Subscription::select('subscriptions.*','students.student_name','centers.center_name','courses.course_name')
		->leftJoin('students','subscriptions.student_id','=','students.id')
		->leftJoin('centers','students.center_id','=','centers.id')
		->leftJoin('courses','subscriptions.course_id','=','courses.id');
		
		if($center_id!="" and $course_id!="0")
		{
			$dts->where('students.center_id',$center_id)->where('subscriptions.course_id',$course_id);
		}	
		else
		{
			$dts->where('students.center_id',$center_id);
		}	
							  
		$dats=$dts->orderBy('subscriptions.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {

				$uData['slno'] = ++$key;
				$uData['id'] = $r->student_id;
				$uData['center'] =$r->center_name;
				$uData['sname'] =$r->student_name;
				$uData['cname'] =$r->course_name;
				$uData['rate'] =number_format($r->rate,2);
				$uData['rcode'] =$r->referral_code??"--";
				$uData['rvalue'] =$r->referral_value?number_format($r->referral_value,2):"--";
				$uData['netamt'] =number_format($r->net_amount,2);
				$uData['sdate'] =$r->start_date;
				$uData['edate'] =$r->end_date;

			    $data[] = $uData;
			}
        }

		return collect($data);   

    }

	
}
