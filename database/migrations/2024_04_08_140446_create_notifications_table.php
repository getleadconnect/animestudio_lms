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
		Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('center_id')->nullable()->index();
			$table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
			$table->unsignedBigInteger('course_id')->nullable()->index();
			$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
			$table->unsignedBigInteger('notification_type_id')->nullable()->index();
			$table->foreign('notification_type_id')->references('id')->on('notification_types')->onDelete('cascade');
			$table->string('title',200)->nullable();
			$table->text('message')->nullable();
			$table->tinyinteger('push_status')->nullable()->default('0')->comment('1-send,0-no');
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
        Schema::dropIfExists('notifications');
    }
};
