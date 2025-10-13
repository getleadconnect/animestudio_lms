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
		Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('center_id')->nullable()->index();
			$table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
			$table->string('student_name',100)->nullable();
			$table->date('date_of_birth')->nullable();
			$table->integer('district_id')->nullable();
			$table->string('place',50)->nullable();
			$table->string('email',50)->nullable();
			$table->string('mobile',50)->nullable();
			$table->tinyinteger('status')->nullable();
			$table->integer('staff_id')->nullable();
			$table->integer('learn_category_id')->nullable();
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
        Schema::dropIfExists('students');
    }
};
