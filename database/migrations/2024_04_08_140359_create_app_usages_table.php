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
        Schema::create('app_usages', function (Blueprint $table) {
            $table->bigIncrements('id');
		    $table->unsignedBigInteger('student_id')->nullable()->index();
			$table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
			$table->integer('usage_seconds')->nullable();
			$table->timestamps();
        });
		Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_usages');
    }
	
};
