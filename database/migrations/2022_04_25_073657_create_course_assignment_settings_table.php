<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_assignment_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('assigned_by_user_id')->constrained('users')->onDelete('cascade');
            $table->string('department_ids')->default('[]');
            $table->string('pillar_ids')->default('[]');
            $table->string('contract_type_ids')->default('[]');
            $table->string('staff_type_ids')->default('[]');
            $table->string('staff_designation_ids')->default('[]');
            $table->string('user_ids')->default('[]');
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
