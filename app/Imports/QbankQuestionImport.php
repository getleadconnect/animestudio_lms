<?php

namespace App\Imports;

use App\Models\QbankQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QbankQuestionImport implements ToModel,  WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

  protected $subid;

  public function __construct($subid)
  {
     $this->subid=$subid;
  }

    public function model(array $row)
    {
        return new QbankQuestion([
             'qbank_subject_id'=>$this->subid,
			 'question'=>$row['question'],
			 'answer1'=>$row['answer1'],
			 'answer2'=>$row['answer2'],
			 'answer3'=>$row['answer3'],
			 'answer4'=>$row['answer4'],
			 'correct_answer'=>$row['correct_answer']
        ]);
    }
}
