<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('appointment_id')->constrained('appointments');
            //$table->foreignId('appointment_id')->references('id')->on('appointments')->cascadeOnUpdate();

            $table->bigInteger("appointment_id")->unsigned();
            $table->foreign("appointment_id")->references("id")
            ->on("appointments")->onDelete("cascade");

            //$table->foreignId('user_id')->constrained('users');

            $table->bigInteger("user_id")->unsigned();
            $table->foreign("user_id")->references("id")
            ->on("users")->onDelete("cascade");

            $table->date('date_order')->defult('0-0-0');
            //$table->boolean("status")->default(true);
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
        //
    }
};
