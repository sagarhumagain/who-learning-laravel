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
        Schema::create('employee_pillar', function (Blueprint $table) {
            $table->foreignId('employee_id')->constrained('users')->onDelete('RESTRICT');
            $table->foreignId('pillar_id')->constrained('pillars')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_pillar', function (Blueprint $table) {
            //
        });
    }
};
