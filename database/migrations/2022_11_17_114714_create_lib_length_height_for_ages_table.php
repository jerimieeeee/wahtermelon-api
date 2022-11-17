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
        Schema::create('lib_length_height_for_ages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('age_month');
            $table->decimal('length_min',5,2);
            $table->decimal('length_max',5,2);
            $table->enum('gender', ['M', 'F']);
            $table->string('lt_class',25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_length_height_for_ages');
    }
};
