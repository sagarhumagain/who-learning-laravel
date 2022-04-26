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
        Schema::create('designation_staff_types', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('designation_id')->unsigned()->index();
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
            $table->bigInteger('staff_type_id')->unsigned()->index();
            $table->foreign('staff_type_id')->references('id')->on('staff_types')->onDelete('cascade');
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
        Schema::dropIfExists('designation_staff_types');
    }
};
