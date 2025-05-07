<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimEvaluationData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_evaluation_data', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('claim_id');
            $table->string('claim_no');
            $table->integer('s_no');
            $table->string('vehicle_segment'); 
            $table->string('vin_chassis_no');
            $table->decimal('approved_incentive', 15, 2);
            $table->decimal('eligible_incentive', 15, 2);
            $table->string('oemname');
            $table->unsignedBigInteger('oem_id');
            $table->string('remark');
            $table->string('status');
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
        Schema::dropIfExists('claim_evaluation_data');
    }
}
