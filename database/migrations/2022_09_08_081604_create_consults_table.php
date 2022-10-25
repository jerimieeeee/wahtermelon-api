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
        Schema::create('consults', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->uuid('user_id')->index()->constrained();
            $table->timestamps();
            $table->dateTime('consult_end')->nullable();
            $table->foreignUuid('physician_id')->nullable();
            $table->boolean('is_pregnant')->nullable();
            $table->boolean('consult_done')->nullable();
            $table->char('pt_group', 2);

            $table->foreign('physician_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consults');
    }
};
