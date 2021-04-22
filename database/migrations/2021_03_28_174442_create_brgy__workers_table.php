<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrgyWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brgy__workers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('brgy_id');
            $table->unsignedInteger('brgy_admin_id');
            $table->string('brgy_worker_username');
            $table->string('brgy_worker_password');
            $table->string('brgy_worker_fullname');
            $table->string('brgy_worker_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brgy__workers');
    }
}
