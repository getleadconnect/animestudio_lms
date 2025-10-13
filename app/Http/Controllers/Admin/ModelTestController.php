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

class ModelTestController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    return view('admin.model_tests.question_papers');
  }	
 
 
  public function pdf_questions()
  {
    return view('admin.model_tests.pdf_questions');
  }	
 
 
 public function prepare_questions()
  {
    return view('admin.model_tests.prepare_questions');
  }	
 
 
  public function view_questions()
  {
    return view('admin.model_tests.view_qpaper_questions');
  }	
 
 
  public function store(Request $request)
  {

  }
	
}
