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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('suffix_name');
            $table->date('birthdate');
            $table->enum('gender', ['M', 'F']);
            $table->string('mobile_number',13);
            $table->boolean('is_active')->default(1);
            $table->string('photo_url');
            $table->char('tin_number', 9);
            $table->char('accreditation_number', 14);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
