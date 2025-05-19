<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCdInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cd_information', function (Blueprint $table) {
           $table->id();

            $table->string('cd_number')->unique();
            $table->string('cd_owner_name');
            $table->string('vehicle_gvw');
            $table->string('vin_scrapped');
            $table->string('status_flag');
            $table->date('cd_issue_date');
            $table->date('cd_validity_upto');
            $table->integer('buyer_detail_id');
            $table->string('vin_chassin_no');

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
        Schema::dropIfExists('cd_information');
    }
}
