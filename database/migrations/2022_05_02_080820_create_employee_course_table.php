<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('employee_course', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('employee_id')->unsigned()->index();
      $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
      $table->bigInteger('course_id')->unsigned()->index();
      $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
      $table->string('certificate_path')->nullable();
      $table->date('completed_date');
      $table->boolean('is_approved')->default(False);
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('employee_course');
  }
};
