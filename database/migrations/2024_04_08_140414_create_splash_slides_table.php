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
        Schema::create('splash_slides', function (Blueprint $table) {
			$table->bigIncrements('id');
		    $table->string('title',100)->nullable();
			$table->text('description')->nullable();
			$table->string('slide_image',150)->nullable();
			$table->integer('slide_position')->nullable();
			$table->tinyinteger('status')->nullable();
			$table->integer('added_by')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('splash_slides');
    }
};
