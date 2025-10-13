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
		Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100);
			$table->unsignedBigInteger('student_id')->index();
			$table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
			$table->string('email',100)->nullable();
			$table->string('mobile',50)->unique();
			$table->string('password',150)->nullable();
            $table->integer('status')->nullable();
			$table->text('fcm_token')->nullable();
			$table->rememberToken();
            $table->timestamps();
        });
		Schema::enableForeignKeyConstraints();
		
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
