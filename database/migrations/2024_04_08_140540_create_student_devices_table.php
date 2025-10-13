<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
		Schema::create('student_devices', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('student_id')->nullable()->index();
			$table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
			$table->string('mobile',100)->nullable();
			$table->string('version_release',100)->nullable();
			$table->string('manufacturer',100)->nullable();
			$table->string('model',100)->nullable();
			$table->string('androidid',100)->nullable();
			$table->string('device',100)->nullable();
			$table->tinyinteger('status')->nullable();
            $table->timestamps();
        });
		Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_devices');
    }
}
