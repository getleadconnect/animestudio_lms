<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestAllResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
		Schema::create('test_all_results', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('qbank_subject_id')->nullable()->index();
			$table->foreign('qbank_subject_id')->references('id')->on('qbank_subjects')->onDelete('cascade');
			$table->unsignedBigInteger('question_paper_id')->nullable()->index();
			$table->foreign('question_paper_id')->references('id')->on('question_papers')->onDelete('cascade');
			$table->unsignedBigInteger('student_id')->nullable()->index();
			$table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
			$table->unsignedBigInteger('question_id')->nullable()->index();
			$table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
			$table->integer('correct_answer')->nullable();
			$table->integer('answer')->nullable();
			$table->integer('wrong_status')->nullable();
			$table->integer('skipped_status')->nullable();
			$table->timestamps();
        });
		
		Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_all_results');
    }
}
