@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')
<style>
.card-body{
	padding-top:2px !important;
}

.a-close
{
	font-size:18px;
	font-weight:600;
	color:red;
}

#selected_quest td,th,tr
 {
	 border:1px solid #d4d4d4;
	 line-height:30px;
	 padding-left:10px;
 }
 
 .opt-radio
 {
	 width:20px ;
	 height:20px ;
	 display:flex ;
	 margin:auto ;
	 border-color:#4460eb ;
 }

</style>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Prepare Question Paper</div>
 
             <!-- <div class="ms-auto">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary">Settings</button>
                  <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                  </div>
                </div>
              </div>  -->
            </div>
            <!--end breadcrumb-->

              <div class="card">
                <!--<div class="card-header p-y-3">
				<div class="row">
				<div class="col-lg-9 col-xl-9 col-xxl-9 col-9">
                  <h6 class="mb-0 pt5">Questions List</h6>
				  </div>
				  <div class="col-lg-3 col-xl-3 col-xxl-3 col-3 text-right">
					<!-- contents here -->
				  <!--</div>

				  </div>
                </div> -->
				
                <div class="card-body">
					   			
                   <div class="row">
                   
				   <div class="col-8 col-lg-8 col-xl-8 col-xxl-8" style="border-right:1px solid #e4e4e4;">

						<div class="row mt-2">
							<div class="col-5 col-lg-5 col-xl-5 col-xxl-5">
							<div class="form-group">
								<label>Select Subject</label>
								<select class="form-control mb-3" id="flt_qbank_subject_id" placeholder="subject" required>
								<option value="">select</option>
								@foreach($subj as $r)
								<option value="{{$r->id}}">{{$r->subject_name}}</option>
								@endforeach
								</select>
							</div>
							</div>
						</div>
	
					 
                      <div class="card shadow-none w-100">
                        <!--<div class="card-body">-->
                          <div class="table-responsive">
	
                             <table id="datatable" class="table align-middle" style="width:120% !important;" >
                               <thead class="table-light">
                                 <tr>
									<th class="no-content">#</th>
									<th >Id</th>
									<th>Subject</th>
									<th>question</th>
								</tr>
                               </thead>
                               <tbody>
						
                               </tbody>
                             </table>
				 
                          </div>
                       <!-- </div>-->
                      </div> 
					  
                    </div>
					
					 <div class="col-4 col-lg-4 col-xl-4 col-xxl-4" style="background:#eff3f5;">
						
						<h6 class="mt-2" style="color:blue;font-size:14px;"><u>Add Questions to Question Paper</u> </h6>
						
						
						<form id="saveQuestions"  enctype="multipart/form-data">
						@csrf
						
						<input type="hidden" name="quest_id" id="quest_id">
						
						    <div class="form-group">
								<label> Select Option</label>
								
								<div class="row mt-2 mb-3">
								
								<div class="col-lg-6 col-xl-6 col-xxl-6">
									<div class="form-check">
										<input class="form-check-input free_test opt-radio" type="radio"  name="free_test" value="2">
										<label class="form-check-label" for="free_test_edit2">&nbsp;&nbsp;TEST EXAMS</label>
									</div>
								</div>
								<div class="col-lg-6 col-xl-6 col-xxl-6">
										<div class="form-check">
											<input class="form-check-input free_test opt-radio" type="radio"  name="free_test" value="1" ">
											<label class="form-check-label" for="free_test_edit1">&nbsp;&nbsp;FREE EXAMS</label>
										</div>
								</div>
								
								</div>
								</div>

							<div class="form-group mt-2">
								<label >Select Course </label>
							    	<select class="form-control mb-3"  id="course_id" name="course_id" required>
										<option value="">--select--</option>
										@foreach($crs as $r)
										<option value="{{$r->id}}">{{$r->course_name}}</option>
										@endforeach
							        </select>
							</div>
	
							<!--<div class="form-group">
								<label >Select Subject </label>
							    	<select class="form-control mb-3"  id="subject_id" name="subject_id" required>
										<option value="">--select--</option>
										
							        </select>
							</div> -->
							
							<div class="form-group">
								<label >Question Paper </label>
							    	<select class="form-control" id="qpaper_id" name="qpaper_id" required>
										<option value="">--select--</option>
							        </select>
							</div>
							<div class="form-group row">
							<div class="col-lg-6">
								<label class="mt-2">Questions: <span id="total_quest" style="color:blue;font-weight:600;">0 Nos</span></label>
							</div>
							<div class="col-lg-6 text-right" style="right:20px !important;">
								<label class="mt-2 mb-2" style="color:blue;"><u>Selected - <span id="question_count" style="font-weight:600;font-size:16px;">0</span>&nbsp;Nos </u></label>
							</div>
							
							</div>
													

						<div style="overflow:auto;height:300px;">
							<table border=1 id="tb_questions" style="width:150%;">
                               <thead class="table-light">
                                 <tr>
									<th class="no-content" width="50px">#</th>
									<th width="50px">SlNo</th>
									<th>Subject</th>
									<th>question</th>
									
								</tr>
                               </thead>
                               <tbody id="tquestion">
                                   
                               </tbody>
							</table>	
						</div>
					
							<div class="form-group mt-2 mb-3 ">
							   <button type="submit" class="btnSaveQuest btn btn-primary btn-xs btn-sm"> Save Questions </button>
							</div>
						</form>
					</div>
										
                   </div><!--end row-->
                </div>
              </div>
 
@push('scripts')
<script>

$("#course_id").prop('disabled',true);
$("#qpaper_id").prop('disabled',true);

$(document).ready(function()
{
		$("#course_id").prop('disabled',true);
		$("#qpaper_id").prop('disabled',true);
		
		$("#course_id").prop('required',false);
		$("#qpaper_id").prop('required',false);
		
		$("#qpaper_id").html('<option value="">--select--</option>');
		
});


$(".free_test").change(function()
{
	var vl=parseInt($('input[name="free_test"]:checked').val());
	if(vl==1)
	{
		$("#course_id").prop('disabled',true);
		$("#qpaper_id").prop('disabled',false);
		
		$("#course_id").prop('required',false);
		$("#qpaper_id").prop('required',true);
	
		$("#course_id").val('');
		$("#qpaper_id").html('<option value="">--select--</option>');
		
		var id=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "get-free-question-papers",
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#qpaper_id").html(res);
			}
		});
		
	}
	else
	{
		$("#course_id").prop('disabled',false);
		$("#qpaper_id").prop('disabled',false);
		
		$("#course_id").prop('required',true);
		$("#qpaper_id").prop('required',true);
		
		$("#qpaper_id").html('<option value="">--select--</option>');
	}

});

function disabled()
{
		$("#course_id").prop('disabled',true);
		$("#qpaper_id").prop('disabled',true);
		$("#course_id").prop('required',true);
		$("#qpaper_id").prop('required',true);
		$("#qpaper_id").html('<option value="">--select--</option>');
}

$(".btnSaveQuest").prop('disabled',true);

$(".btnAdd").click(function()
{
	alert("Question added.!");
	$(".btnSaveQuest").prop('disabled',false);
});


$("form#saveQuestions").submit(function(e)
{
   e.preventDefault(); 
   
   var totquest=parseInt($("#question_count").html());
   
   if(totquest>0)
   {   
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('save-qpaper-questions')}}",
          type: 'post',
          data: formData,
		  dataType:'json',
          success: function (res) 
		  {
			 if(res.status==true)
			 {
				toastr.success(res.msg);
				$('#saveQuestions')[0].reset();
				$("#tquestion").html("");
				$(".btnSaveQuest").prop('disabled',true);
				$("#question_count").html(0);
				$("#total_quest").html(0);
				$('#flt_qbank_subject_id').val("");
				//$("#flt_qbank_subject_id").change().trigger();
				$('#datatable').DataTable().ajax.reload(null, false);
				disabled();
				
			 }
			 else
			 {
				toastr.error(res.msg); 
			 }
			  			  
          },
			cache: false,
			contentType: false,
			processData: false
		});
   }
   else
   {
	   alert("Question paper's questions are not selected!");
   }
});



var table = $('#datatable').DataTable({
	processing: true,
	serverSide: true,
	stateSave:true,
	paging     : true,
	pageLength :50,
	scrollX: true,
	
	'pagingType':"simple_numbers",
	'lengthChange': true,
		
	ajax:
	{
		url:"get-qbank-questions",
		data: function (data) 
		{
		   data.search = $('input[type="search"]').val();
		   data.searchSubjectId = $('#flt_qbank_subject_id').val();
		},
	},
	
	columnDefs:[
			     {"width":"40px","targets":0},
			   ],

	columns: [
		{"data": "selbtn" },
		{"data": "id" },
		{"data": "subj" },
		{"data": "quest" },
	],

});


$("#flt_qbank_subject_id").change(function()
{
	$('#datatable').DataTable().ajax.reload(null, false);
});


$("#course_id").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
		type: "GET",
		url: "get-question-papers-by-course-id"+"/"+id,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#qpaper_id").html(res);
		}
	});
});

/*$("#subject_id").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
		type: "GET",
		url: "get-question-papers-by-subject-id"+"/"+id,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#qpaper_id").html(res);
		}
	});
});*/


function check_question(qpid,qid)
{
	var data;
	jQuery.ajax({
		type: "GET",
		url: "check-question-already-added"+"/"+qpid+"/"+qid,
		dataType: 'json',
		//data: {vid: vid},
		async: false,
		success: function(res)
		{
		   data=res.status;
		   //callback.call(data);
		},
		error: function () {}
	});
	
	return data;
}


$('#datatable tbody').on( 'click', '.qselect', function ()
  {
	  	if($("#qpaper_id").val()=="")
		{
			alert("Please select Course and Question Paper for add questions!");
		}
		else
		{
			var qid=$(this).closest('tr').find('td').eq(1).text();
			var qpid=$("#qpaper_id").val();
			
			if(check_question(qpid,qid)==0)
			{
				$(".btnSaveQuest").prop('disabled',false);
				
				str1=$(this).closest('tr').find('td').eq(1).text()
				if($("#quest_id").val().indexOf(str1) != -1)
				{
					alert("Question already added.");
				}
				else
				{
					$(this).closest('tr').toggleClass('selected');
					   tdat='<tr><td style="padding:3px;width:40px;"><button type="button" class="delquest btn btn-danger btn-sm" style="padding: 0px 6px 1px 6px;">x</button>';
					   tdat+="</td><td style='padding:2px'>"+$(this).closest('tr').find('td').eq(1).text(); 
					   tdat+="</td><td style='padding:2px'>"+$(this).closest('tr').find('td').eq(2).text(); 
					   tdat+="</td><td style='padding:2px'>"+$(this).closest('tr').find('td').eq(3).html()+"</td></tr>"; 
					$("#tquestion").append(tdat);
					
					var totq=$('#tb_questions tr').length-1;
					//$("#totquestion1").html(totq);
					$("#question_count").html(totq);
					
					$(this).removeClass('btn-primary');
					$(this).addClass('btn-success');
					
					qids=$("#quest_id").val();
					qids=qids+$(this).closest('tr').find('td').eq(1).text()+",";
					$("#quest_id").val(qids);
				}
			}
			else
			{
				alert("This question already added.");
			}
		}
  });
  

  $("#tquestion").on('click', '.delquest', function () {
	  
      var rid=$(this).closest('tr').find('td').eq(1).text();
	  var totq=$('#tb_questions tr').length-2;
		//$("#totquestion1").html(totq);
		$("#question_count").html(totq);
		
		var tb=$("#datatable tbody");
		tb.find("tr").each(function(index, element)
		{
		var id = $(element).find('td').eq(1).text();
		if(id==rid)
		{
		   $(element).find('button.qselect').removeClass('btn-success');
		   $(element).find('button.qselect').addClass('btn-primary');
		   $(element).closest('tr').removeClass('selected');
		}
		});
	
	$(this).closest('tr').remove();
	
	quest_ids=$("#quest_id").val();
	rmid=rid+",";
	quest_ids=quest_ids.replace(rmid,"");
	$("#quest_id").val(quest_ids);
	
});

$("#qpaper_id").change(function()
{
	var qid=$(this).val();
	jQuery.ajax({
		type: "GET",
		url: "get-total-questions"+"/"+qid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
			$("#total_quest").html(res);
		}
	  });
});

$(document).on('click','.btnDel',function()
{
	Swal.fire({
	  title: "Are you sure?",
	  text: "You want to delete this question!",
	  icon: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#3085d6",
	  cancelButtonColor: "#d33",
	  confirmButtonText: "Yes, delete it!"
	}).then((result) => {
	  if (result.isConfirmed) {
		Swal.fire({
		  title: "Deleted!",
		  text: "Your file has been deleted.",
		  icon: "success"
		});
	  }
	});

});

	
$(document).on('click','#conf',function()
{
	if(confirm("Are you sure, delete this question?"))
	{
		alert("Question Removed.!");
	}
	
})



</script>
@endpush
@endsection
