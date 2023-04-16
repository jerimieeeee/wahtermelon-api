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
        Schema::create('lib_weight_for_heights', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('age_min');
            $table->unsignedInteger('age_max');
            $table->decimal('height_cm', 5, 2);
            $table->decimal('weight_min', 5, 2);
            $table->decimal('weight_max', 5, 2);
            $table->enum('gender', ['M', 'F']);
            $table->string('wt_class', 25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_weight_for_heights');
    }
};
