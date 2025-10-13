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
        Schema::create('centers', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('center_name',200)->nullable();
			$table->string('address',500)->nullable();
			$table->string('email',100)->nullable();
			$table->string('mobile',50)->nullable();
			$table->integer('added_by')->nullable();
			$table->tinyinteger('status')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};
