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
		Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('course_id')->nullable()->index();
			$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
			$table->string('subject_name',100)->nullable();
			$table->text('description')->nullable();
			$table->string('subject_icon',150)->nullable();
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
        Schema::dropIfExists('subjects');
    }
};
