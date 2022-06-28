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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 10);//slug of cut link
            $table->text('address');//original address of link
            $table->bigInteger('transitions_limit')->default(0); // count of all available transitions
            $table->bigInteger('current_transitions')->default(0); //count of current transitions
            $table->boolean('at_work')->default(true);//Whether the link works (set false if the link time has been exhausted, or the number of transitions hits has reached a maximum)
            $table->dateTime('expiration_date');//expiration date
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
};
