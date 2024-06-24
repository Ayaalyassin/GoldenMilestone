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
        Schema::create('answerlevels', function (Blueprint $table) {
            $table->id();
            $table->longText("answer_text");
            $table->boolean("status")->default(false);

            $table->bigInteger("questionlevel_id")->unsigned()->nullable();
            $table->foreign("questionlevel_id")->references("id")
                ->on("questionlevels")->onDelete("cascade")->nullable();

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
