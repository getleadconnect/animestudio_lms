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
        Schema::create('subject_proficiency', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('student_id')->nullable()->index();
			$table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
			$table->unsignedBigInteger('qbank_subject_id')->nullable()->index();
			$table->foreign('qbank_subject_id')->references('id')->on('qbank_subjects')->onDelete('cascade');
			$table->string('subject_name',100)->nullable();
			$table->double('subject_average')->nullable();
			$table->timestamps();
        });
		Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_proficiency');
    }
};
