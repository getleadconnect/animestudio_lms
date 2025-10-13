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
		Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('center_id')->nullable()->index();
			$table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
			$table->string('course_name',100)->nullable();
			$table->unsignedBigInteger('course_category_id')->nullable()->index();
			$table->foreign('course_category_id')->references('id')->on('course_category')->onDelete('cascade');
			$table->unsignedBigInteger('course_type_id')->nullable()->index();
			$table->foreign('course_type_id')->references('id')->on('course_types')->onDelete('cascade');
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->string('course_wide_icon',100)->nullable();
			$table->string('course_square_icon',100)->nullable();
			$table->double('rate')->nullable();
			$table->double('discount_rate')->nullable();
			$table->double('ios_rate')->nullable();
			$table->string('app_store_product_id',100)->nullable();
			$table->string('subscription_type',50)->nullable();
			$table->string('video_file',150)->nullable();
			$table->text('description')->nullable();
			$table->longtext('course_details')->nullable();
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
        Schema::dropIfExists('courses');
    }
};
