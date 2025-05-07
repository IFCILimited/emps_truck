<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimEvaluationStages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_evaluation_stages', function (Blueprint $table) {
            $table->id();
            $table->integer('claim_id');
            $table->integer('stage_id');
            $table->string('status', 10);
            $table->integer('upload_id')->nullable();
            $table->integer('auditor_id')->nullable();
            $table->boolean('visible_status');
            $table->integer('revert_stage')->nullable();
            $table->string('revert_remarks', 30);
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
        Schema::dropIfExists('claim_evaluation_stages');
    }
}
