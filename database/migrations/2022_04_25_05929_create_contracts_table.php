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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            $table->bigInteger('contract_type_id')->unsigned();
            $table->foreign('contract_type_id')->references('id')->on('contract_types')->onDelete('CASCADE');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->bigInteger('designation_id')->unsigned();
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('CASCADE');
            $table->boolean('is_active')->default(0);
            $table->bigInteger('staff_category_id')->unsigned();
            $table->foreign('staff_category_id')->references('id')->on('staff_types')->onDelete('CASCADE');
            $table->bigInteger('staff_type_id')->unsigned();
            $table->foreign('staff_type_id')->references('id')->on('staff_types')->onDelete('CASCADE');
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
        Schema::dropIfExists('contracts');
    }
};
