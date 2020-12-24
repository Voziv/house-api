<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Temperatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'temperatures',
            function (Blueprint $table) {
                $table->id();

                $table->string('temperature')->nullable();
                $table->string('humidity')->nullable();

                $table->unsignedBigInteger('room_id');
                $table->foreign('room_id')->references('id')->on('rooms');

                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
