<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowStage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_stage', function (Blueprint $table) {
            $table->id('stage_id'); // Auto-incrementing primary key
            $table->string('stage_name', 50)->unique();
            $table->integer('stage_order');
            $table->unsignedBigInteger('previous_stage_id')->nullable();
            $table->unsignedBigInteger('next_stage_id')->nullable();
            $table->timestamps();

            // Self-referencing foreign keys
            $table->foreign('previous_stage_id')
                  ->references('stage_id')
                  ->on('workflow_stages')
                  ->nullOnDelete();

            $table->foreign('next_stage_id')
                  ->references('stage_id')
                  ->on('workflow_stages')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflow_stage');
    }
}
