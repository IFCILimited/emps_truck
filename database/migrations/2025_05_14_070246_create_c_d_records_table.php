<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCDRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('cd_records', function (Blueprint $table) {
    $table->id();
    $table->string('cd_number')->unique();
    $table->string('present_owner_name');
    $table->integer('vehicle_gvw');
    $table->string('scrapped_vin');
    $table->enum('status_flag', ['vscrap', 'digielv']);
    $table->date('issue_date');
    $table->date('valid_upto_date');
    $table->string('new_owner_name')->nullable();
    $table->string('new_registration_no')->nullable();
    $table->date('new_registration_date')->nullable();
    $table->string('new_vin')->nullable();
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
        Schema::dropIfExists('c_d_records');
    }
}
