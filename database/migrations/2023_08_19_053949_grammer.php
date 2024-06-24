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
        Schema::create('grammers', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("level_id")->unsigned()->nullable();
            $table->foreign("level_id")->references("id")
                ->on("levels")->onDelete("cascade")->nullable();

            $table->string('text');
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
