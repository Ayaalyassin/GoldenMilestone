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
        Schema::create('questionlevels', function (Blueprint $table) {
            $table->id();
            $table->longText("level_text");

            /*$table->bigInteger("user_id")->unsigned()->default(0)->nullable();
            $table->foreign("user_id")->references("id")
            ->on("users")->onDelete("cascade")->default(0)->nullable();*/

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
