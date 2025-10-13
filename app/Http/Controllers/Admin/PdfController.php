<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Common\Common;

use App\Models\Center;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\PdfFile;

use Validator;
use DataTables;
use Session;
use Auth;
use DB;

class PdfController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
 	$subj=collect();
	$chap=collect();
	
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	if(!$crs->isEmpty())
	{$subj=Subject::where('course_id',$crs[0]->id)->where('status',1)->get();}
	
	if(!$subj->isEmpty())
	{$chap=Chapter::where('subject_id',$subj[0]->id)->where('status',1)->get();	}

	return view('admin.pdf_files.pdf_files',compact('crs','subj','chap'));
  }	
   
  public function add_pdf_file()
  {
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
    return view('admin.pdf_files.add_pdf_file',compact('crs'));
  }	
  
  
 public function getSubjectsForPdfFile($course_id)
 {
	$opt=Common::getSubjectsByCourseId($course_id);
	return $opt;
 }
  
  
   public function getChaptersForPdfFile($subject_id)
 {
	$opt=Common::getChaptersBySubjectId($subject_id);
	return $opt;
 }
  	
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'chapter_id'=>'required',
			 'subject_id'=>'required',
			 'chapter_id'=>'required',
			 'title'=>'required',
			 'pdf_file'=>'required',
			 'description'=>'required',
        ]);
	  
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }

		try
		{
			
			$usr_id=Auth::guard('admin')->user()->id;
			//$cid=Auth::guard('admin')->user()->center_id;

			$fname2="";

			if($request->file('pdf_file'))
			{ 
				$fname2=Storage::disk('spaces')->putFile("pdf_files",$request->file('pdf_file'), 'public');
				$fname2=str_replace("pdf_files/","",$fname2);
			}
			
			$result=PdfFile::create([
			 'course_id'=>$request->course_id,
			 'subject_id'=>$request->subject_id,
			 'chapter_id'=>$request->chapter_id,
			 'title'=>$request->title,
			 'pdf_file'=>$fname2,
			 'description'=>$request->description,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
						
			if($result)
			{
				Session::flash('message', 'success#Pdf file successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Some details are missing. try again');
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			Session::flash('message', 'danger#Something wrong, Try again.');
		}
		
		return redirect('pdf-files');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getPdfFiles($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','icon','pfile','status'])
                    ->make(true);
        }
	}
		
	public function getPdfFiles($request)  //view data
	{

		$search=$request->search;
		$course_id=$request->searchCourse;
		$subject_id=$request->searchSubject;
		$chapter_id=$request->searchChapter;
		
		$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=PdfFile::select('pdf_files.*','courses.course_name','subjects.subject_name','chapters.chapter_name','admins.name')
		->leftJoin('admins','pdf_files.added_by','=','admins.id')
		->leftJoin('courses','pdf_files.course_id','=','courses.id')
		->leftJoin('subjects','pdf_files.subject_id','=','subjects.id')
		->leftJoin('chapters','pdf_files.chapter_id','=','chapters.id')
		->where(function($where) use($search)
			    {
					$where->where("pdf_files.title", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%')
					->orWhere("subjects.subject_name", 'like', '%' .$search . '%')
					->orWhere("chapters.chapter_name", 'like', '%' .$search . '%');
				});
		
		if($course_id!="")
		{
			$dts->where('pdf_files.course_id',$course_id);
		}			
		if($subject_id!="")
		{
			$dts->where('pdf_files.subject_id',$subject_id);
		}
		if($chapter_id!="")
		{
			$dts->where('pdf_files.chapter_id',$chapter_id);
		}	
					  
		$dats=$dts->orderBy('pdf_files.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
			if($r->status==1)
			{
				$st='<span class="badge bg-success">Active</span>';
				$btns='<a href="javascript:void(0)" id="'.$r->id.'" class="btnDeact dropdown-item">Deactivate </a>';
			}
			else
			{
				$st='<span class="badge bg-danger">Inactive</span>';
				$btns='<a href="javascript:void(0)" id="'.$r->id.'" class="btnAct dropdown-item">Activate </a>';
			}
		
			$uData['id'] = ++$key;
			$uData['cname'] =$r->course_name;
			$uData['sname'] =$r->subject_name;
			$uData['chname'] =$r->chapter_name;
			$uData['title'] =$r->title;
			$uData['pfile'] ='<a href="'.config('constants.pdf_file').$r->pdf_file.'" target="blank">'.$r->pdf_file.'</a>';
			$uData['desc'] =$r->description;
			$uData['status'] =$st;
			$uData['addedby'] =$r->name;
			
			
				$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item edit" href="'.url('edit-pdf-file').'/'.$r->id.'" >Edit</a></li>
							  <li><a class="dropdown-item btnDel" href="javascript:void(0)" id="'.$r->id.'" >Delete</a></li>
                              <li>'.$btns.'</li>
                            </ul>
                        </div>';

				$uData['action'] = $dr_btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

  public function edit($id)
  {
    $pf=PdfFile::where('id',$id)->first();
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	$subj=Subject::where('course_id',$pf->course_id)->where('status',1)->get();	
	$chpt=Chapter::where('course_id',$pf->subject_id)->where('status',1)->get();	
	return view('admin.pdf_files.edit_pdf_file',compact('pf','crs','subj','chpt'));
  }	
		
	public function update_pdf_file(Request $request)
	{

	  $validate = Validator::make(request()->all(),[
             'course_id_edit'=>'required',
			 'subject_id_edit'=>'required',
			 'chapter_id_edit'=>'required',
			 'title_edit'=>'required',
			 'description_edit'=>'required',
        ]);
	  
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }

		try
		{
			
			$fname2=$request->pdf_file;
			$ex_fname2=$request->pdf_file;
			
			$id=$request->pdf_id;
						
			
			if($request->file('pdf_file_edit'))
			{ 
				$fname2=Storage::disk('spaces')->putFile("pdf_files",$request->file('pdf_file_edit'), 'public');
				$fname2=str_replace("pdf_files/","",$fname2);
				Storage::disk('spaces')->delete("pdf_files"."/".$ex_fname2);
			}
			
			$new_dat=[
			 'course_id'=>$request->course_id_edit,
			 'subject_id'=>$request->subject_id_edit,
			 'chapter_id'=>$request->chapter_id_edit,
			 'title'=>$request->title_edit,
			 'pdf_file'=>$fname2,
			 'description'=>$request->description_edit,
			];
			
			$result=PdfFile::whereId($id)->update($new_dat);
			
			if($result)
			{
				Session::flash('message', 'success#Pdf successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Some details are missing. try again');
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			Session::flash('message', 'danger#Something wrong, Try again.');
		}
		
		return redirect('pdf-files');
  }


	
   public function destroy($id)
	{
		$dat=PdfFile::findorfail($id);
		
			if(!empty($dat))
			{
				Storage::disk('spaces')->delete("pdf_files"."/".$dat->pdf_file);
				
				$dat->delete();
				return response()->json(['msg' =>'Pdf successfuly removed.!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				
	}
		
	
	public function activate_deactivate($op,$id)
	{
		if($op==1)
		{
		   $new=['status'=>1];
		}
		else
		{	
		   $new=['status'=>0];
		}

		$result=PdfFile::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Pdf successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Pdf successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}
	
	
}
