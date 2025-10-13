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
	    Schema::create('question_papers', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->tinyinteger('free_test')->nullable();
		    $table->unsignedBigInteger('course_id')->nullable()->index();
			$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
			$table->unsignedBigInteger('subject_id')->nullable()->index();
			$table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
			$table->unsignedBigInteger('exam_tab_heading_id')->nullable()->index();
			$table->foreign('exam_tab_heading_id')->references('id')->on('exam_tab_headings')->onDelete('cascade');
			$table->string('question_paper_name',100)->nullable();
			$table->text('description')->nullable();
			$table->string('explanation_video',200)->nullable();
			$table->date('start_date')->nullable();
			$table->integer('duration')->nullable();
			$table->tinyinteger('status')->nullable();
			$table->integer('added_by')->nullable();
			$table->timestamps();
        });
		Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_papers');
    }
	
};
