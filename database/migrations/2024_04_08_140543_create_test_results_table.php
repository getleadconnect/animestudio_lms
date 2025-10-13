<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
		Schema::create('test_results', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('question_paper_id')->nullable()->index();
			$table->foreign('question_paper_id')->references('id')->on('question_papers')->onDelete('cascade');
			$table->unsignedBigInteger('student_id')->nullable()->index();
			$table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
			$table->date('test_date')->nullable();
			$table->integer('total_questions')->nullable();
			$table->integer('answer')->nullable();
			$table->integer('wrong')->nullable();
			$table->integer('skipped')->nullable();
			$table->integer('marks')->nullable();
			$table->double('negative')->nullable();
			$table->double('score')->nullable();
			$table->integer('total_time')->nullable();
			$table->tinyinteger('status')->nullable();
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
        Schema::dropIfExists('test_results');
    }
}
