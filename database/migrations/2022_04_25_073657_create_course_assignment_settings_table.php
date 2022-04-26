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
        Schema::create('course_assignment_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('assigned_by')->nullable();
            $table->string('department_ids')->nullable();
            $table->string('pillar_ids')->nullable();
            $table->string('contract_type_ids')->nullable();
            $table->string('staff_type_ids')->nullable();
            $table->string('staff_designation_ids')->nullable();
            $table->string('user_ids')->nullable();
            $table->string('assignment_type')->nullable();
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
        Schema::dropIfExists('course_assignment_settings');
    }
};
