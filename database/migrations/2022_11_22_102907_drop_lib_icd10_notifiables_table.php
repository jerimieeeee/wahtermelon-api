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
        Schema::dropIfExists('lib_icd10_notifiables');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('lib_icd10_notifiables', function (Blueprint $table) {

            $table->integer('notifiable_cat' ,false,true)->length(1);
            $table->string('notifiable_name' ,100);
            $table->boolean('is_morbidity' ,1);
        });
    }
};
