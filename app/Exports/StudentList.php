<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Student;
use App\Models\Center;
use App\Models\Staff;
use App\Models\District;

class StudentList implements FromCollection,WithHeadings
{
	//use Exportable;
		
	protected $center =null;
	protected $distid =null;
		

	function __construct($center, $distid)
	{
		$this->center=$center;
		$this->distid=$distid;
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
            'Birth_Date',
			'District',
			'Place',
			'Email',
			'Mobile',
			'Reffrenced_By'
        ];
		
    } 
	
    public function collection()
    {
		$center=$this->center;
		$distid=$this->distid;
					
		
		$dts=Student::select('students.*','centers.center_name','staffs.staff_name','districts.district')
		->leftJoin('centers','students.center_id','=','centers.id')
		->leftJoin('staffs','students.staff_id','=','staffs.id')
		->leftJoin('districts','students.district_id','=','districts.id');
		
		
		if($center!="" and $distid!="0")
		{
			$dts->where('students.center_id',$center)->where('students.district_id',$distid);
		}
		else
		{
			$dts->where('students.center_id',$center);
		}			
		
		$stdat=$dts->orderBy('students.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($stdat))
        {
			foreach ($stdat as $key=>$r)
            {
				
					$uData['slno'] = ++$key;
					$uData['id'] = $r->id;
					$uData['center'] =$r->center_name;
					$uData['sname'] =$r->student_name;
					$uData['dob'] =$r->date_of_birth;
					$uData['dist'] =$r->district;
					$uData['place'] =$r->place;
					$uData['email'] =$r->email;
					$uData['mobile'] =$r->mobile;
					$uData['refby'] =$r->staff_name??"--";

			    $data[] = $uData;
			}
        }

		return collect($data);   

		//return McqTestResult::all();
    }

	
}
