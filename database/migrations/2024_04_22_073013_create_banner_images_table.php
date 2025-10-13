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
		Schema::create('banner_images', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('course_id')->nullable()->index();
			$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
			$table->unsignedBigInteger('course_category_id')->nullable()->index();
			$table->foreign('course_category_id')->references('id')->on('course_category')->onDelete('cascade');
			$table->string('banner_image',150)->nullable();
			$table->string('banner_link',150)->nullable();
			$table->tinyinteger('banner_type')->nullable();
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
        Schema::dropIfExists('banner_images');
    }
};
