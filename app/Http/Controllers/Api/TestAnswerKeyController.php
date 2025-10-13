<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TestAnswerKeyController extends Controller
{
    /**
	 * Function test_mcq_answer_key
	 * Function to display mock test answer key (web view link)
	   http://aim.aimbalussery.com/api/test_answer_key?student_id=4&subject_id=1&qpaper_id=1
	   
	 * @param student_id,subject_id,qpaper_id (int)
	 * return [ web view of answer key]
	 */
		
	public function test_answer_key()
	{
		 return view('admin.answerkey.pdf_answer_key');
	}

	//----------------------------------
		
		
}
