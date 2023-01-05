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
        Schema::create('lib_laboratory_categories', function (Blueprint $table) {
            $table->id();
            $table->char('lab_code',10)->index();
            $table->string('field_name',50);
            $table->string('field_desc',50);
            $table->string('group_cat',50)->nullable();
            $table->char('range_cat',2)->nullable();
            $table->string('nv_min',30)->nullable();
            $table->string('nv_max',30)->nullable();
            $table->string('nv_uom',30)->nullable();
            $table->unsignedInteger('sequence_id');
            $table->boolean('field_active')->default(0);

            $table->foreign('lab_code')->references('code')->on('lib_laboratories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_laboratory_categories');
    }
};
