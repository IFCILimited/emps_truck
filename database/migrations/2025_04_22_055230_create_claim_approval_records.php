<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimApprovalRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_approval_records', function (Blueprint $table) {
            // Foreign key constraints
            $table->foreign('evl_stage_id')
                ->references('id')
                ->on('claim_evaluation_stages')
                ->onDelete('cascade'); // Optional: cascade on delete

            $table->foreign('evl_status_id')
                ->references('id')
                ->on('claim_evaluation_status')
                ->onDelete('cascade'); // Optional: cascade on delete
            $table->id();
            $table->unsignedBigInteger('claim_id');
            $table->string('vin_chassis_no');
            $table->integer('s_no');
            $table->unsignedBigInteger('oem_id');
            $table->unsignedBigInteger('evl_stage_id');
            $table->decimal('amount', 15, 2);
            $table->decimal('rejected_amount', 15, 2);
            $table->decimal('withheld_amount', 15, 2);
            $table->unsignedBigInteger('evl_status_id');
            $table->string('remarks')->nullable();
            $table->json('remarks_id')->nullable();
            $table->boolean('visible_status');
            $table->timestamp('date_of_payment')->nullable();
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
        Schema::dropIfExists('claim_approval_records');
    }
}
