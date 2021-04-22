<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrgyAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brgy__admins', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('brgy_id');
            $table->string('brgy_admin_fname');
            $table->string('brgy_admin_lname');
            $table->string('brgy_admin_postion');
            $table->string('brgy_admin_password');
            $table->string('brgy_admin_username');
            $table->string('brgy_admin_email');
            $table->integer('brgy_admin_cnum');
            // $table->foreign('brgy_id')->references('id')->on('barangays')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brgy__admins');
    }
}
