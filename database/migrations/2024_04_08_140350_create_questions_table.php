<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
		Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('qbank_question_id')->nullable()->index();
			$table->foreign('qbank_question_id')->references('id')->on('qbank_questions')->onDelete('cascade');
			$table->unsignedBigInteger('qbank_subject_id')->nullable()->index();
			$table->foreign('qbank_subject_id')->references('id')->on('qbank_subjects')->onDelete('cascade');
			$table->unsignedBigInteger('question_paper_id')->nullable()->index();
			$table->foreign('question_paper_id')->references('id')->on('question_papers')->onDelete('cascade');
			$table->tinyInteger('question_type')->default(0);
			$table->text('question')->nullable();
			$table->string('answer1',1000)->nullable();
			$table->string('answer2',1000)->nullable();
			$table->string('answer3',1000)->nullable();
			$table->string('answer4',1000)->nullable();
			$table->integer('correct_answer')->nullable();
			$table->timestamps();
        });
		Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
