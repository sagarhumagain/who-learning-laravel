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
        Schema::create('contract_type_designation', function (Blueprint $table) {
          $table->id();
          $table->bigInteger('contract_type_id')->unsigned()->index();
          $table->foreign('contract_type_id')->references('id')->on('contract_types')->onDelete('cascade');
          $table->bigInteger('designation_id')->unsigned()->index();
          $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
          $table->timestamps();
        });

        Schema::create('contract_type_staff_category', function (Blueprint $table) {
          $table->id();
          $table->bigInteger('contract_type_id')->unsigned()->index();
          $table->foreign('contract_type_id')->references('id')->on('contract_types')->onDelete('cascade');
          $table->bigInteger('staff_category_id')->unsigned()->index();
          $table->foreign('staff_category_id')->references('id')->on('staff_categories')->onDelete('cascade');
          $table->timestamps();
        });

        Schema::create('contract_type_staff_type', function (Blueprint $table) {
          $table->id();
          $table->bigInteger('contract_type_id')->unsigned()->index();
          $table->foreign('contract_type_id')->references('id')->on('contract_types')->onDelete('cascade');
          $table->bigInteger('staff_type_id')->unsigned()->index();
          $table->foreign('staff_type_id')->references('id')->on('staff_types')->onDelete('cascade');
          $table->timestamps();
        });

        Schema::create('staff_category_staff_type', function (Blueprint $table) {
          $table->id();
          $table->bigInteger('staff_category_id')->unsigned()->index();
          $table->foreign('staff_category_id')->references('id')->on('staff_categories')->onDelete('cascade');
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
        Schema::dropIfExists('contract_type_designation');
        Schema::dropIfExists('contract_type_staff_category');
        Schema::dropIfExists('contract_type_staff_type');
        Schema::dropIfExists('staff_category_staff_type');
    }
};
