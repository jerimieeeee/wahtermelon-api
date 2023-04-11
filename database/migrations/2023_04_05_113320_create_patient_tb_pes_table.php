<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_tb_pes', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUlid('patient_tb_case_findings_id')->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();

            $table->char('abdomen',2);
            $table->char('amuscles',2);
            $table->char('bcg',2);
            $table->char('cardiovascular',2);
            $table->char('endocrine',2);
            $table->char('extremities',2);
            $table->char('ghealth',2);
            $table->char('gurinary',2);
            $table->char('lnodes',2);
            $table->char('neurological',2);
            $table->char('oropharynx',2);
            $table->char('skin',2);
            $table->char('thoraxlungs',2);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_tb_pes');
    }
};
