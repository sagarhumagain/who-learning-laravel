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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('primary_contact')->nullable();
            $table->string('secondary_contact')->nullable();
            $table->string('profile')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->bigInteger('supervisor_user_id')->unsigned();
            $table->foreign('supervisor_user_id')->references('id')->on('users')->onDelete('NO ACTION');
            $table->text('address')->nullable();
            $table->string('signature')->nullable();
            $table->string('emp_code')->unique()->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
