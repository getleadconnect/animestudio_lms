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
		Schema::create('pdf_files', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('course_id')->nullable()->index();
			$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
			$table->unsignedBigInteger('subject_id')->nullable()->index();
			$table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
			$table->unsignedBigInteger('chapter_id')->nullable()->index();
			$table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
			$table->string('title',100)->nullable();
			$table->string('pdf_icon',100)->nullable();
			$table->string('pdf_file',200)->nullable();
			$table->text('description')->nullable();
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
        Schema::dropIfExists('pdf_files');
    }
};
