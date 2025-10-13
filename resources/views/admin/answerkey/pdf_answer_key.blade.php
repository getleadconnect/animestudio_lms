<!DOCTYPE html>

<html lang="en">
<head>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Aim - Answer key</title>
<style>
.td1 {  border-bottom:1px solid #e4e4e4;  text-align:left;  font-size: 25px;}
.td3 {  border-bottom:1px solid #e4e4e4;  text-align:left;  font-size: 25px;}
.center{  text-align:center;  font-size: 18px;}
.th1{  border-bottom:1px solid #e4e4e4;  text-align:left;  font-size: 25px;}
.td2{    font-size: 13px;}
.wages{font-size: 11px;margin-left: 320px;text-align:left;}
table{font-size:10px;}
p{font-size:13px;	}
.quest{	font-weight:500;font-size:13px;;}
p.st-quest{	font-weight:500;font-size:13px;margin-left:25px;}

</style>
</head>

@php

$stid=$_GET['student_id'];
$qpid=$_GET['qpaper_id'];

$date=date('Y-m-d');

	$where1=['student_id'=>$stid,'question_paper_id'=>$qpid];  
	
	$r1=App\Models\TestResult::where($where1)->get()->count();
	
	
	if($r1>0)
	{
		$mtresults=App\Models\Question::where('question_paper_id',$qpid)->orderBy('id','ASC')->get();
	}
	else
	{	
		$mtresults=array();
	}
	
	$qpaper=App\Models\QuestionPaper::whereId($qpid)->get()->first();

	$str=['question_paper_id'=>$qpid,'student_id'=>$stid];
	$questresult=App\Models\TestAllResult::where($str)->orderBy('id','ASC')->get();
	 
	$qpname="";
	$scna="";
	 
 if(!empty($qpaper))
 {
	 $qpname=$qpaper->question_paper_name; 
 }
 else
 {
	 $qpname=""; 
 }


@endphp

<body style="padding:10px 30px 10px 30px;">
 
 <table width="100%"><tr><td class="center" colspan=3><h3>Test Answer Key</h3></td></tr><br>
 <tr><td class="td2" width="70px"><b>Q_Paper</td><td class="td2">&nbsp;:</td><td class="td2" style="padding-left:10px;">{{$qpname}}</b></td></tr>
 <tr><td colspan=3> </td></tr>
  </table>
  <hr>
 <table width="100%">
 <tr>
 <td width="33%"><span style="background-color:green;font-size:15px;">&nbsp;&nbsp;&nbsp;&nbsp;</span> &nbsp;<span style="font-size:15px;">Correct</span></td>
 <td width="33%">&nbsp;&nbsp;&nbsp;&nbsp;<span style="background-color:red;font-size:15px;">&nbsp;&nbsp;&nbsp;&nbsp;</span> &nbsp;<span style="font-size:15px;">Wrong</span> </td>
 <td width="33%"><span style="background-color:blue;font-size:15px;">&nbsp;&nbsp;&nbsp;&nbsp;</span> &nbsp;<span style="font-size:15px;">Skipped</span> </td></tr>
 </table>
  <hr>

 @php
  $key=1;
  $ans="";
  if(!empty($mtresults))
  {
	foreach ($mtresults as $key => $value) 
	{
			$str=['question_id'=>$value->id, 'question_paper_id'=>$value->question_paper_id,'student_id'=>$stid];  ///.date('Y-m-d')."'";
			$mr=App\Models\TestAllResult::where($str)->get()->first();

		//wrong answer
		
		      $value1="A. ".$value->answer1;
			  $value2="B. ".$value->answer2;
			  $value3="C. ".$value->answer3;
			  $value4="D. ".$value->answer4;
		  
	  if(!empty($mr))
	  {	
	      if($mr->answer==1)
		  { 
			  $value1="<span style='color:red;font-weight:600;'>A. ".$value->answer1."</span>";
		  }
		  else if($mr->answer==2)
		  {
			  $value2="<span style='color: red;font-weight:600;'>B. ".$value->answer2."</span>";
		  }
		  else if($mr->answer==3)
		  {
			  $value3="<span style='color:red;font-weight:600;'>C. ".$value->answer3."</span>";
		  }
		  else if($mr->answer==4)
		  {
			  $value4="<span style='color:red;font-weight:600;'>D. ".$value->answer4."</span>";
		  }
	  }
		  
	  //correct answer
	  
	  if($value->correct_answer==1)
	  {
		$ans="A";
		$value1="<span style='Color:green;font-weight:600;'>A. ".$value->answer1."</span>";
	  }
	  else if($value->correct_answer==2)
	  {
		$ans="B";
		 $value2="<span style='Color:green;font-weight:600;'>B. ".$value->answer2."</span>";
	  }
	  else if($value->correct_answer==3)
	  {
		$ans="C";
		 $value3="<span style='Color:green;font-weight:600;'>C. ".$value->answer3."</span>";
	  }
	  else if($value->correct_answer==4)
	  {
		$ans="D";
		 $value4="<span style='Color:green;font-weight:600;'>D. ".$value->answer4."</span>";
	  }
	  
	  
	  if(!empty($mr))
	  {		
	      if($mr->answer==0)
		  {
			 if($value->correct_answer==1)
			 { 
				$ans="A";
				$value1="<span style='Color:blue;font-weight:600;'>A. ".$value->answer1."</span>";
			 }
			  else if($value->correct_answer==2)
			  {
				$ans="B";
				 $value2="<span style='Color:blue;font-weight:600;'>B. ".$value->answer2."</span>";
			  }
			  else if($value->correct_answer==3)
			  {
				 $ans="C";
				 $value3="<span style='Color:blue;font-weight:600;'>C. ".$value->answer3."</span>";
			  }
			  else if($value->correct_answer==4)
			  {
				$ans="D";
				$value4="<span style='Color:blue;font-weight:600;'>D. ".$value->answer4."</span>";
			  }
		  }
	  }
@endphp
  	 <p class='quest' >{!!"Q-".($key+1).":&nbsp".$value->question !!}</p>
	 <p class='st-quest' >{!!$value1!!}</span></p>
	 <p class='st-quest' >{!!$value2!!}</p>
	 <p class='st-quest' >{!!$value3!!}</p>
     <p class='st-quest' >{!!$value4!!}</p>
	 <p class='st-quest' style="font-size:13px;font-weight:600;">Answer&nbsp;:&nbsp; <b>{!!$ans!!}</b></p>
	
	<hr>
   @php
	$key++;
    }
  }
  else
  {
	 echo "<br><br><label style='color:red;font-size:35px;padding:25px;'>Result not found.</label>";
  }
  
@endphp
</body>


<script src="{{ asset('plugins/general/jquery/dist/jquery.js')}}"></script>
 <script>

document.addEventListener('contextmenu', event => event.preventDefault());

document.onkeydown = function(e) {
        if (e.ctrlKey && 
            (e.keyCode === 67 || 
             e.keyCode === 86 || 
             e.keyCode === 85 || 
             e.keyCode === 117)) {
            return false;
        } else {
            return true;
        }
};

$(document).keypress("u",function(e) {
  if(e.ctrlKey)
  {
return false;
}
else
{
return true;
}
});
 </script>
</body>
</html>