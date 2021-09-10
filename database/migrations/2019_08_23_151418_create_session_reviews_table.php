<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id');
            $table->integer('attendee_id');
            $table->integer('rate');
            $table->text('comment');
            $table->dateTime('date');

            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('attendee_id')->references('id')->on('attendees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_reviews');
    }
}
