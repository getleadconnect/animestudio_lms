<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToModel,  WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

	protected $qpaper_id;

  public function __construct($qpid)
  {
	 $this->qpaper_id=$qpid;
  }

  public function model(array $row)
    {
        return new Question([
			 'question_paper_id'=>$this->qpaper_id,
			 'qbank_subject_id'=>$row['qbank_subject_id'],
			 'question'=>$row['question'],
			 'answer1'=>$row['answer1'],
			 'answer2'=>$row['answer2'],
			 'answer3'=>$row['answer3'],
			 'answer4'=>$row['answer4'],
			 'correct_answer'=>$row['correct_answer']
        ]);
    }
}
