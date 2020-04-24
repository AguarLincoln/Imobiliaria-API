<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealStatePhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_state_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('real_state_id');
            $table->string('photo_reference');
            $table->boolean('is_thumb');

            $table->timestamps();

            $table->foreign('real_state_id')->references('id')->on('real_states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('state_photos');
    }
}
