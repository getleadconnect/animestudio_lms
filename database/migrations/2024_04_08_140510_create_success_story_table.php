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
		Schema::create('success_story', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name',100)->nullable();
			$table->string('place',100)->nullable();
			$table->text('description')->nullable();
			$table->string('story_icon',150)->nullable();
			$table->string('story_video',150)->nullable();
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
        Schema::dropIfExists('success_story');
    }
};
