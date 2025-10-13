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
		Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name',200)->nullable();
			$table->string('email',100)->nullable();
			$table->string('mobile',50)->nullable();
			$table->unsignedBigInteger('center_id')->nullable()->index();
			$table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
			$table->unsignedBigInteger('role_id')->nullable()->index();
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
			$table->string('password',200)->nullable();
			$table->tinyinteger('status')->nullable();
			$table->timestamps();
        });
		Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
