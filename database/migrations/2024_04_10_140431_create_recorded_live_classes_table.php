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
		Schema::create('recorded_live_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('course_id')->nullable()->index();	
			$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
			$table->string('title',100)->nullable();
			$table->text('description')->nullable();
			$table->string('class_icon',150)->nullable();
			$table->string('video_file',150)->nullable();
			$table->string('duration',50)->nullable();
			$table->string('class_by',100)->nullable();
			$table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('recorded_live_classes');
    }
};
