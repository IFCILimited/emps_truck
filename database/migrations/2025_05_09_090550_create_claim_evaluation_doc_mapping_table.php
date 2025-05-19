<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimEvaluationDocMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_evaluation_doc_mapping', function (Blueprint $table) {
            $table->id();
            $table->integer('claim_id');
            $table->integer('evl_stage_id');
            $table->integer('doc_id');
            $table->integer('upload_id')->nullable();
            $table->string('doc_name')->nullable();
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
        Schema::dropIfExists('claim_evaluation_doc_mapping');
    }
}
