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
	   Schema::create('staffs', function (Blueprint $table) {
            $table->BigIncrements('id');
			$table->unsignedBigInteger('center_id')->nullable()->index();
			$table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
			$table->string('staff_name',100)->nullable();
			$table->string('address',1000)->nullable();
			$table->string('email',100)->nullable();
			$table->string('mobile',50)->nullable();
			$table->string('referral_code',50)->nullable();
			$table->double('percentage')->nullable();
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
        Schema::dropIfExists('staffs');
    }
};
