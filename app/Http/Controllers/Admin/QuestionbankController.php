<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Center;
use App\Models\Course;
use App\Models\Student;

use Validator;
use DataTables;
use Session;
use Auth;

class QuestionbankController extends Controller
{
  public function __construct()
  {
     //$this->middleware('admin');
  }
  
  public function index()
  {
    return view('admin.question_bank.questions');
  }	
 
 
  public function question_bank_subjects()
  {
    return view('admin.question_bank.question_bank_subjects');
  }	
 
 
 public function import_questions()
  {
    return view('admin.question_bank.import_questions');
  }	
 
 
  public function store(Request $request)
  {

  }
	

}
